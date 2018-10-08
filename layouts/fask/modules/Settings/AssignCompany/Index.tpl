{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is:  vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
*
********************************************************************************/
-->*}
{strip}
        <div class="listViewPageDiv custom-mod">
                <div class="container-fluid" style="position: relative;">
                    <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 1px;right:0 ; left:98%" title="Left Panel Show/Hide">
            <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span></button>  
            <div class="clearfix"></div>
                        <div class="listViewTopMenuDiv">
                                <h3>{vtranslate('LBL_ASSIGN_COMPANY_TOUSER',$QUALIFIED_MODULE)}</h3>
                                <hr>
                                <div class="clearfix"></div>
                        </div>
                        <div class="listViewContentDiv" id="listViewContents">
                                <br>
                                <div class="row-fluid col-md-12">
                                        <div class="row-fluid col-md-6">
                                                <div class="row-fluid col-sm-5">
                                                        <div class="span2 textAlRight"><strong>{vtranslate('LBL_SELECT_USER',$QUALIFIED_MODULE)} </strong></div>
                                                </div>

                                                <div class="row-fluid col-sm-7">
                                                        <div class="span6 fieldValue" style="width: 100%;">
                                                                <select class="select2 col-sm-12 select2-offscreen" id="selUserlist" style="width: 100%;">
                                                                                {foreach key=USER_KEY item=USERS from=$USERS_LIST}
                                                                                <option {if $DEFAULT_USER eq $USERS.id} selected="selected" {/if} value="{$USERS.id}">{$USERS.name}</option>
                                                                                {/foreach}	
                                                                </select>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="row-fluid col-md-6"></div>
                                </div>
                                <br />
                                <div id="modulePickListValuesContainer">
                                        {include file="ModuleAssignCompanyDetail.tpl"|@vtemplate_path:$QUALIFIED_MODULE}	
                                </div>
                        </div>
                </div>
        </div>
{/strip}	
