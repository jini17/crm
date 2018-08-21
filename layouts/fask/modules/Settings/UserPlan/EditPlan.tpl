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
    <div class="taxModalContainer modal-dialog modal-xs" id="PlanContainer">
        <div class="modal-content">
            <form id="editPlan" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                 <div class="container float-left">              
                    <div class="contents row form-group">
                    <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('LBL_USER', $QUALIFIED_MODULE)}:</label></div>
                        <div class="col-lg-4 col-md-4">
                            <label>{$USERNAME}</label>
                        </div>
                    </div>             
                 </div>     
                 <div class="container float-left">              
                    <div class="contents row form-group">
                    <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('LBL_CURRENT_PLAN', $QUALIFIED_MODULE)}:</label></div>
                        <div class="col-lg-4 col-md-4">
                            <label>{$PLANTITLE}</label>
                        </div>
                    </div>             
                </div>           
                <div class="container float-left">              
                    <input type="hidden" name="selectPlan"/>
                    <div class="contents row form-group">
                    <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('LBL_SELECT_PLAN', $QUALIFIED_MODULE)}:</label></div>

                        <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                            <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="planFilter">
                                <option value="">Select Plan</option>
                                {foreach item=PLAN from=$PLANS}
                                    <option value={$PLAN.planid}>{$PLAN.plantitle} - {$PLAN.balance}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>             
                </div>
                 <div class="container float-left">              
                    <input type="hidden" name="selectPlan"/>
                    <div class="contents row form-group">
                    <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('LBL_SELECT_ROLE', $QUALIFIED_MODULE)}:</label>&nbsp;<span class="redColor">*</span></div>
        
                        <div class="fieldValue col-lg-4 col-md-4 col-sm-4 rolefilter">
                            <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="roleFilter" data-rule-required='true'>
                                <option value="">Select Role</option>
                                {foreach item=ROLE from=$ROLES}
                                    <option value={$PLAN.ROLE}>{$PLAN.plantitle} - {$PLAN.balance}</option>
                                {/foreach}
                            </select>
                        </div>
                    </div>             
                </div>
                </div>
               <div class="modal-footer ">
               <center>
                    {if $BUTTON_NAME neq null}
                        {assign var=BUTTON_LABEL value=$BUTTON_NAME}
                    {else}
                        {assign var=BUTTON_LABEL value={vtranslate('LBL_SAVE', $MODULE)}}
                    {/if}
                  <button class="btn btn-success" type="button" name="saveButton"><strong>{vtranslate($BUTTON_LABEL, $MODULE)}</strong></button>
                  <a href="#" class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>
              </center>
            </div>
            </form>
        </div>
    </div>
{/strip}



