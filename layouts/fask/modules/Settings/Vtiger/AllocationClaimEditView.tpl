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

    <div class="allocationModalContainer modal-dialog modal-lg" id="EditClaimAllocationContainer">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:-5px;left:97%"><i class="fa fa-times" aria-hidden="true"></i><span class="close"></span><div></div></button>
                Edit Claim Allocation
        </div>
        <div class="modal-content">            
            <form id="AddClaimAllocation" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Allocation Title :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4">
                                <input class="inputElement col-sm-9" type="text" placeholder="New Joiners" id="AllocationTitle" name="AllocationTitle" value="{$VALUES['allocationtitle']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Allocation Code :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4">
                                <input class="inputElement col-sm-9" type="text" placeholder="A01" id="AllocationCode" name="AllocationCode" value="{$VALUES['allocation_code']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Status :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-6 ">
                                {if $VALUES['status'] eq 'on'}
                                    <input type="checkbox" id="status" name="status" checked>
                                {else}    
                                    <input type="checkbox" id="status" name="status">
                                {/if}                                    
                            </div>
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Description :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-6 ">
                                <textarea class="inputElement col-sm-9" style="width: 359px; height: 111px;" id="Allocation_Desc" name="Allocation_Desc">{$VALUES['allocation_desc']}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Grade Allocation :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-6 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" multiple style="width:359px;" id="Allocation_grade" name="Allocation_grade">
                                    {foreach item=SPLITVALUE key=k from=$GRADE}
                                        {if in_array($GRADE[$k]['id'],$PREVALUES['grade_id'])}
                                            <option value={$GRADE[$k]['id']} selected="true">{$GRADE[$k]['grade']}</option>
                                        {else}
                                            <option value={$GRADE[$k]['id']}>{$GRADE[$k]['grade']}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>

                    
                    <input type="hidden" id="EditdropdownValue" value='{$CLAIMTYPE}'>
                    <input type="hidden" id="EditallocatedClaimTypeValues" value='{$CLAIMTYPEVALUES}'>


                    <div id="ClaimTypeAllocation">
                        <div class="container float-left">

                            <div class="contents row form-group">

                                <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="btn" type="button" id="EditAddClaimtype" name="EditAddClaimtype"><strong>{vtranslate('LBL_ADDCLAIMTYPE', $MODULE)}</strong></button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="allocation_id" name="allocation_id" value="{$VALUES['allocation_id']}">

                </div>
                <div class="modal-footer ">
                    <center>
                        <button class="btn btn-success" type="button" id="saveButtonClaim" name="saveButtonClaim"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button>
                        <a href="#" class="cancelLink" type="reset" data-dismiss="modal">{vtranslate('LBL_CANCEL', $MODULE)}</a>

                    </center>
                </div>
            </form>
        </div>
    </div>
    
{/strip}



