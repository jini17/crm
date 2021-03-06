{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************}
{strip}


<!--sidebar toggle center-->
        <div id="sidebar-essentials" class="sidebar-essentials visible-xs visible-sm">
        <div class="col-xs-12 text-center visible-xs visible-sm" style="padding: 20px;">
        
        <a class="btn btn-default" onclick="$('#modnavigator > div, .modules-menu').removeClass('hidden-xs hidden-sm').css('width','100%')">Sidebar 
        &nbsp;</a>
        
        </div>
        <div class="sidebar-menu hidden-xs hidden-sm">
       
        </div>
        </div>
<!--sidebar toggle center-->


    <div class='col-lg-12 col-xs-12 padding0px'>
        <span class="col-lg-1 paddingLeft5px mail-all-checked">
            <span class="miniux-icon"><i class="fa fa-minus"></i></span>
            <input type='checkbox' id='mainCheckBox' class="pull-left">
        </span>
        <span class="col-lg-5 padding0px">
            <span class="btn  cursorPointer mmActionIcon btn-sm" style="font-size:14px;" id="mmMarkAsRead" data-folder="{$FOLDER->name()}" title="{vtranslate('LBL_MARK_AS_READ', $MODULE)}">
                <!--<img src="layouts/v7/skins/images/envelope-open.png" id="mmEnvelopeOpenIcon">-->
                <i class="material-icons">email</i>
            </span>
            <span class="btn  cursorPointer mmActionIcon btn-sm" style="font-size:14px; " 
                  id="mmMarkAsUnread" data-folder="{$FOLDER->name()}" 
                  title="{vtranslate('LBL_Mark_As_Unread', $MODULE)}">       
                <i class="fa fa-book" style="font-size:11px;"></i>
            </span>
            <span class="btn  cursorPointer mmActionIcon btn-sm" style="font-size:14px;"  id="mmDeleteMail" data-folder="{$FOLDER->name()}" title="{vtranslate('LBL_Delete', $MODULE)}">
                <i class="material-icons">delete</i>
            </span>
            <span class="btn  btn-sm cursorPointer moveToFolderDropDown more dropdown action" style="font-size:14px;"  title="{vtranslate('LBL_MOVE_TO', $MODULE)}">
                <span class='dropdown-toggle' data-toggle="dropdown">
                    <i class="material-icons mmMoveDropdownFolder">folder</i>
                    <!--<i class="ti-arrow-right mmMoveDropdownArrow"></i>
                    <i class="fa fa-caret-down pull-right mmMoveDropdownCaret"></i>-->
                </span>
                <ul class="dropdown-menu" id="mmMoveToFolder">
                    {foreach item=folder from=$FOLDERLIST}
                        <li data-folder="{$FOLDER->name()}" data-movefolder='{$folder}'>
                            <a class="paddingLeft15">
                                {if mb_strlen($folder,'UTF-8')>20}
                                    {mb_substr($folder,0,20,'UTF-8')}...
                                {else}
                                    {$folder}
                                {/if}
                            </a>
                        </li>
                    {/foreach}
                </ul>
            </span>
        </span>
        <span class="col-lg-6 padding0px">
            <span class="pull-right">
                    {if $FOLDER->mails()}<span class="pageInfo">{$FOLDER->pageInfo()}&nbsp;&nbsp;</span> <span class="pageInfoData" data-start="{$FOLDER->getStartCount()}" data-end="{$FOLDER->getEndCount()}" data-total="{$FOLDER->count()}" data-label-of="{vtranslate('LBL_OF')}"></span>{/if}
                <button type="button" id="PreviousPageButton" class="btn  btn-sm marginRight0px" {if $FOLDER->hasPrevPage()}data-folder='{$FOLDER->name()}' data-page='{$FOLDER->pageCurrent(-1)}'{else}disabled="disabled"{/if}>
                    <i class="ti-angle-left"></i>
                </button>
                <button type="button" id="NextPageButton" class="btn btn-sm" {if $FOLDER->hasNextPage()}data-folder='{$FOLDER->name()}' data-page='{$FOLDER->pageCurrent(1)}'{else}disabled="disabled"{/if}>
                    <i class="ti-angle-right"></i>
                </button>
            </span>
        </span>
    </div>

    <div class='col-lg-12  col-xs-12 padding0px mail-filter-container'>
        
        <div class=" mmSearchContainerOther"  style="position:relative">
            <div class=" mmSearchDropDown" style="position:relative">
                     <span class="caret"></span>
                     <select id="searchType">
                         {foreach item=arr key=option from=$SEARCHOPTIONS}
                             <option value="{$arr}" {if $arr eq $TYPE}selected{/if}>{vtranslate($option, $MODULE)}</option>
                         {/foreach}
                     </select>
                 </div>
                     <div class="padding0px mmsearchbox" style="margin:0!important">
                    <input type="text" class="form-control" id="mailManagerSearchbox" aria-describedby="basic-addon2" value="{$QUERY}" data-foldername='{$FOLDER->name()}' placeholder="{vtranslate('LBL_TYPE_TO_SEARCH', $MODULE)}">
                </div>
                <div class='' id="mmSearchButtonContainer">
                    <button id='mm_searchButton' class="pull-right" style="width: 85px;"><i class="fas fa-search pull-left" style="margin-top: 3px;"></i>{vtranslate('LBL_Search', $MODULE)}</button>
                </div>
            
            </div>

      
    </div>
   {if $FOLDER->mails()}
        <div class="col-lg-12  col-xs-12 mmEmailContainerDiv padding0px" id='emailListDiv' style="margin-top:10px">
            {assign var=IS_SENT_FOLDER value=$FOLDER->isSentFolder()}
            <input type="hidden" name="folderMailIds" value="{','|implode:$FOLDER->mailIds()}"/>
            {foreach item=MAIL from=$FOLDER->mails()}
                {if $MAIL->isRead()}
                    {assign var=IS_READ value=1}
                {else}
                    {assign var=IS_READ value=0}
                {/if}
                <div class="col-lg-12 cursorPointer mailEntry {if $IS_READ}mmReadEmail{/if}" id='mmMailEntry_{$MAIL->msgNo()}' data-folder="{$FOLDER->name()}" data-read='{$IS_READ}'>
                    <span class="col-lg-1 paddingLeft5px">
                        <input type='checkbox' class='mailCheckBox' class="pull-left">
                    </span>
                    <div class="col-lg-11 mmfolderMails padding0px" title="{$MAIL->subject()}">
                        <input type="hidden" class="msgNo" value='{$MAIL->msgNo()}'>
                        <input type="hidden" class='mm_foldername' value='{$FOLDER->name()}'>
                        <div class="col-lg-8 nameSubjectHolder font11px padding0px stepText">
                            {assign var=DISPLAY_NAME value=$MAIL->from(33)}
                            {if $IS_SENT_FOLDER}
                                {assign var=DISPLAY_NAME value=$MAIL->to(33)}
                            {/if}
                            {assign var=SUBJECT value=$MAIL->subject()}
                            {if mb_strlen($SUBJECT, 'UTF-8') > 33}
                                {assign var=SUBJECT value=mb_substr($MAIL->subject(), 0, 30, 'UTF-8')}
                            {/if}
                            {if $IS_READ}
                                {strip_tags($DISPLAY_NAME)}<br>{strip_tags($SUBJECT)}
                            {else}
                                <strong>{strip_tags($DISPLAY_NAME)}<br>{strip_tags($SUBJECT)}</strong>
                            {/if}
                        </div>
                        <div class="col-lg-4 padding0px">
                            {assign var=ATTACHMENT value=$MAIL->attachments()}
                            {assign var=INLINE_ATTCH value=$MAIL->inlineAttachments()}
                            {assign var=ATTCHMENT_COUNT value=(count($ATTACHMENT) - count($INLINE_ATTCH))}
                            <span class="pull-right">
                                {if $ATTCHMENT_COUNT}
                                    <i class="material-icons font14px">attachment</i>&nbsp;
                                {/if}
                                <span class='mmDateTimeValue' title="{Vtiger_Util_Helper::formatDateTimeIntoDayString(date('Y-m-d H:i:s', strtotime($MAIL->_date)))}">{Vtiger_Util_Helper::formatDateDiffInStrings(date('Y-m-d H:i:s', strtotime($MAIL->_date)))}</span>
                            </span>
                        </div>
                            <div class="col-lg-12 mmMailDesc"><img src="{vimage_path('128-dithered-regular.gif')}"></img></div>
                    </div>
                </div>
            {/foreach}
        </div>
    {else}
        <div class="noMailsDiv"><center><strong>{vtranslate('LBL_No_Mails_Found',$MODULE)}</strong></center></div>
    {/if}
{/strip}
