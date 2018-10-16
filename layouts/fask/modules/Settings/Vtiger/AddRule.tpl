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

    <div class="taxModalContainer modal-dialog modal-xs" id="AddRuleContainer">
        <div class="modal-content">
            <form id="AddRule" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>IP :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="192.0.0.0" id="ipval" name="ipval">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Type Of Address :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="TypeOfRule" name="TypeOfRule">
                                    <option value="">Select Plan</option>
                                    <option value="Absolute">Absolute</option>
                                    <option value="Range">Range</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Select Users :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="selectUser" name="selectUser[]" multiple>
                                    <option value="All Users">All Users</option>
                                    {foreach from=$USERS item=USER}
                                        <option value="{$USER}">{$USER}</option>
                                    {/foreach}

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Rrestriction Type</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="radio" name="iprestriction_type" value="allowed" /> Allowed<br>
                                <input type="radio" name="iprestriction_type" value="notallowed" /> Not Allowed<br>


                            </div>
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Is Active</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <input type="checkbox" name="isactive" />

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



