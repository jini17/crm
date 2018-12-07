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
{strip}
<style type="text/javascript">
   .fieldLabel{
   height: 50px !important;
   display: block;
   }
   .inputElement {
   width: 100% !important;
   display: block !important;
   }
   .imageDelete{
        position: absolute;
         top: -79px;
         left: -972%;
   }
</style>
{if !empty($PICKIST_DEPENDENCY_DATASOURCE)}
<input type="hidden" name="picklistDependency" value='{Vtiger_Util_Helper::toSafeHTML($PICKIST_DEPENDENCY_DATASOURCE)}' />
{/if}
<div name='editContent'>
   {foreach key=BLOCK_LABEL item=BLOCK_FIELDS from=$RECORD_STRUCTURE name=blockIterator}
   {if $BLOCK_LABEL neq 'LBL_CALENDAR_SETTINGS' && $BLOCK_LABEL neq 'LBL_CURRENCY_CONFIGURATION' && $BLOCK_LABEL neq 'Other Preferences' &&  $BLOCK_LABEL neq 'LBL_USER_IMAGE_INFORMATION'}
   {if $BLOCK_FIELDS|@count gt 0}
   <div class="detailViewContainer block">
      <h5 class='fieldBlockHeader' >
      {vtranslate($BLOCK_LABEL, $MODULE)}</h4>
      <hr>
      <br/>
      <div class="table detailview-table no-border">
         <div class="row {$BLOCK_LABEL}">
            {assign var=COUNTER value=0}
            {foreach key=FIELD_NAME item=FIELD_MODEL from=$BLOCK_FIELDS name=blockfields}
            {assign var="isReferenceField" value=$FIELD_MODEL->getFieldDataType()}
            {assign var="refrenceList" value=$FIELD_MODEL->getReferenceList()}
            {assign var="refrenceListCount" value=count($refrenceList)}
            {if $FIELD_MODEL->getName() eq 'theme' or $FIELD_MODEL->getName() eq 'rowheight'}
            <input type="hidden" name="{$FIELD_MODEL->getName()}" value="{$FIELD_MODEL->get('fieldvalue')}"/> 
            {continue}
            {/if}
            {if $FIELD_MODEL->isEditable() eq true}
            {if $FIELD_MODEL->get('uitype') eq "19"}
            {if $COUNTER eq '1'}
            <div class="col-xs-6 col-md-3"></div>
            <div class="col-xs-6 col-md-3"></div>
         </div>
         <div class="row">
            {assign var=COUNTER value=0}
            {/if}
            {/if}
            {if $COUNTER eq 4}
         </div>
         <div class="row {$BLOCK_LABEL}">
            {assign var=COUNTER value=1}
            {else}
            {assign var=COUNTER value=$COUNTER+1}
            {/if}
            <div class="{$FIELD_MODEL->get('label')} {if $FIELD_MODEL->getName() eq 'status' && !$USER_MODEL->isAdminUser()} hide {/if}  fieldLabel col-xs-6 col-md-3 text-right" style="min-height: 53px;padding-bottom:{if $FIELD_MODEL->getName() eq 'date_joined'}4px{else}10px{/if};">
               {if $isReferenceField eq "reference"}
               {if $refrenceListCount > 1}
               <select style="width: 140px;" class="select2 referenceModulesList form-control">
                  {foreach key=index item=value from=$refrenceList}
                  <option value="{$value}">{vtranslate($value, $value)}</option>
                  {/foreach}
               </select>
               {else}
               {vtranslate($FIELD_MODEL->get('label'), $MODULE)}
               {/if}
               {else}
               {vtranslate($FIELD_MODEL->get('label'), $MODULE)}
               {/if}
               &nbsp; {if $FIELD_MODEL->isMandatory() eq true} <span class="redColor">*</span> {/if}
            </div>
            <div class="{$FIELD_MODEL->get('label')} {if $FIELD_MODEL->getName() eq 'status' && !$USER_MODEL->isAdminUser()} hide {/if} fieldValue col-xs-6 col-md-3 {if $FIELD_MODEL->getFieldDataType() eq 'boolean'} col-xs-6 {/if} {if $FIELD_MODEL->get('uitype') eq '19'} col-xs-6 {assign var=COUNTER value=$COUNTER+1} {/if}" style="padding-bottom:{if $FIELD_MODEL->getName() eq 'date_joined'}4px{else}10px{/if};">
               {include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(),$MODULE)}
            </div>
            {/if}
            {/foreach}
            {*If their are odd number of fields in edit then border top is missing so adding the check*}
            {if $COUNTER is odd}
            <div class="col-xs-6 col-md-2"></div>
            <div class="col-xs-6 col-md-2"></div>
            {/if}
         </div>
      </div>
   </div>
   <br>
   {/if}
   {else if $BLOCK_LABEL eq 'LBL_USER_IMAGE_INFORMATION'}
   {if $BLOCK_FIELDS|@count gt 0}
   <div class="fieldBlockContainer">
      <h4 class='fieldBlockHeader' >{vtranslate($BLOCK_LABEL, $MODULE)}</h4>
      <hr>
      <br/>
      <div class="table detailview-table no-border">
         <div class="row">
            {assign var=COUNTER value=0}
            {foreach key=FIELD_NAME item=FIELD_MODEL from=$BLOCK_FIELDS name=blockfields}
            <div class="{$FIELD_MODEL->get('label')} fieldLabel col-xs-3 col-md-3 text-right" style="min-height: 49px;">
               {vtranslate($FIELD_MODEL->get('label'), $MODULE)}
            </div>
            <div class="{$FIELD_MODEL->get('label')} fieldValue col-xs-9 col-md-9">
                
               {include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(),$MODULE)}
            </div>
            {/foreach}    
         </div>
      </div>
   </div>
   {/if}                
   {/if}
   {/foreach}
</div>

<script type="text/javascript">
     jQuery(document).ready(function(){
       jQuery('.bodyContents').find("#Users_editView_fieldName_sameaddresscheck").closest('.row').find('.col-xs-6').attr('style',"min-height:60px;")
    });
 </script>  