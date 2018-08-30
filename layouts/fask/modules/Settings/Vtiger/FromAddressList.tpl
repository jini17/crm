{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk Rashid Khan on 28/05/2018
 ************************************************************************************}

{strip}
<div class="modal-dialog">
    <div class='modal-content'>
        <div class="contents">
            &ensp;<button class="addFromAddress btn span10 marginLeftZero newButton" id="addFromAddress">Add</button>
            &ensp;<button class="editFromAddress btn span10 marginLeftZero newButton" id="editFromAddress">Edit</button>
            &ensp;<button class="deleteFromEmail btn btn-danger span10 marginLeftZero"  id="deleteFromEmail">Delete</button>

            <form id="addFromAddressForm" class="addFromAddressForm form-horizontal" method="POST">               
                <div class="container float-left">
                    <div class="contents row form-group float-left">
                        <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Name :</label></div>
                        <div class="col-lg-4 col-md-4">
                            <input type="text" placeholder="Type the name here..." id="name" name="name">
                        </div>
                    </div>
                </div>
                <div class="container float-left">

                    <div class="contents row form-group">
                        <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Email :</label></div>
                        <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                            <input type="email" placeholder="abcd@yourdomain.com" id="email" name="email">
                        </div>
                    </div>
                </div>
                <center>
                    <button class="saveFromAddress btn btn-success" type="button" id="saveFromAddress" name="saveFromAddress"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button>
                    <a href="#" id="cancelForm" class="cancelForm" style="color:red;">{vtranslate('LBL_CANCEL', $MODULE)}</a>
                </center>  
                <br>  
            </form>  

            <div id="listFromAddress" class="listFromAddress">    
                {include file="modules/Settings/Vtiger/fromEmailAddressList.tpl"}
            </div>
        </div>
    </div>
</div>
{/strip}