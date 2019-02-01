{*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
-->*}
{strip}
    <div class="listViewPageDiv" id="listViewContent" style="position:relative;">
              <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 82% !important; z-index: 999 " title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
        <div class="clearfix"></div>
        <div class="col-sm-12 col-xs-12 ">
            <div class="container-fluid" id="AnnouncementContainer">
                <div class="widget_header">
                    <h3>{vtranslate('LBL_ANNOUNCEMENTS', $QUALIFIED_MODULE)}</h3>
                </div>
                <hr>
                <div class="contents">
                    <textarea class="announcementContent textarea-autosize boxSizingBorderBox" rows="3" placeholder="{vtranslate('LBL_ENTER_ANNOUNCEMENT_HERE', $QUALIFIED_MODULE)}" style="width:100%" maxlength="150">{$ANNOUNCEMENT->get('announcement')}</textarea>
                    <span>{vtranslate('Maximum char allow', 'Vtiger')}&nbsp;:150</span>
                    <div class="textAlignCenter">
                        <br>
                        <button class="btn btn-success saveAnnouncement hide"><strong>{vtranslate('LBL_SAVE', $QUALIFIED_MODULE)}</strong></button>
                    </div>
                </div>
            </div>
{/strip}
