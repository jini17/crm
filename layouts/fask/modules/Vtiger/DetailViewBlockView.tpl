{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}
<style>
/* Tooltip container */
.tooltip {
{*    position: relative;*}
  {*  display: inline-block;
    border-bottom: 1px dotted black; /* If you want dots under the hoverable text */*}
}

/* Tooltip text */
 .tooltiptext {

    width: 120px;
    background-color: black;
    color: #fff;
    text-align: center;
    padding: 5px 0;
    border-radius: 6px;
 
    /* Position the tooltip text - see examples below! */
    position: absolute;
    z-index: 1;
}

/* Show the tooltip text when you mouse over the tooltip container */

</style>
<script>
       $(document).ready(function(){
        
              
               
           $('.tooltipcontailer i').on('hover',function(){
                var x = $(".tooltipcontailer").offset();
                     $('.tooltiptext').css('top',x.top);
                     $('.tooltiptext').css('left',x.left);
                     $('.tooltiptext').show('slow');
                     
           });
             $('.tooltipcontailer i').on('mouseout',function(){
                     $('.tooltiptext').css('top',x.top);
                     $('.tooltiptext').css('left',x.left);
                     $('.tooltiptext').toggle('slow');
                     
           });
    });
   </script> 
                    <span class="tooltiptext" style="display:none;">
                        Xennials -  <br />
                         Gen X -  <br />
                         Millennials - <br />
                         Gen Z - <br />
                    </span>
{strip}
        {if !empty($PICKIST_DEPENDENCY_DATASOURCE)}
                <input type="hidden" name="picklistDependency" value='{Vtiger_Util_Helper::toSafeHTML($PICKIST_DEPENDENCY_DATASOURCE)}' />
        {/if}

        {foreach key=BLOCK_LABEL_KEY item=FIELD_MODEL_LIST from=$RECORD_STRUCTURE}
                {assign var=BLOCK value=$BLOCK_LIST[$BLOCK_LABEL_KEY]}
                {if $BLOCK eq null or $FIELD_MODEL_LIST|@count lte 0}{continue}{/if}
                <div class="block block_{$BLOCK_LABEL_KEY}">
                        {assign var=IS_HIDDEN value=$BLOCK->isHidden()}
                        {assign var=WIDTHTYPE value=$USER_MODEL->get('rowheight')}
                        <input type=hidden name="timeFormatOptions" data-value='{$DAY_STARTS}' />
                        <div>
                                <h5 class="textOverflowEllipsis maxWidth100">

                                <i class="ti-plus cursorPointer alignMiddle blockToggle {if !($IS_HIDDEN)} hide {/if}" data-mode="hide" data-id={$BLOCK_LIST[$BLOCK_LABEL_KEY]->get('id')}></i>

                                <i class="ti-minus cursorPointer alignMiddle blockToggle {if ($IS_HIDDEN)} hide {/if}" data-mode="show" data-id={$BLOCK_LIST[$BLOCK_LABEL_KEY]->get('id')}></i>

                                        &nbsp;
                                        {vtranslate({$BLOCK_LABEL_KEY},{$MODULE_NAME})}
                                </h5>
                        </div>
                        <div class="blockData">
                                <div class="table detailview-table" >
                     
                                        <div {if $IS_HIDDEN} class="hide" {/if}>
                                                {assign var=COUNTER value=0}
                                                <div class="row">
                                                    
                                                        {foreach item=FIELD_MODEL key=FIELD_NAME from=$FIELD_MODEL_LIST}
                                                                {assign var=fieldDataType value=$FIELD_MODEL->getFieldDataType()}
                                                                {if !$FIELD_MODEL->isViewableInDetailView()}
                                                                        {continue}
                                                                {/if}
                                                                {if $FIELD_MODEL->get('uitype') eq "83"}
                                                                        {foreach item=tax key=count from=$TAXCLASS_DETAILS}
                                                                                {if $COUNTER eq 2}
                                                                                        </div>
                                                                                        <div class="row" >
                                                                                           
                                                                                     
                                                                                        {assign var="COUNTER" value=1}
                                                                                {else}
                                                                                        {assign var="COUNTER" value=$COUNTER+1}
                                                                                {/if}
                                                                                <div class="fieldLabel col-xs-6 col-md-3">
                                                                                        <span class='muted'>{vtranslate($tax.taxlabel, $MODULE)}(%)</span>
                                                                                </div>
                                                                                <div class="fieldValue col-xs-6 col-md-3">
                                                                                            
                                                                                        <span class="value textOverflowEllipsis" data-field-type="{$FIELD_MODEL->getFieldDataType()}" >
                                                                                                {if $tax.check_value eq 1}
                                                                                                        {$tax.percentage}
                                                                                                {else}
                                                                                                        0
                                                                                                {/if} 
                                                                                        </span>
                                                                                </div>
                                                                        {/foreach}
                                                                {else if $FIELD_MODEL->get('uitype') eq "69" || $FIELD_MODEL->get('uitype') eq "105"}
                                                                        {if $COUNTER neq 0}
                                                                                {if $COUNTER eq 2}
                                                                                        </div><div class="row">
                                                                                        {assign var=COUNTER value=0}
                                                                                {/if}
                                                                        {/if}
                                                                        <div class="fieldLabel col-xs-6 col-md-3 {$WIDTHTYPE}"><span class="muted">{vtranslate({$FIELD_MODEL->get('label')},{$MODULE_NAME})}</span></div>
                                                                        <div class="fieldValue col-xs-6 col-md-3 {$WIDTHTYPE}">
                                                                                <ul id="imageContainer">
                                                                                        {foreach key=ITER item=IMAGE_INFO from=$IMAGE_DETAILS}
                                                                                                {if !empty($IMAGE_INFO.path) && !empty({$IMAGE_INFO.orgname})}
                                                                                                        <li><img src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}" title="{$IMAGE_INFO.orgname}" width="400" height="300" /></li>
                                                                                                {/if}
                                                                                        {/foreach}
                                                                                </ul>
                                                                        </div>
                                                                        {assign var=COUNTER value=$COUNTER+1}
                                                                {else}
                                                                        {if $FIELD_MODEL->get('uitype') eq "20" or $FIELD_MODEL->get('uitype') eq "19" or $fieldDataType eq 'reminder' or $fieldDataType eq 'recurrence'}
                                                                                {if $COUNTER eq '1'}
                                                                                        <div class="fieldLabel col-xs-6 col-md-3 {$WIDTHTYPE}"></div><div class="{$WIDTHTYPE}"></div></div><div class="row">
                                                                                        {assign var=COUNTER value=0}
                                                                                {/if}
                                                                        {/if}
                                                                        {if $COUNTER eq 2}
                                                                                </div><div class="row">
                                                                                {assign var=COUNTER value=1}
                                                                        {else}
                                                                                {assign var=COUNTER value=$COUNTER+1}
                                                                        {/if}
                                                                        
                                                                        <div class="fieldLabel textOverflowEllipsis  {if $FIELD_MODEL->getName() eq 'description' or $FIELD_MODEL->get('uitype') eq '69'}col-xs-3{else}col-xs-6 col-md-3{/if} {$WIDTHTYPE}" id="{$MODULE_NAME}_detailView_fieldLabel_{$FIELD_MODEL->getName()}" >
                                                                               
                                                                            <span class="muted">
                                                                                        {if $MODULE_NAME eq 'Documents' && $FIELD_MODEL->get('label') eq "File Name" && $RECORD->get('filelocationtype') eq 'E'}
                                                                                                {vtranslate("LBL_FILE_URL",{$MODULE_NAME})}
                                                                                                
                                                                                        {else}
                                                                                           
                                                                                                    {if $FIELD_MODEL->get('label') eq 'Age Group'}
                                                                                                        <div class="tooltipcontailer" style="  position: relative;    z-index: 9998!important;">
                                                                                                         {vtranslate({$FIELD_MODEL->get('label')},{$MODULE_NAME})}  &nbsp;
                                                                                                         <i class="glyphicon glyphicon-question-sign  "></i>
                                                                                                    </div>
                                                                                                 {else}
                                                                                                            {vtranslate({$FIELD_MODEL->get('label')},{$MODULE_NAME})}  
                                                                                                {/if}
                                                                                        {/if}
                                                                                        {if ($FIELD_MODEL->get('uitype') eq '72') && ($FIELD_MODEL->getName() eq 'unit_price')}
                                                                                                ({$BASE_CURRENCY_SYMBOL})
                                                                                        {/if}
                                                                                </span>
                                                                        </div>
                                                                        {if $FIELD_MODEL->get('uitype') eq '19' or $fieldDataType eq 'reminder' or $fieldDataType eq 'recurrence'}
                                                                        {assign var=COUNTER value=$COUNTER+1}
                                                                        <div class="fieldValue col-xs-9 {$WIDTHTYPE}" id="{$MODULE_NAME}_detailView_fieldValue_{$FIELD_MODEL->getName()}" >
                                                                        {else}	
                                                                        <div class="fieldValue col-xs-6 col-md-3 {$WIDTHTYPE}" id="{$MODULE_NAME}_detailView_fieldValue_{$FIELD_MODEL->getName()}" >
                                                                        {/if}	
                                                                                {assign var=FIELD_VALUE value=$FIELD_MODEL->get('fieldvalue')}
                                                                                {if $fieldDataType eq 'multipicklist'}
                                                                                        {assign var=FIELD_DISPLAY_VALUE value=$FIELD_MODEL->getDisplayValue($FIELD_MODEL->get('fieldvalue'))}
                                                                                {else}
                                                                                        {assign var=FIELD_DISPLAY_VALUE value=Vtiger_Util_Helper::toSafeHTML($FIELD_MODEL->getDisplayValue($FIELD_MODEL->get('fieldvalue')))}
                                                                                {/if}

                                                                                <span class="value textOverflowEllipsis" style="    display: inline-block;" data-field-type="{$FIELD_MODEL->getFieldDataType()}" {if $FIELD_MODEL->get('uitype') eq '19' or $FIELD_MODEL->get('uitype') eq '21'} style="white-space:normal;" {/if}>
                                                                                        {include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getDetailViewTemplateName(),$MODULE_NAME) FIELD_MODEL=$FIELD_MODEL USER_MODEL=$USER_MODEL MODULE=$MODULE_NAME RECORD=$RECORD}
                                                                                </span>
                                                                                {if $IS_AJAX_ENABLED && $FIELD_MODEL->isEditable() eq 'true' && $FIELD_MODEL->isAjaxEditable() eq 'true'}
                                                                                        <span class="hide edit pull-left">
                                                                                                {if $fieldDataType eq 'multipicklist'}
                                                                                                        <input type="hidden" class="fieldBasicData" data-name='{$FIELD_MODEL->get('name')}[]' data-type="{$fieldDataType}" data-displayvalue='{$FIELD_DISPLAY_VALUE}' data-value="{$FIELD_VALUE}" />
                                                                                                {else}
                                                                                                        <input type="hidden" class="fieldBasicData" data-name='{$FIELD_MODEL->get('name')}' data-type="{$fieldDataType}" data-displayvalue='{$FIELD_DISPLAY_VALUE}' value="{$FIELD_VALUE}" data-value="{$FIELD_VALUE}" />
                                                                                                {/if}
                                                                                        </span>
                                                                                        <span class="action pull-right"><a href="#" onclick="return false;" class="editAction"><i class="material-icons">create</i></a></span>
                                                                                {/if}
                                                                        </div>
                                                                {/if}

                                                        {/foreach}


                                                </div>
                                                <!-- Added By Jitu Mabruk for Meeting--> 	
                                                {if $BLOCK_LABEL_KEY eq 'Participants'}
                                                        <div class="row">                                                            
                                                                <div class="col-md-3">
                                                                    <div class="fieldLabel col-xs-3 col-md-3">
                                                                        <span class="muted">{vtranslate('LBL_INVITE_USERS', $MODULE_NAME)}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="fieldValue col-xs-3 col-md-3">
                                                                    {foreach key=USER_ID item=USER_NAME from=$ACCESSIBLE_USERS}
                                                                        {if in_array($USER_ID,$INVITIES_SELECTED)}
                                                                            {$USER_NAME} - {vtranslate($INVITEES_DETAILS[$USER_ID],$MODULE)}
                                                                            <br>
                                                                        {/if}
                                                                    {/foreach}
                                                                </div>
                                            <div class="visible-sm visible-xs clearfix"></div>				                

                                            <div class="fieldLabel col-xs-3 col-md-3">
                                                <span class="muted">{vtranslate('LBL_EXTERNAL_USERS', $MODULE_NAME)}</span>
                                            </div>
                                             <div class="fieldValue col-xs-3 col-md-3">
                                                {foreach item=EMAIL from=$EXTEMAILS_DETAILS}
                                                    {$EMAIL['emailaddress']} - {vtranslate($EMAIL['status'],$MODULE)}
                                                    <br>	                          
                                                {/foreach}
                                            </div>
                                            <div class="visible-sm visible-xs clearfix"></div>
                                        </div>			               			
                                {/if}	
                                <!--End-->	
                        </div>
                </div>
                </div>

                </div>

        {/foreach}
{literal} 

                <script type="text/javacript">
    jQuery(document).ready(function(){
        alert("c");
             jQuery("textarea").each(function(){
                   jQuery(this).closest('.row').find('div').css("width","100% !important")               
                });
    });
</script>    
{/literal} 
{/strip}