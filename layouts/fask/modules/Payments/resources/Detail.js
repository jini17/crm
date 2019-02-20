/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Vtiger_Detail_Js("Payments_Detail_Js",{
	
	sendEmailPDFClickHandler : function(url){ 
		var popupInstance = Vtiger_Popup_Js.getInstance();
		popupInstance.show(url,function(){}, app.vtranslate('JS_SEND_PDF_MAIL') );
	    }
	},{

	registerEvents: function(){
		this._super();
	}
});

