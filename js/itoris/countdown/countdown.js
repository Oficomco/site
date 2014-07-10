if (!Itoris) {
	var Itoris = {};
}
Itoris.Countdown = Class.create({
	classPrefix : 'itoris_countdown_',
	counterTypeTextual : 'textual',
	counterTypeGraphical : 'graphical',
	initialize : function(boxId, seconds, config) {
		this.box = $(boxId);
		this.seconds = seconds;
		this.config = config;
		this.isCalculatedTimeBoxWidth = false;
		this.isCalculatedTimeBox = false;
		this.setSlideStep();
		if (this.box) {
			this.prepareTimeTemplate();
			this.countdown = new PeriodicalExecuter(this.start.bind(this), 1);
		}
	},
	setSlideStep : function() {
		switch(this.config.counter_size) {
			case 'large':
				this.slideStep = 49;
				break;
			case 'medium':
				this.slideStep = 40;
				break;
			case 'small':
				this.slideStep = 25;
				break;
			default:
				this.slideStep = 0;
		}
	},
	prepareTimeTemplate : function() {
		switch (this.config.format) {
			case 'ss':
				this.prepareTimeBlocks(this.seconds.toString().length, 'seconds');
				break;
			case 'mm':
				this.prepareTimeBlocks(Math.ceil(this.seconds / 60).toString().length, 'minutes');
				break;
			case 'hhm':
				this.prepareTimeBlocks(Math.floor(this.seconds / 3600).toString().length, 'hours');
				this.prepareTimeBlocks(2, 'minutes', 5);
				break;
			case 'hhms':
				this.prepareTimeBlocks(Math.floor(this.seconds / 3600).toString().length, 'hours');
				this.prepareTimeBlocks(2, 'minutes', 5);
				this.prepareTimeBlocks(2, 'seconds', 5);
				break;
			case 'dhm':
				this.prepareTimeBlocks(Math.floor(this.seconds / 86400).toString().length, 'days');
				this.prepareTimeBlocks(2, 'hours', 2);
				this.prepareTimeBlocks(2, 'minutes', 5);
				break;
			case 'dhms':
				this.prepareTimeBlocks(Math.floor(this.seconds / 86400).toString().length, 'days');
				this.prepareTimeBlocks(2, 'hours', 2);
				this.prepareTimeBlocks(2, 'minutes', 5);
				this.prepareTimeBlocks(2, 'seconds', 5);
				break;
		}
	},
	updateTimeTemplate : function() {
		var addTimeBackgroundAfterDays, addTimeBackgroundAfterHours, addTimeBackgroundAfterMinutes = false;
		switch (this.config.format) {
			case 'ss':
				this.insertTimeTypeInTemplate(this.seconds, 'seconds');
				break;
			case 'mm':
				this.insertTimeTypeInTemplate(Math.ceil(this.seconds / 60), 'minutes');
				break;
			case 'hhm':
				this.insertTimeTypeInTemplate(Math.floor(this.seconds / 3600), 'hours');
				this.insertTimeTypeInTemplate(Math.ceil((this.seconds % 3600) / 60), 'minutes', 5);
				addTimeBackgroundAfterHours = true;
				break;
			case 'hhms':
				this.insertTimeTypeInTemplate(Math.floor(this.seconds / 3600), 'hours');
				this.insertTimeTypeInTemplate(Math.floor((this.seconds % 3600) / 60), 'minutes', 5);
				this.insertTimeTypeInTemplate(Math.ceil(this.seconds % 60), 'seconds', 5);
				addTimeBackgroundAfterHours = true;
				addTimeBackgroundAfterMinutes = true;
				break;
			case 'dhm':
				this.insertTimeTypeInTemplate(Math.floor(this.seconds / 86400), 'days');
				this.insertTimeTypeInTemplate(Math.floor((this.seconds % 86400) / 3600), 'hours', 2);
				this.insertTimeTypeInTemplate(Math.ceil((this.seconds % 3600) / 60), 'minutes', 5);
				addTimeBackgroundAfterDays = true;
				addTimeBackgroundAfterHours = true;
				break;
			case 'dhms':
				this.insertTimeTypeInTemplate(Math.floor(this.seconds / 86400), 'days');
				this.insertTimeTypeInTemplate(Math.floor((this.seconds % 86400) / 3600), 'hours', 2);
				this.insertTimeTypeInTemplate(Math.floor((this.seconds % 3600) / 60), 'minutes', 5);
				this.insertTimeTypeInTemplate(Math.ceil(this.seconds % 60), 'seconds', 5);
				addTimeBackgroundAfterDays = true;
				addTimeBackgroundAfterHours = true;
				addTimeBackgroundAfterMinutes = true;
				break;
		}
		this.addClassToTimeBackgroundTypeDependsOnCounterSize('left');
		this.addClassToTimeBackgroundTypeDependsOnCounterSize('right');
		if (addTimeBackgroundAfterDays) {
			this.addClassToTimeBackgroundTypeDependsOnCounterSize('after_days');
		}
		if (addTimeBackgroundAfterHours) {
			this.addClassToTimeBackgroundTypeDependsOnCounterSize('after_time');
		}
		if (addTimeBackgroundAfterMinutes) {
			this.addClassToTimeBackgroundTypeDependsOnCounterSize('after_time', 1)
		}
		if (!this.isCalculatedTimeBoxWidth) {
			this.setWidthHeightToTimeBox();
		}
	},
	setWidthHeightToTimeBox : function() {
		var timeBox = this.box.select('.' + this.classPrefix + 'time')[0];
		this.box.setStyle({position: 'relative', left: 0});
		var timeBoxChildren = timeBox.childElements();
		var width = 0;
		timeBoxChildren.each(function(elm) {
			width += elm.getWidth();
		});
		this.isCalculatedTimeBox = true;
		if (!width) {
			return;
		}
		timeBox.setStyle({width: width + 'px', height: timeBoxChildren[0].getHeight() + 'px'});
		var timeBoxLabels = this.box.select('.' + this.classPrefix + 'time_labels')[0];
		var marginWidthLeft = this.box.select('.' + this.classPrefix + 'time_background_left')[0].getWidth();
		var marginWidthRight = this.box.select('.' + this.classPrefix + 'time_background_right')[0].getWidth();
		width -= (marginWidthLeft + marginWidthRight);
		timeBoxLabels.setStyle({width: width + 'px'});

		this.prepareTimeLabel('days', 0, timeBoxLabels);
		this.prepareTimeLabel('hours', 1, timeBoxLabels);
		this.prepareTimeLabel('minutes', 2, timeBoxLabels);
		this.prepareTimeLabel('seconds', 3, timeBoxLabels);
		this.isCalculatedTimeBoxWidth = true;
	},
	prepareTimeLabel : function(type, labelNum, timeBoxLabels) {
		if (this.box.select('.' + this.classPrefix + type)[0].childElements().length) {
			var boxWidth = this.box.select('.' + this.classPrefix + type)[0].getWidth();
			var labelBox = timeBoxLabels.select('div')[labelNum];
			labelBox.show();
			labelBox.setStyle({width: boxWidth + 'px'});
			if (type == 'days') {
				labelBox.setStyle({
					marginRight : this.box.select('.' + this.classPrefix + 'time_background_after_days')[0].getWidth() + 'px'
				});
			}
			if ((type == 'hours' && this.box.select('.' + this.classPrefix + 'minutes')[0].getWidth())
				|| (type == 'minutes' && this.box.select('.' + this.classPrefix + 'seconds')[0].getWidth())
			) {
				labelBox.setStyle({
					marginRight : this.box.select('.' + this.classPrefix + 'time_background_after_time')[0].getWidth() + 'px'
				});
			}
		}
	},
	addClassToTimeBackgroundTypeDependsOnCounterSize : function(backgroundType, elementCount) {
		elementCount = elementCount || 0;
		var timeBox = this.box.select('.' + this.classPrefix + 'time')[0];
		var backgroundTypeElm = timeBox.select('.' + this.classPrefix + 'time_background_' + backgroundType)[elementCount];
		backgroundTypeElm.addClassName(this.classPrefix + 'time_background_' + backgroundType + '_' +  this.config.counter_size + '_' + this.config.counter_type);
		if (this.config.counter_type == this.counterTypeTextual && backgroundType == 'after_time') {
			backgroundTypeElm.addClassName(this.classPrefix + 'after_time' + '_' + this.config.counter_size + '_' + this.config.color_scheme);
			backgroundTypeElm.addClassName(this.classPrefix + 'after_time' + '_' + this.config.counter_type + '_' + this.config.color_scheme);
			backgroundTypeElm.update(':');
		}
	},
	insertTimeTypeInTemplate : function(value, timeClass, maxFirstDigit) {
		var timeBox = this.box.select('.itoris_countdown_time .itoris_countdown_' + timeClass)[0];
		var digits = timeBox.select('div');
		var strValue = value.toString();
		for (var i = 0; i < (digits.length - strValue.length); i++) {
			strValue = '0' + strValue;
		}
		for (var i = 0; i < digits.length; i++) {
			if (this.config.counter_type == this.counterTypeTextual) {
				digits[i].update(strValue[i]);
			} else {
				if (!digits[i].hasClassName(this.classPrefix + 'digit' + strValue[i])) {
					var prevDigit = parseInt(strValue[i]) != 9 ? (parseInt(strValue[i]) + 1) : 0;
					if (digits[i].hasClassName(this.classPrefix + 'digit' + prevDigit)) {
						digits[i].removeClassName(this.classPrefix + 'digit' + prevDigit);
					}
					if (parseInt(strValue[i]) && digits[i].hasClassName(this.classPrefix + 'digit0')) {
						digits[i].removeClassName(this.classPrefix + 'digit0');
					}
					digits[i].addClassName(this.classPrefix + 'digit' + strValue[i]);
					var value = (11 - parseInt(strValue[i])) * this.slideStep;
					if (maxFirstDigit && !this.isCalculatedTimeBox && i == 0 && digits.length == 2) {
						value -= (9 - maxFirstDigit) * this.slideStep;
					}
					if (this.isCalculatedTimeBox && timeClass == 'hours' && maxFirstDigit && strValue == '23' && i == 1) {
						this.isCalculatedTimeBox = false;
						var flagSetCalculatedTimeBoxTrue = true;
					}
					this.changeBackgroundPosition(digits[i], value, parseInt(strValue[i]));
					if (flagSetCalculatedTimeBoxTrue) {
						this.isCalculatedTimeBox = true;
					}
				}
			}
		}
	},
	changeBackgroundPosition : function(element, value, digit) {
		var windowHasFocus = typeof document.hasFocus != 'function' || document.hasFocus();
		var duration = 0.5 / 10;
		//var beforePosition = parseInt(element.getStyle('backgroundPosition').split(' ')[1]);
		var beforePosition = element.beforePosition ? parseInt(element.beforePosition) : 0;
		this.setBackgroundPosition(element, beforePosition, null);
		var executer = null;
		var obj = this;
		value = this.isCalculatedTimeBox ? (this.slideStep + beforePosition) : value;
		element.beforePosition = digit == 1 ? 0 : value;
		var step = Math.abs(value - beforePosition);
		if (windowHasFocus) {
			step /= 10;
		}
		if (windowHasFocus) {
			executer = new PeriodicalExecuter(function() {
				obj.slideBackgrounPosition(element, value, step, executer, digit)
			}, duration);
		} else {
			this.slideBackgrounPosition(element, value, step, executer, digit)
		}
	},
	setBackgroundPosition : function(element, value, digit) {
		if (digit == 1) {
			value = 0;
		}
		element.setStyle({backgroundPosition: '0px ' + value +'px'});
	},
	slideBackgrounPosition : function(element, value, valueIncrement, executer, digit) {
		var position = parseInt(element.getStyle('backgroundPosition').split(' ')[1]) + valueIncrement;
		if (position >= value) {
			position = value;
			if (executer) {
				executer.stop();
			}
		} else {
			digit = null;
		}

		this.setBackgroundPosition(element, position, digit);
	},
	prepareTimeBlocks : function(amount, timeClass, maxDigit) {
		var timeBox = this.box.select('.' + this.classPrefix + 'time .' + this.classPrefix + timeClass)[0];
		timeBox.addClassName(this.classPrefix + 'digit_background_' + this.config.counter_size + '_' + this.config.counter_type);
		if (this.config.counter_type == this.counterTypeTextual) {
			timeBox.addClassName(this.classPrefix + 'digit_' + (timeClass == 'days' ? 'days' : 'time') + '_' + this.config.counter_type + '_' + this.config.color_scheme);
		}
		amount = amount || 1;
		var colorSchemeClass = this.classPrefix + 'digit_' + this.config.counter_size + '_' + this.config.color_scheme;
		for (var i = 0; i < amount; i++) {
			var digit = document.createElement('div');
			Element.extend(digit);
			digit.addClassName(this.classPrefix + 'digit_' + this.config.counter_size + '_' + this.config.counter_type);
			digit.addClassName((maxDigit && i==0 && amount == 2) ? (colorSchemeClass + maxDigit) : colorSchemeClass );
			timeBox.appendChild(digit);
		}
	},
	start : function() {
		if (this.seconds) {
			this.seconds--;
			this.updateTimeTemplate();
		} else {
			this.stop();
		}
	},
	stop : function() {
		this.countdown.stop();
		window.location.reload();
	}
});