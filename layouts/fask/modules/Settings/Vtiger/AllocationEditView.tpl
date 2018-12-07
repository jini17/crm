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
Jitu{$MODULE}
    <div class="allocationModalContainer modal-dialog modal-lg" id="EditAllocationContainer">
        <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="position:absolute;top:-5px;left:97%"><i class="fa fa-times" aria-hidden="true"></i><span class="close"></span><div></div></button>
                {vtranslate('Edit',$MODULE)} {vtranslate('Allocation',$MODULE)}
        </div>
        <div class="modal-content">            
            <form id="AddAllocation" class="form-horizontal" method="POST">
                <div class="modal-body" id="scrollContainer" name="test">
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('Allocation',$MODULE)} {vtranslate('Title',$MODULE)} :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4">
                                <input class="inputElement col-sm-9" type="text" placeholder="New Joiners" id="AllocationTitle" name="AllocationTitle" value="{$VALUES['allocationtitle']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">
                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('Allocation',$MODULE)} {vtranslate('Code',$MODULE)} :</label></div>
                            <div class="fieldValue col-lg-4 col-md-4">
                                <input class="inputElement col-sm-9" type="text" placeholder="A01" id="AllocationCode" name="AllocationCode" value="{$VALUES['allocation_code']}">
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('Status',$MODULE)} :</label></div>

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
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('Description',$MODULE)} :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-6 ">
                                <textarea class="inputElement col-sm-9" style="width: 359px; height: 111px;" id="Allocation_Desc" name="Allocation_Desc">{$VALUES['allocation_desc']}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('Grade',$MODULE)} {vtranslate('Allocation',$MODULE)} :</label></div>

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


                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('Show LeaveType',$MODULE)}  :</label></div>

                            <div class="fieldValue col-lg-4 col-md-4 col-sm-6 ">
                                <input class="inputElement nameField" type="checkbox" id="EditAllocateLeave" name="EditAllocateLeave">
                            </div>
                        </div>
                    </div>
                    <div id="EditLeaveTypeAllocation">
                        <div class="container float-left">

                            <div class="contents row form-group">

                                <div class="fieldValue col-lg-4 col-md-4 col-sm-6 ">
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <button class="btn" type="button" id="EditAddLeavetype" name="EditAddLeavetype"><strong>{vtranslate('LBL_ADDLEAVETYPE', $MODULE)}</strong></button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" id="EditdropdownValue" value='{$LEAVETYPE}'>
                    <input type="hidden" id="EditallocatedLeaveTypeValues" value='{$LEAVETYPEVALUES}'>


                    <div class="container float-left">

                        <div class="contents row form-group">
                            <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>{vtranslate('Claim',$MODULE)} {vtranslate('Claim',$MODULE)} :</label></div>
		
                            <div class="fieldValue col-lg-4 col-md-6 col-sm-6 ">
                                <select class="select2-container select2 inputElement col-sm-6 selectModule" multiple style="width:359px;" id="Allocation_claimtype" name="Allocation_claimtype">
                                    {foreach item=SPLITVALUE key=k from=$CLAIMTYPE}
                                        {if in_array($CLAIMTYPE[$k]['id'],$PREVALUES['claim_id'])}
                                            <option value={$CLAIMTYPE[$k]['id']} selected="true">{$CLAIMTYPE[$k]['claimtype']}</option>
                                        {else}
                                            <option value={$CLAIMTYPE[$k]['id']}>{$CLAIMTYPE[$k]['claimtype']}</option>
                                        {/if}
                                    {/foreach}
                                </select>
                            </div>
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



