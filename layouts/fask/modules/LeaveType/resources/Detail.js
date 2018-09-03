/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Detail_Js("LeaveType_Detail_Js",{},{

	fillColor:function() {
		var colorcode = $('#LeaveType_editView_fieldName_color_code').val();
		$('#LeaveType_editView_fieldName_color_code').css('backgroundColor', colorcode);
		$('#LeaveType_editView_fieldName_color_code').ColorPicker({
			color: '#0000ff',
			onShow: function (colpkr) {
				$(colpkr).fadeIn(500);
				return false;
			},
			onHide: function (colpkr) {
				$(colpkr).fadeOut(500);
				return false;
			},
			onBeforeShow: function () {
				$(this).css('backgroundColor', this.value);
				$(this).ColorPickerSetColor(this.value);
			},	
			onChange: function (hsb, hex, rgb) {
				$('#LeaveType_editView_fieldName_color_code').css('backgroundColor', '#' + hex);
				$('#LeaveType_editView_fieldName_color_code').val('#' + hex);
				$('#LeaveType_detailView_fieldValue_color_code').css('backgroundColor', '#' + hex);
			}
		});
		
	},

	registerEvents : function() {
        	this._super();
		var colorcode = $('#LeaveType_editView_fieldName_color_code').val();
		$('#LeaveType_detailView_fieldValue_color_code').css('backgroundColor', colorcode);
		this.fillColor();
	}
});
