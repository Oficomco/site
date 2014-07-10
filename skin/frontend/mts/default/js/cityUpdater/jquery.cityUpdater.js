(function($){
		
	var ver = '0.1';

	
	var $cities;
	
	function init($select, $region, opts){
		 if ($("option", $select).length<=1) {
	            update($select, $region, opts);
	     }
		 
		 $region.change(function(){
			 update($select, $region, opts);
		 });
		 
	}
	
	function update($select, $region, opts){
		 if ($cities[$region.val()]) {
	            var i, option, city, def;

	            def = $select.attr('defaultValue');
	            $select.html("");
	            
				/*
	            option = document.createElement('OPTION');
	            option.value = '';
	            option.text = 'Seleccione su ciudad';

	            $select.append(option);				
				*/
				
				$select.append($("<option>").val('').text('Seleccione su ciudad'));
				
	            for (cityId in $cities[$region.val()]) {
	            	city = $cities[$region.val()][cityId];
	                /*
					option = document.createElement('OPTION');
	                option.value = cityId;
	                option.text = city.name;

	                $select.append(option);
					*/
					$select.append($("<option>").val(cityId).text(city.name));

	                if (cityId==def || city.code.toLowerCase()==def) {
	                    $select.val(cityId);
	                }
	            }

	            if (opts.disableAction=='hide') {
	                $select.css('display', '');
	            } else if (opts.disableAction=='disable') {
	                $select.attr('disabled', false);
	            }
	           setMarkDisplay($select, true);
	        } else {
	            if (opts.disableAction=='hide') {
	                $select.css('display', 'none');
	                Validation.reset($select);
	            } else if (opts.disableAction=='disable') {
	                $select.attr('disabled', true);
	            } else if (opts.disableAction=='nullify') {
	            	$select.html("");
	            	$select.val('');
	            	$select.attr('selectedIndex', 0);
	                lastCityId = '';
	            }
	            setMarkDisplay($select, false);
	        }

	}
	
	function setMarkDisplay (elem, display){
        elem = $(elem);
        var labelElement = jQuery("label > span.required", elem.parent()) ||
        					jQuery("label.required > em", elem.parent());
        
        if(labelElement) {
            inputElement = labelElement.parent().find('input');
            if (display) {
                labelElement.show();
                if (inputElement) {
                    inputElement.addClass('required-entry');
                }
            } else {
                labelElement.hide();
                if (inputElement) {
                    inputElement.removeClass('required-entry');
                }
            }
        }
    }
	
	$.fn.cityUpdater = function(region, cities, options) {
		var opts = $.extend({}, $.fn.cityUpdater.defaults, options);
		var $region = $(region);
		$cities = cities;
		return this.each(function() {
		    var $this = $(this);//select
		    init($this, $region, opts);
		  });
	};

	$.fn.cityUpdater.ver = function() { return ver; };
	$.fn.cityUpdater.author = function() { return author; };
	$.fn.cityUpdater.defaults = {
		disableAction : 'hide'
	};
	
})(jQuery);


