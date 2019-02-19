/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

var imported = document.createElement('script');
imported.src = 'layouts/fask/modules/Leads/resources/google.js';
document.head.appendChild(imported);

Vtiger_Edit_Js("Leads_Edit_Js",{},{
    
    /**
     * Function which will call Google Place API
     */
    registerGoogleAddress : function(container){
        var thisInstance = this;
        var script = document.createElement('script');
        script.type = 'text/javascript';
        script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyAvucdFiK-twUm8ozrd-fwadV5luYtYyjI&libraries=places&callback=initAutocomplete";
        document.body.appendChild(script); 
    },

    registerBasicEvents: function (container) {
        this._super(container);
        this.registerGoogleAddress();
    }

    
})

