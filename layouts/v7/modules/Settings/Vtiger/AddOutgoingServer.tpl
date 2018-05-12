{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk Rashid Khan A.K.A. Mark(X)  on 02/04/2018
 ************************************************************************************}
{* modules/Settings/UserPlan/views/UserPlanAjax.php *}

{strip}

    <div class="taxModalContainer modal-dialog modal-xs" id="AddServerContainer">
        <div class="modal-content">
            <form id="outgoingServer" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                <div class="container float-left">
                    <div class="contents row form-group">
                        <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Type of Outgoing Server :</label></div>
                        <div class="col-lg-4 col-md-4">
                            <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="TypeOfOutgoing" name="TypeOfOutgoing">
                                <option value="">Select Type</option>
                                <option value="Gmail">Gmail</option>
                                <option value="Office365">Office365</option>
                                <option value="Others">Others</option>

                            </select>
                        </div>
                    </div>
                </div>


                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Host :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="smtp details" style="width:200px;" id="host" name="Host">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Username :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="username" id="username" name="Username">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Password :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="password" placeholder="username" id="password" name="Password">
                            </div>
                        </div>
                    </div>


                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Require Authentication :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="checkbox" id="requireAuthentication" name="requireAuthentication">
                            </div>
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Is Default :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="checkbox" id="isDefault" name="isDefault">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer ">
                    <center>
                        <button class="btn btn-success" type="button" id="saveButtonRule" name="saveButtonRule"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button>
                        <a href="#" class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>

                    </center>
                </div>
            </form>
        </div>
    </div>
{/strip}



