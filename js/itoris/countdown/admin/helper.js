if (!ItorisHelper) {
	var ItorisHelper = {};
}

ItorisHelper.toogleFieldEditMode = function(id, container, depends, reverse) {
	var disabled = $(id).checked;
	if (depends && !disabled) {
		if ($(depends)) {
			$(container).disabled = !$(depends).checked;
		}
	} else {
		$(container).disabled = reverse ? !disabled : disabled;
	}
	return;
};

ItorisHelper.checkParentEditMode = function(parentId, id, addObserver) {
	if ($('check_' + id) && !$('check_' + id).checked || !$('check_' + id)) {
		ItorisHelper.toogleFieldEditMode(parentId, id, null, true);
	}
	if (addObserver) {
		Event.observe($(parentId), 'click', function() { ItorisHelper.checkParentEditMode(parentId, id, false); });
	}
};

ItorisHelper.toogleEditor = function(id, editorId, disable) {
	var editor = tinyMCE.get(editorId);
	ItorisHelper.toogleFieldEditMode(id, editorId);
	if (!editor) {
		return;
	}
	var DOM = tinymce.DOM;
	var doc = editor.getDoc();

	if(disable || $(id).checked) {
		if (!tinymce.isIE) {
			try {
				doc.designMode = 'Off';
			} catch (ex) {

			}
		} else {
			// It will not steal focus if we hide it while setting contentEditable
			b = editor.getBody();
			DOM.hide(b);
			b.contentEditable = false;
			DOM.show(b);
		}
	} else if(!$(id).checked) {
		if (!tinymce.isIE) {
			try {
				doc.designMode = 'On';
			} catch (ex) {

			}
		} else {
			// It will not steal focus if we hide it while setting contentEditable
			b = editor.getBody();
			DOM.hide(b);
			b.contentEditable = true;
			DOM.show(b);
		}
	}
};

ItorisHelper.extendedFormSubmit = function(formId, actionUrl, elements, tabs) {
	if (elements) {
		for (var i = 0; i < elements.length; i++) {
			$(elements[i]).addClassName('required-entry');
		}
	}
	var validator = new Validation(formId);
	isValid = validator.validate();
	if (!isValid && tabs) {
		var errorTab = null;
		for (var i = 0; i < tabs.tabs.length; i++) {
			var elements = $(tabs.tabs[i].id + '_content').select('.validation-failed');
			if (elements.length) {
				tabs.tabs[i].addClassName('error');
				if (!errorTab) {
					tabs.showTabContent(tabs.tabs[i]);
					errorTab = true;
				}
			}
		}
	}

	if (isValid) {
		if (actionUrl) {
			$(formId).action = actionUrl;
		}
		if (tabs) {
			$(formId).action += (($(formId).action.indexOf('?') == -1) ? '?' : '&') + 'active_tab=' + tabs.activeTab.id;
		}
		if (!$(formId).isSubmited) {
			$(formId).submit();
		}
		$(formId).isSubmited = true;
	}
	if (elements) {
		for (var i = 0; i < elements.length; i++) {
			$(elements[i]).removeClassName('required-entry');
		}
	}
};