{************************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************}
{strip}
<div style='padding:5px'>
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-6 " style="">
                <strong> &nbsp;{vtranslate($WIDGET->getTitle(), $MODULE_NAME)} </strong>
            </div>
            <div class="col-md-6 col-sm-6 col-xs-6">
                 <button class="btn btn-sm btn-success pull-right dashboard_notebookWidget_save hide">
                        <strong>{vtranslate('LBL_SAVE', $MODULE)}</strong>
                </button>
                <button class="btn btn-primary btn-sm pull-right dashboard_notebookWidget_edit" style="margin-right: 10px;">
                        <strong>{vtranslate('LBL_EDIT', $MODULE)} </strong>
                </button>                                             
            </div>
            <div class="dashboard_notebookWidget_view" >
                <div class="clearfix"></div>

                <small style="margin-left: 18px;">{vtranslate('LBL_LAST_SAVED_ON', $MODULE)} &nbsp; {Vtiger_Util_Helper::formatDateTimeIntoDayString($WIDGET->getLastSavedDate())}</small>

<div class="clearfix"></div>
                        <br>
                        <div class="pushDown2per col-lg-12" style="word-break: break-all">
                                <div class="dashboard_notebookWidget_viewarea boxSizingBorderBox">
                                        {$WIDGET->getContent()|nl2br}
                                </div>
                        </div>
                </div>
                <div class="dashboard_notebookWidget_text" style="display:none;">
                        <div class="">
                                <span class="col-lg-10">
                                <small>{vtranslate('LBL_LAST_SAVED_ON', $MODULE)} &nbsp; {Vtiger_Util_Helper::formatDateTimeIntoDayString($WIDGET->getLastSavedDate())}</small>
                                </span>
                                <span class="col-lg-2">
                                        <span class="pull-right">
                                              
                                        </span>
                                </span>
                        </div>
                        <br>
                        <div class="clearfix"></div>
                        <br />
                        <div class="">
                                <span class="col-lg-12">
                                        <textarea class="dashboard_notebookWidget_textarea boxSizingBorderBox" data-note-book-id="{$WIDGET->get('id')}">
                                                {$WIDGET->getContent()}
                                        </textarea>
                                </span>
                        </div>
                </div>
        </div>
</div>
{/strip}
