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

    <div class="taxModalContainer modal-dialog modal-xs" id="EditAllocationContainer">
        <div class="modal-content">
            <form id="AddAllocation" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Allocation Title :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="New Joiners" id="AllocationTitle" name="AllocationTitle" value="{$VALUES['allocationtitle']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Allocation Code :</label></div>
                            <div class="col-lg-4 col-md-4">
                                <input type="text" placeholder="A01" id="AllocationCode" name="AllocationCode" value="{$VALUES['allocation_code']}">
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
                                <input type="text" id="Allocation_Desc" name="Allocation_Desc" value="{$VALUES['allocation_desc']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Grade Allocation :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_grade" name="Allocation_grade">
                                    <option value="">Select One</option>
                                    {foreach item=SPLITVALUE key=k from=$GRADE}
                                        {if {$GRADE[$k]['id']} eq {$VALUES['grade_id']}}
                                            <option value={$GRADE[$k]['id']} selected="true">{$GRADE[$k]['grade']}</option>
                                        {else}
                                            <option value={$GRADE[$k]['id']}>{$GRADE[$k]['grade']}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Leave Allocation :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_leavetype" name="Allocation_leavetype">
                                    <option value="">Select One</option>
                                    {foreach item=SPLITVALUE key=k from=$LEAVETYPE}
                                        {if  {$LEAVETYPE[$k]['id']} eq {$VALUES['leavetype_id']}}
                                             <option value={$LEAVETYPE[$k]['id']} selected="true">{$LEAVETYPE[$k]['title']}</option>
                                        {else}
                                            <option value={$LEAVETYPE[$k]['id']}>{$LEAVETYPE[$k]['title']}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div>

                            <a href="#" rel="tooltip" title="Number of days for which employees have been in company"><b>Age</b></a>&nbsp;&nbsp;
                            <input type="text" placeholder="" id="ageleave" name="ageleave" style="width: 50px;" value="{$VALUES['age_leave']}">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="#" rel="tooltip" title="Number of leaves if the users age in the company is less than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;
                            <input type="text" placeholder="" id="numberofleavesless" name="numberofleavesless" style="width: 50px;" value="{$VALUES['numberofleavesless']}">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="#" rel="tooltip" title="Number of leaves if the users age in the company is more than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;
                            <input type="text" placeholder="" id="numberofleavesmore" name="numberofleavesmore" style="width: 50px;" value="{$VALUES['numberofleavesmore']}">
                        </div>
                    </div>

                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Claim Allocation :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" style="width:150px;" id="Allocation_claimtype" name="Allocation_claimtype">
                                    <option value="">Select One</option>
                                    {foreach item=SPLITVALUE key=k from=$CLAIMTYPE}
                                        {if {$CLAIMTYPE[$k]['id']} eq {$VALUES['claimtype_id']}}
                                            <option value={$CLAIMTYPE[$k]['id']} selected="true">{$CLAIMTYPE[$k]['claim_type']}</option>
                                        {else}
                                            <option value={$CLAIMTYPE[$k]['id']}>{$CLAIMTYPE[$k]['claim_type']}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"></div>

                            <a href="#" rel="tooltip" title="Number of days for which employees have been in company"><b>Age</b></a>&nbsp;&nbsp;
                            <input type="text" placeholder="" id="ageclaim" name="ageclaim" style="width: 50px;" value="{$VALUES['age_claim']}">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="#" rel="tooltip" title="Claim amount if the users age in the company is less than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;
                            <input type="text" placeholder="" id="amountclaimless" name="amountclaimless" style="width: 50px;" value="{$VALUES['claimamountless']}">&nbsp;&nbsp;&nbsp;&nbsp;

                            <a href="#" rel="tooltip" title="Claim Amount if the users age in the company is more than mentioned value"><i class="fa fa-info-circle"></i></a>&nbsp;&nbsp;
                            <input type="text" placeholder="" id="amountclaimmore" name="amountclaimmore" style="width: 50px;" value="{$VALUES['claimamountmore']}">
                        </div>
                    </div>



                    <input type="hidden" id="allocation_id" name="allocation_id" value="{$VALUES['allocation_id']}">


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



