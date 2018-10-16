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
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 detailViewButtoncontainer">
        <div class="pull-right">
        </div>
            <div class="pull-right btn-toolbar">
             
                  
<div class="btn-group">
            {assign var=STARRED value=$RECORD->get('starred')}
            {if $MODULE_MODEL->isStarredEnabled()}
                <button class="btn btn-primary markStar {if $STARRED} active {/if}" id="starToggle">
                    <div class='starredStatus' title="{vtranslate('LBL_STARRED', $MODULE)}">
                        <div class='unfollowMessage'>
                            <i class="material-icons">star</i> &nbsp;{vtranslate('LBL_UNFOLLOW',$MODULE)}
                        </div>
                        <div class='followMessage'>
                            <i class="material-icons active">star_border</i> <span class="hidden-xs">{vtranslate('LBL_FOLLOWING',$MODULE)}</span>
                        </div>
                    </div>
                    <div class='unstarredStatus' title="{vtranslate('LBL_NOT_STARRED', $MODULE)}">
                        {vtranslate('LBL_FOLLOW',$MODULE)}
                    </div>

                </button>
            {/if}
           
            {foreach item=DETAIL_VIEW_BASIC_LINK from=$DETAILVIEW_LINKS['DETAILVIEWBASIC']}
                <button data-toggle="toosltip" tippytitle data-placement="top" title="{vtranslate($DETAIL_VIEW_BASIC_LINK->getLabel(), $MODULE_NAME)}" class="btn btn-primary" id="{$MODULE_NAME}_detailView_basicAction_{Vtiger_Util_Helper::replaceSpaceWithUnderScores($DETAIL_VIEW_BASIC_LINK->getLabel())}"
                        {if $DETAIL_VIEW_BASIC_LINK->isPageLoadLink()}
                            onclick="window.location.href = '{$DETAIL_VIEW_BASIC_LINK->getUrl()}&app={$SELECTED_MENU_CATEGORY}'"
                        {else}
                            onclick="{$DETAIL_VIEW_BASIC_LINK->getUrl()}"
                        {/if}
                        {if $MODULE_NAME eq 'Documents' && $DETAIL_VIEW_BASIC_LINK->getLabel() eq 'LBL_VIEW_FILE'}
                            data-filelocationtype="{$DETAIL_VIEW_BASIC_LINK->get('filelocationtype')}" data-filename="{$DETAIL_VIEW_BASIC_LINK->get('filename')}" >
                        <i class="material-icons">zoom_in</i>
                        {/if}


                        {if Vtiger_Util_Helper::replaceSpaceWithUnderScores($DETAIL_VIEW_BASIC_LINK->getLabel()) eq "LBL_EDIT"}><i class="material-icons">create</i> {/if}
                        {if Vtiger_Util_Helper::replaceSpaceWithUnderScores($DETAIL_VIEW_BASIC_LINK->getLabel()) eq "LBL_SEND_EMAIL"}><i class="material-icons">email</i> {/if}

                        <span class="hidden-sm hidden-xs">{vtranslate($DETAIL_VIEW_BASIC_LINK->getLabel(), $MODULE_NAME)}</span>

                
                </button>
            {/foreach}
            {if $DETAILVIEW_LINKS['DETAILVIEW']|@count gt 0}
                <button class="btn btn-primary dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);">
                   <i class="material-icons">list</i> <span class="hidden-sm hidden-xs">{vtranslate('LBL_MORE', $MODULE_NAME)}</span> &nbsp;&nbsp;<i class="caret"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-right animated fadeIn">
                    {foreach item=DETAIL_VIEW_LINK from=$DETAILVIEW_LINKS['DETAILVIEW']}
                        {if $DETAIL_VIEW_LINK->getLabel() eq ""} 
                            <li class="divider"></li>   
                            {else}
                            <li id="{$MODULE_NAME}_detailView_moreAction_{Vtiger_Util_Helper::replaceSpaceWithUnderScores($DETAIL_VIEW_LINK->getLabel())}">
                                {if $DETAIL_VIEW_LINK->getUrl()|strstr:"javascript"} 
                                    <a href='{$DETAIL_VIEW_LINK->getUrl()}'>{vtranslate($DETAIL_VIEW_LINK->getLabel(), $MODULE_NAME)}</a>
                                {else}
                                    <a href='{$DETAIL_VIEW_LINK->getUrl()}&app={$SELECTED_MENU_CATEGORY}' >{vtranslate($DETAIL_VIEW_LINK->getLabel(), $MODULE_NAME)}</a>
                                {/if}
                            </li>
                        {/if}
                    {/foreach}
                </ul>
            {/if}
            </div>
            {if !{$NO_PAGINATION}}
            <div class="button-group pull-right">
                <button class="btn btn-secondary" id="detailViewPreviousRecordButton" {if empty($PREVIOUS_RECORD_URL)} disabled="disabled" {else} onclick="window.location.href = '{$PREVIOUS_RECORD_URL}&app={$SELECTED_MENU_CATEGORY}'" {/if} >
                    <i class="material-icons">keyboard_arrow_left</i>
                </button>
                <button class="btn btn-secondary " id="detailViewNextRecordButton"{if empty($NEXT_RECORD_URL)} disabled="disabled" {else} onclick="window.location.href = '{$NEXT_RECORD_URL}&app={$SELECTED_MENU_CATEGORY}'" {/if}>
                    <i class="material-icons">keyboard_arrow_right</i>
                </button>
            </div>
            {/if}        
        </div>
        <input type="hidden" name="record_id" value="{$RECORD->getId()}">

        {if $FIELDS_INFO neq null}
            <script type="text/javascript">
                var uimeta = (function () {
                    var fieldInfo = {$FIELDS_INFO};
                    return {
                        field: {
                            get: function (name, property) {
                                if (name && property === undefined) {
                                    return fieldInfo[name];
                                }
                                if (name && property) {
                                    return fieldInfo[name][property]
                                }
                            },
                            isMandatory: function (name) {
                                if (fieldInfo[name]) {
                                    return fieldInfo[name].mandatory;
                                }
                                return false;
                            },
                            getType: function (name) {
                                if (fieldInfo[name]) {
                                    return fieldInfo[name].type
                                }
                                return false;
                            }
                        },
                    };
                })();
            </script>
        {/if}

    </div>
{strip}
