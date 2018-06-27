{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
  {if $PARENT_MODULE eq "Settings"} 

  <div class = "quickPreview" style="margin-left: 30%;overflow: hidden;">
  {else}
  <div class = "quickPreview" >
  {/if}

    <input type="hidden" name="sourceModuleName" id="sourceModuleName" value="{$MODULE_NAME}" />
    <input type="hidden" id = "nextRecordId" value ="{$NEXT_RECORD_ID}">
    <input type="hidden" id = "previousRecordId" value ="{$PREVIOUS_RECORD_ID}">
          
   
            <div class='quick-preview-modal modal-content' >
            {if $PARENT_MODULE eq "Settings"}
             <div class='modal-body' style="width: 70%;height:100vh;overflow-x:hidden;">
            {else} 
             <div class='modal-body'>
            {/if}
            <div class = "quickPreviewModuleHeader row">
                <div class = "col-lg-10">
                    <div class="row qp-heading">
                        {include file="ListViewQuickPreviewHeaderTitle.tpl"|vtemplate_path:$MODULE_NAME MODULE_MODEL=$MODULE_MODEL RECORD=$RECORD}
                    </div>
                </div>
                <div class = "col-lg-2 pull-right">
                    <button class="close" aria-hidden="true" data-dismiss="modal" type="button" title="{vtranslate('LBL_CLOSE')}">x</button>
                </div>
            </div>

            <div class="quickPreviewActions clearfix">
                <div class="btn-group pull-left">
                    {if $PARENT_MODULE neq "Settings"}
                    <button class="btn btn-success btn-xs" onclick="window.location.href = '{$RECORD->getFullDetailViewUrl()}&app={$SELECTED_MENU_CATEGORY}'">
                       {vtranslate('LBL_VIEW_DETAILS', $MODULE_NAME)} 
                    </button>
                    {/if}
                </div>
                {if $NAVIGATION}
                    <div class="btn-group pull-right">
                        <button class="btn btn-default btn-xs" id="quickPreviewPreviousRecordButton" data-record="{$PREVIOUS_RECORD_ID}" data-app="{$SELECTED_MENU_CATEGORY}" {if empty($PREVIOUS_RECORD_ID)} disabled="disabled" {*{else} onclick="Vtiger_List_Js.triggerPreviewForRecord({$PREVIOUS_RECORD_ID})"*}{/if} >
                            <i class="fa fa-chevron-left"></i>
                        </button>
                        <button class="btn btn-default btn-xs" id="quickPreviewNextRecordButton" data-record="{$NEXT_RECORD_ID}" data-app="{$SELECTED_MENU_CATEGORY}" {if empty($NEXT_RECORD_ID)} disabled="disabled" {*{else} onclick="Vtiger_List_Js.triggerPreviewForRecord({$NEXT_RECORD_ID})"*}{/if}>
                            <i class="fa fa-chevron-right"></i>
                        </button>
                    </div>
                {/if}
            </div>
          

                
                    {if $PARENT_MODULE eq "Settings"}
           
                 <div class = "quickPreviewSummary" > 
                    <div style="display: table;width: 100%;height: 100%;">
                 <table class="summary-table no-border" {if $MAX_KEY gt 2}style="width: 50%;float: left;"{/if} >
                    <tbody>                                         
                        {for $iteration=0 to $MAX_KEY-1} 
                        {if $iteration neq 0}
                        {if ($iteration mod 2) eq 0}
                    </tbody>
                </table>
                 <table class="summary-table no-border" style="width: 50%;" >
                    <tbody> 
                        {/if}
                        {/if}                       
                          <td> 
                         </br></br>
                           <label class="muted" >{vtranslate($SUMMARY_RECORD_KEY[$iteration],$MODULE_NAME)}</label></br></td>                  
                        {foreach item=FIELD_MODEL key=FIELD_NAME from=$SUMMARY_RECORD_STRUCTURE[{vtranslate($SUMMARY_RECORD_KEY[$iteration])}]}
                        {if $FIELD_MODEL->get('name') neq 'modifiedtime' && $FIELD_MODEL->get('name') neq 'createdtime'}        
                                <tr class="summaryViewEntries">
                                    <td class="fieldLabel col-lg-5" ><label class="muted">{vtranslate($FIELD_MODEL->get('label'),$MODULE_NAME)}</label></td>
                                    <td class="fieldValue col-lg-7">
                                        <div class="row">
                                            <span class="value textOverflowEllipsis" {if $FIELD_MODEL->get('uitype') eq '19' or $FIELD_MODEL->get('uitype') eq '20' or $FIELD_MODEL->get('uitype') eq '21'}style="word-wrap: break-word;"{/if}>
                                                {include file=$FIELD_MODEL->getUITypeModel()->getDetailViewTemplateName()|@vtemplate_path:$MODULE_NAME FIELD_MODEL=$FIELD_MODEL USER_MODEL=$USER_MODEL MODULE=$MODULE_NAME RECORD=$RECORD}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                        
                            {/if}
                        {/foreach}
                         {/for} 
                      </tbody></table></div>                        
                        {/if}



                        {if $PARENT_MODULE neq "Settings"}
                        <div class = "quickPreviewSummary">
                        <table class="summary-table no-border" >
                            <tbody>  
                        {foreach item=FIELD_MODEL key=FIELD_NAME from=$SUMMARY_RECORD_STRUCTURE['SUMMARY_FIELDS']}
                            {if $FIELD_MODEL->get('name') neq 'modifiedtime' && $FIELD_MODEL->get('name') neq 'createdtime'}
                                <tr class="summaryViewEntries">
                                    <td class="fieldLabel col-lg-5" ><label class="muted">{vtranslate($FIELD_MODEL->get('label'),$MODULE_NAME)}</label></td>
                                    <td class="fieldValue col-lg-7">
                                        <div class="row">
                                            <span class="value textOverflowEllipsis" {if $FIELD_MODEL->get('uitype') eq '19' or $FIELD_MODEL->get('uitype') eq '20' or $FIELD_MODEL->get('uitype') eq '21'}style="word-wrap: break-word;"{/if}>
                                                {include file=$FIELD_MODEL->getUITypeModel()->getDetailViewTemplateName()|@vtemplate_path:$MODULE_NAME FIELD_MODEL=$FIELD_MODEL USER_MODEL=$USER_MODEL MODULE=$MODULE_NAME RECORD=$RECORD}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            {/if}
                        {/foreach}
                     </tbody></table>
                        {/if}              
            </div>          
        
           
            <div class="engagementsContainer" {if $PARENT_MODULE eq "Settings"}hidden{/if}>
				{include file="ListViewQuickPreviewSectionHeader.tpl"|vtemplate_path:$MODULE_NAME TITLE="{vtranslate('LBL_UPDATES',$MODULE_NAME)}"}              
				{include file="RecentActivities.tpl"|vtemplate_path:$MODULE_NAME} 
            </div>
            <br>            
            {if $MODULE_MODEL->isCommentEnabled()}
                <div class="quickPreviewComments">
                    {include file="ListViewQuickPreviewSectionHeader.tpl"|vtemplate_path:$MODULE_NAME TITLE="{vtranslate('LBL_RECENT_COMMENTS',$MODULE_NAME)}"}
                    {include file="QuickViewCommentsList.tpl"|vtemplate_path:$MODULE_NAME}
                </div>
            {/if}

            {if $PARENT_MODULE eq "Settings"}
           <div class="btn-group pull-left">
            <button class="btn btn-success btn" id="updatelog">
                       {vtranslate('Update Log', $MODULE_NAME)} 
            </button>
            </div>
            {/if}
            
        </div>
        
    </div></div></div></div>
    


<script >
  $("#updatelog").click(function(){
   $('.engagementsContainer').removeAttr("hidden");
   $('#updatelog').hide();
  });
</script>
