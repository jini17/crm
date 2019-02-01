/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Edit_Js("LeaveType_Edit_Js",{},{

        fillColor:function() {
                var colorcode = $('#LeaveType_editView_fieldName_colorcode').val();
                $('#LeaveType_editView_fieldName_colorcode').css('backgroundColor', colorcode);
                $('#LeaveType_editView_fieldName_colorcode').ColorPicker({
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
                                $('#LeaveType_editView_fieldName_colorcode').css('backgroundColor', '#' + hex);
                                $('#LeaveType_editView_fieldName_colorcode').val('#' + hex);
                        }
                });

        },

        registerEvents : function() {
        this._super();
                this.fillColor();
        }
});
      jQuery("#LeaveType_editView_fieldName_description").closest('.row').find('div').css("height","120px");