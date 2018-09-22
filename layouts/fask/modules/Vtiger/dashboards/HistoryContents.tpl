{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*************************************************************************************}

<div style='padding:5px;'>
    {if $HISTORIES neq false}
            {foreach key=$index item=HISTORY from=$HISTORIES}
                    {assign var=MODELNAME value=get_class($HISTORY)}
                    {if $MODELNAME == 'ModTracker_Record_Model'}
                            {assign var=USER value=$HISTORY->getModifiedBy()}
                            {assign var=TIME value=$HISTORY->getActivityTime()}
                            {assign var=PARENT value=$HISTORY->getParent()}
                            {assign var=MOD_NAME value=$HISTORY->getParent()->getModule()->getName()}
                            {assign var=SINGLE_MODULE_NAME value='SINGLE_'|cat:$MOD_NAME}
                            {assign var=TRANSLATED_MODULE_NAME value = vtranslate($MOD_NAME ,$MOD_NAME)}
                            {assign var=PROCEED value= TRUE}
                            {if ($HISTORY->isRelationLink()) or ($HISTORY->isRelationUnLink())}
                                    {assign var=RELATION value=$HISTORY->getRelationInstance()}
                                    {if !($RELATION->getLinkedRecord())}
                                            {assign var=PROCEED value= FALSE}
                                    {/if}
                            {/if}
                            {if $PROCEED}
                                    <div class="row entry clearfix">
                                            <div class='col-lg-2 col-xs-3 pull-left'>
                                                    {assign var=VT_ICON value=$MOD_NAME}
                                                    {if $MOD_NAME eq "Events"}
                                                            {assign var="TRANSLATED_MODULE_NAME" value="Calendar"}
                                                            {assign var=VT_ICON value="Calendar"}
                                                    {else if $MOD_NAME eq "Calendar"}
                                                            {assign var=VT_ICON value="Task"}
                                                    {/if}
                                                    {assign var=iconsarray value=['potentials'=>'attach_money','marketing'=>'thumb_up','leads'=>'thumb_up','accounts'=>'business',
                                                                    'sales'=>'attach_money','smsnotifier'=>'sms', 'services'=>'format_list_bulleted','pricebooks'=>'library_books','salesorder'=>'attach_money',
                                                                    'purchaseorder'=>'attach_money','vendors'=>'local_shipping','faq'=>'help','helpdesk'=>'headset','assets'=>'settings','project'=>'card_travel',
                                                                    'projecttask'=>'check_box','projectmilestone'=>'card_travel','mailmanager'=>'email','documents'=>'file_download', 'calendar'=>'event',
                                                                    'emails'=>'email','reports'=>'show_chart','servicecontracts'=>'content_paste','contacts'=>'contacts','campaigns'=>'notifications',
                                                                    'quotes'=>'description','invoice'=>'description','emailtemplates'=>'subtitles','pbxmanager'=>'perm_phone_msg','rss'=>'rss_feed',
                                                                    'recyclebin'=>'delete_forever','products'=>'inbox','portal'=>'web','inventory'=>'assignment','support'=>'headset','tools'=>'business_center',
                                                                    'mycthemeswitcher'=>'folder', 'chat'=>'chat', 'mobilecall'=>'call', 'call'=>'call', 'meeting'=>'people' ]}


                                                        {*<span><i class="material-icons entryIcon" title={$TRANSLATED_MODULE_NAME}>{$iconsarray[{strtolower($VT_ICON)}]}</i></span>&nbsp;&nbsp;*}
                                                                                                    <i class="fa fa-envelope" title="{$TRANSLATED_MODULE_NAME}"></i>&nbsp;&nbsp;


                                            </div>
                                            <div class="col-lg-10 col-xs-9 pull-right">
                                                    {assign var=DETAILVIEW_URL value=$PARENT->getDetailViewUrl()}
                                                    {if $HISTORY->isUpdate()}
                                                            {assign var=FIELDS value=$HISTORY->getFieldInstances()}
                                                            <div>
                                                                    <div><b>{$USER->getName()}</b> {vtranslate('LBL_UPDATED')} <a class="text-info cursorPointer" {if stripos($DETAILVIEW_URL, 'javascript:')===0}  onlick='{$DETAILVIEW_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$DETAILVIEW_URL}"' {/if}>
                                                                                    {$PARENT->getName()}</a>
                                                                    </div>
                                                                    {foreach from=$FIELDS key=INDEX item=FIELD}
                                                                            {if $INDEX lt 2}
                                                                                    {if $FIELD && $FIELD->getFieldInstance() && $FIELD->getFieldInstance()->isViewableInDetailView()}
                                                                                            <div>
                                                                                                    <i>{vtranslate($FIELD->getName(), $FIELD->getModuleName())}</i>
                                                                                                    {if $FIELD->get('prevalue') neq '' && $FIELD->get('postvalue') neq '' && !($FIELD->getFieldInstance()->getFieldDataType() eq 'reference' && ($FIELD->get('postvalue') eq '0' || $FIELD->get('prevalue') eq '0'))}
                                                                                                            &nbsp;{vtranslate('LBL_FROM')} <b>{Vtiger_Util_Helper::toVtiger6SafeHTML($FIELD->getDisplayValue(decode_html($FIELD->get('prevalue'))))}</b>
                                                                                                    {else if $FIELD->get('postvalue') eq '' || ($FIELD->getFieldInstance()->getFieldDataType() eq 'reference' && $FIELD->get('postvalue') eq '0')}
                                                                                                            &nbsp; <b> {vtranslate('LBL_DELETED')} </b> ( <del>{Vtiger_Util_Helper::toVtiger6SafeHTML($FIELD->getDisplayValue(decode_html($FIELD->get('prevalue'))))}</del> )
                                                                                                    {else}
                                                                                                            &nbsp;{vtranslate('LBL_CHANGED')}
                                                                                                    {/if}
                                                                                                    {if $FIELD->get('postvalue') neq '' && !($FIELD->getFieldInstance()->getFieldDataType() eq 'reference' && $FIELD->get('postvalue') eq '0')}
                                                                                                            {vtranslate('LBL_TO')} <b>{Vtiger_Util_Helper::toVtiger6SafeHTML($FIELD->getDisplayValue(decode_html($FIELD->get('postvalue'))))}</b>
                                                                                                    {/if}    
                                                                                            </div>
                                                                                    {/if}
                                                                            {else}
                                                                                    <a href="{$PARENT->getUpdatesUrl()}"><b>{vtranslate('LBL_MORE')}</b></a>
                                                                                    {break}
                                                                            {/if}
                                                                    {/foreach}
                                                            </div>
                                                    {else if $HISTORY->isCreate()}
                                                            <div>
                                                                    <b>{$USER->getName()}</b> {vtranslate('LBL_ADDED')} 
                                                                    <a class="text-info cursorPointer" {if stripos($DETAILVIEW_URL, 'javascript:')===0} onclick='{$DETAILVIEW_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$DETAILVIEW_URL}"' {/if}>{$PARENT->getName()}</a>
                                                            </div>
                                                    {else if ($HISTORY->isRelationLink() || $HISTORY->isRelationUnLink())}
                                                            {assign var=RELATION value=$HISTORY->getRelationInstance()}
                                                            {assign var=LINKED_RECORD_DETAIL_URL value=$RELATION->getLinkedRecord()->getDetailViewUrl()}
                                                            {assign var=PARENT_DETAIL_URL value=$RELATION->getParent()->getParent()->getDetailViewUrl()}
                                                            <div>
                                                                    <b>{$USER->getName()}</b>
                                                                    {if $HISTORY->isRelationLink()}
                                                                            {vtranslate('LBL_ADDED', $MODULE_NAME)}
                                                                    {else}
                                                                            {vtranslate('LBL_REMOVED', $MODULE_NAME)}
                                                                    {/if}
                                                                    {if $RELATION->getLinkedRecord()->getModuleName() eq 'Calendar'}
                                                                            {if isPermitted('Calendar', 'DetailView', $RELATION->getLinkedRecord()->getId()) eq 'yes'}
                                                                                    <a class="text-info cursorPointer" {if stripos($LINKED_RECORD_DETAIL_URL, 'javascript:')===0} onclick='{$LINKED_RECORD_DETAIL_URL|substr:strlen("javascript:")}'
                                                                                    {else} onclick='window.location.href="{$LINKED_RECORD_DETAIL_URL}"' {/if}>{$RELATION->getLinkedRecord()->getName()}</a>
                                                                    {else}
                                                                            {vtranslate($RELATION->getLinkedRecord()->getModuleName(), $RELATION->getLinkedRecord()->getModuleName())}
                                                                    {/if}
                                                            {else if $RELATION->getLinkedRecord()->getModuleName() == 'ModComments'}
                                                                    <i>"{$RELATION->getLinkedRecord()->getName()}"</i>
                                                            {else}
                                                                    <a class="cursorPointer" {if stripos($LINKED_RECORD_DETAIL_URL, 'javascript:')===0} onclick='{$LINKED_RECORD_DETAIL_URL|substr:strlen("javascript:")}'
                                                                    {else} onclick='window.location.href="{$LINKED_RECORD_DETAIL_URL}"' {/if}>{$RELATION->getLinkedRecord()->getName()}</a>
                                                    {/if}{vtranslate('LBL_FOR')} <a class="text-info cursorPointer" {if stripos($PARENT_DETAIL_URL, 'javascript:')===0}
                                                       onclick='{$PARENT_DETAIL_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$PARENT_DETAIL_URL}"' {/if}>
                                                                    {$RELATION->getParent()->getParent()->getName()}</a>
                                                    </div>
                                            {else if $HISTORY->isRestore()}
                                                    <div>
                                                            <b>{$USER->getName()}</b> {vtranslate('LBL_RESTORED')} <a class="text-info cursorPointer" {if stripos($DETAILVIEW_URL, 'javascript:')===0}
                                                                                                                                                                              onclick='{$DETAILVIEW_URL|substr:strlen("javascript:")}' {else} onclick='window.location.href="{$DETAILVIEW_URL}"' {/if}>
                                                                    {$PARENT->getName()}</a>
                                                    </div>
                                            {else if $HISTORY->isDelete()}
                                                    <div>
                                                            <b>{$USER->getName()}</b> {vtranslate('LBL_DELETED')} 
                                                            <strong> {$PARENT->getName()}</strong>
                                                    </div>
                                            {/if}
                                    </div>
                                    <p class="pull-right muted" style="padding-right:10px;"><span title="{Vtiger_Util_Helper::formatDateTimeIntoDayString("$TIME")}">{Vtiger_Util_Helper::formatDateDiffInStrings("$TIME")}</span></p>
                            </div>
                    {/if}
                    {else if $MODELNAME == 'ModComments_Record_Model'}
                            <div class="row">
                                    <div class="col-lg-2 col-xs-3 pull-left">
                                        {*<span><i class="material-icons entryIcon" title={$TRANSLATED_MODULE_NAME}>chat</i></span>*}
                                            <span><i class="fa fa-envelope" title="{$TRANSLATED_MODULE_NAME}"></i></span>
                                    </div>
                                    <div class="col-lg-10 col-xs-9 pull-right" style="margin-top:5px;">
                                            {assign var=COMMENT_TIME value=$HISTORY->getCommentedTime()}
                                            <div>
                                                    <b>{$HISTORY->getCommentedByName()}</b> {vtranslate('LBL_COMMENTED')} {vtranslate('LBL_ON')} <a class="text-info textOverflowEllipsis" href="{$HISTORY->getParentRecordModel()->getDetailViewUrl()}">{$HISTORY->getParentRecordModel()->getName()}</a>
                                            </div>
                                            <div><i>"{nl2br($HISTORY->get('commentcontent'))}"</i></div>
                                    </div>
                                    <p class="pull-right muted" style="padding-right:10px;"><small title="{Vtiger_Util_Helper::formatDateTimeIntoDayString("$COMMENT_TIME")}">{Vtiger_Util_Helper::formatDateDiffInStrings("$COMMENT_TIME")}</small></p>
                            </div>
                    {/if}
            {/foreach}

            {if $NEXTPAGE}
                    <div class="row">
                            <div class="col-lg-12">
                                    <h4><a href="javascript:;" class="text-info load-more" data-page="{$PAGE}" data-nextpage="{$NEXTPAGE}">{vtranslate('LBL_MORE')}...</a></h4>
                            </div>
                    </div>
            {/if}

    {else}
            <span class="noDataMsg">
                    {if $HISTORY_TYPE eq 'updates'}
                            {vtranslate('LBL_NO_UPDATES', $MODULE_NAME)}
                    {elseif $HISTORY_TYPE eq 'comments'}
                            {vtranslate('LBL_NO_COMMENTS', $MODULE_NAME)}
                    {else}
                            {vtranslate('LBL_NO_UPDATES_OR_COMMENTS', $MODULE_NAME)}
                    {/if}
            </span>
    {/if}
</div>