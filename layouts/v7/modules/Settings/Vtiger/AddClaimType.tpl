{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Created By Mabruk on 02/04/2018
 ************************************************************************************}
{* modules/Settings/UserPlan/views/UserPlanAjax.php *}

{strip}
    <div class="taxModalContainer modal-dialog modal-xs" id="AddClaimTypeContainer" xmlns="http://www.w3.org/1999/html">
        <div class="modal-content">
            <form id="AddRule" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Claim Type Title :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="Travel Claims" id="ClaimTypeTitle" name="ClaimTypeTitle">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Claim Code :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="C01" id="ClaimCode" name="ClaimCode">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Status :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                               <input type="checkbox" id="status" name="status">
                            </div>
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Description :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <textarea id="ClaimType_Desc" name="ClaimType_Desc" /> </textarea>
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



