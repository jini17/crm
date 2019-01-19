{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Created By Mabruk
************************************************************************************}
{* modules/Settings/Vtiger/views/GoogleConfigIndex.php *}

{strip}	
<div id="body" style="position: relative;">
         <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 98% !important; z-index: 999 " title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
        <div class="clearfix"></div>
<div class=" col-lg-12 col-md-12 col-sm-12">
{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
<div id="Head">
        <div class="widget_header row-fluid">
                <div class="span8"><h3>{vtranslate('LBL_GOOGLE_CONFIG', $QUALIFIED_MODULE)}</h3></div>						
        </div>
        <hr>
        <br>
</div>

<div class="contents tabbable clearfix">
        <ul class="nav nav-tabs layoutTabs massEditTabs" id="tabs">
                <li class="tab-item taxesTab active"><a data-toggle="tab" href="#GoogleConfig"><strong>{vtranslate('LBL_GOOGLE_CONFIG', $QUALIFIED_MODULE)}</strong></a></li>
                <li class="tab-item chargesTab"><a data-toggle="tab" href="#AdvanceConfig"><strong>{vtranslate('LBL_ADVANCE_GOOGLE_CONFIG', $QUALIFIED_MODULE)}</strong></a></li>
        </ul>
        <div class="tab-content layoutContent padding20 overflowVisible">
                <div class="tab-pane active" id="GoogleConfig">
                        <div  id="contents">
                                <div class="container-fluid" id="GoogleConfigDetails">

                                        <div class="pull-right">
                                                <button class="btn editButton" id="editButton" data-url='{$MODEL->getEditViewUrl()}' type="button" title="{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}</strong></button>
                                        </div>

                                        <div class="contents">
                                                <table class="table table-bordered table-condensed themeTableColor">
                                                                <thead>
                                                                        <tr class="blockHeader">
                                                                                <th class="{$WIDTHTYPE}">
                                                                                        <span class="alignMiddle">{vtranslate('LBL_GOOGLE_CONFIG_FILE', $QUALIFIED_MODULE)}</span>
                                                                                </th>
                                                                                <th class="pull-right">
                                                                                        <p><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/createprj.png" title="Go to https://code.google.com/apis/console"><strong>{vtranslate('LBL_HOW_CONFIG',$QUALIFIED_MODULE)}</strong></a></p>	

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/newprj.png" title="Name your project and click create button"></a></p>

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/readyprj.png" title="Wait until your project ready"></a></p>

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/api.png" title="On your left hand side – select APIs"></a></p>

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/enable.png" title="Under google Apps APIs select Calendar API then click ENABLE API button"></a></p>

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/credential.png" title="Repeat step 6 for contact API <br />Go to Credentials. Under OAuth click Create new client ID"></a></p>

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/configure.png" title="Click configure consent screen"><strong>{vtranslate('LBL_HOW_CONFIG',$QUALIFIED_MODULE)}</strong></a></p>

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/configure2.png" title="Put your product name and click save"><strong>{vtranslate('LBL_HOW_CONFIG',$QUALIFIED_MODULE)}</strong></a></p>

                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/authorize.png" title="Under Authorized JavaScript origins put your url"></a></p>
                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/mismatchuri.png" title="Under Authorized redirect URLs copy url from the instance and paste then click create client id."></a></p>
                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/edit_client_secret.png" title="Copy and replace client id and Client Secret in the respective Text box"></a></p>
                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/googlecontact.png" title="Go to Contact Module and again sync"></a></p>
                                                                                        <p class="hide"><a class="group4" style="margin-right: 5px" href="layouts/vlayout/skins/help-img/googlecalendar.png" title="Go to Calendar Module and again sync"></a></p>
                                                                                </th>
                                                                        </tr>
                                                                </thead>
                                                                <tbody>
                                                                        {assign var=FIELD_DATA value=$MODEL->getViewableData()}
                                                                        {foreach key=FIELD_NAME item=FIELD_DETAILS from=$MODEL->getEditableFields()}
                                                                                <tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted marginRight10px pull-right">{vtranslate($FIELD_DETAILS['label'], $QUALIFIED_MODULE)}</label></td>
                                                                                        <td style="border-left: none;" class="{$WIDTHTYPE}">
                                                                                                <span>{$FIELD_DATA[$FIELD_NAME]}</span>
                                                                                        </td>
                                                                                </tr>
                                                                        {/foreach}
                                                                </tbody>
                                                </table>
                                        </div>
                                </div>
                        </div>
                </div>

                <div class="tab-pane" id="AdvanceConfig">
                        <div  id="AdvanceConfigContents">
                                <div class="container-fluid" id="AdvanceGoogleConfigDetails">

                                                        <div class="pull-right">
                                                                <button class="btn editButton" data-url='{$MODEL->getAdvanceEditViewUrl()}' type="button" title="{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}"><strong>{vtranslate('LBL_EDIT', $QUALIFIED_MODULE)}</strong></button>
                                                        </div>

                                        <div class="contents">
                                                <table class="table table-bordered table-condensed themeTableColor">
                                                                <thead>
                                                                        <tr class="blockHeader">
                                                                                <th class="{$WIDTHTYPE}">
                                                                                        <span class="alignMiddle">{vtranslate('LBL_GOOGLE_CONFIG_FILE', $QUALIFIED_MODULE)}</span>
                                                                                </th>
                                                                                <th class="pull-right">
                                                                                        <p><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-1.png" title="<a target='_blank' href='https://console.developers.google.com/flows/enableapi?apiid=drive'>Go to https://console.developers.google.com/flows/enableapi?apiid=drive<br>and click continue</a>"><strong>{vtranslate('LBL_HOW_CONFIG',$QUALIFIED_MODULE)}</strong></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-2.png" title="Click Go to credentials when this screen appears"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-3.png" title="Click the Cancel button when this screen shows up"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-4.png" title="In the Credentials screen, go to OAuth consent screen tab<br> and name your product, then click the save button"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-5.png" title="In the Credentials tab, click on create credentials and select OAuth client ID"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-6.png" title="Select Other in Create OAuth client ID screen and type a<br> name for the application type, then click on Create button"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-7.png" title="In OAuth client screen, click OK"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-8.png" title="In the Credentials tab, click on the download button shown in the screen to download the JSON file"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-9.png" title="When the Save form shows, click select the option Save File<br> and click OK"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-10.png" title="Click on the Edit Button marked in the picture above"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-11.png" title="Use browse button to browse the files from your PC"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-12.png" title="Select the Client-Secret JSON file you have downloaded"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-13.png" title="After the file is selected, click the button Request for Access Key Link"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-14.png" title="Go to the URL highlighted above by copy pasting it to the web browser"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-15.png" title="Choose your account"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-16.png" title="Click the Allow button"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-17.png" title="Copy the access key from the link"></a></p>

                                                                                        <p class="hide"><a class="group5" style="margin-right: 5px" href="layouts/vlayout/skins/google-drive-help-img/GAPI Howto-18.png" title="Paste the access key inside the Access Key field in the edit view of the Advance Google Config Tab, then click the Save button"></a></p>
                                                                                </th>
                                                                        </tr>
                                                                </thead>
                                                                <tbody>
                                                                        {foreach key=FIELD_NAME item=FIELD_VALUE from=$ADVANCED_FIELD_VALUES}
                                                                                {if $FIELD_NAME eq 'Access Key'}
                                                                                <tr><td width="30%" class="{$WIDTHTYPE}"><label class="muted marginRight10px pull-right">{$FIELD_NAME}</label></td>
                                                                                        <td style="border-left: none;" class="{$WIDTHTYPE}">
                                                                                                <span>{$FIELD_VALUE}</span>
                                                                                        </td></tr>
                                                                                {/if}										
                                                                        {/foreach}
                                                                </tbody>
                                                </table>
                                        </div>
                                </div>
                        </div>
                </div>	
        </div>
</div>
</div>
</div>
{/strip}