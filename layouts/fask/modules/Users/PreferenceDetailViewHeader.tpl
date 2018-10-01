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
{assign var="MODULE_NAME" value=$MODULE_MODEL->get('name')}
<input id="recordId" type="hidden" value="{$RECORD->getId()}" />
<div class="detailViewContainer">
    <div class="detailViewTitle" id="prefPageHeader">
        <div class="row">
            <div class="col-lg-7 col-xs-12">
                {assign var=IMAGE_DETAILS value=$RECORD->getImageDetails()}
                {foreach key=ITER item=IMAGE_INFO from=$IMAGE_DETAILS}
                {if !empty($IMAGE_INFO.path) && !empty($IMAGE_INFO.orgname)}
                <span class="logo col-xs-2 hidden-sm hidden-xs">
                    <img style="border-radius: 50%;" height="75px" width="75px" src="{$IMAGE_INFO.path}_{$IMAGE_INFO.orgname}" alt="{$IMAGE_INFO.orgname}" title="{$IMAGE_INFO.orgname}" data-image-id="{$IMAGE_INFO.id}">
                </span>
                {/if}
                {/foreach}
                {if $IMAGE_DETAILS[0]['id'] eq null}
                <span class="profile-container logo col-xs-2 hidden-sm hidden-xs">
                    <i class="vicon-vtigeruser" style="font-size: 75px"></i> 
                </span>
                {/if}
                <span class="col-xs-10">
                    <span id="myPrefHeading">
                        <h3>{vtranslate('LBL_MY_PREFERENCES', $MODULE_NAME)} </h3>
                    </span>
                    <span>
                        {vtranslate('LBL_USERDETAIL_INFO', $MODULE_NAME)}&nbsp;&nbsp;"<b>{$RECORD->getName()}</b>"
                    </span>
                </span>
            </div>
            <div class="col-lg-5 col-xs-12">
               {*   <div class="essentials-toggle hidden-sm hidden-xs pull-right" title="Left Panel Show/Hide">
                <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </div>*}

            <button  class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 15px;left:93%;" title="Left Panel Show/Hide">
             <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
         </button>
     </div>
 </div>
 <div class="detailViewInfo userPreferences">
    <div class="details">
        <form id="detailView" data-name-fields='{ZEND_JSON::encode($MODULE_MODEL->getNameFields())}' method="POST">
            <div class="contents">
                <br>
                {/strip}
