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
<script src="layouts/vlayout/modules/Emails/resources/MassEdit.js?v=6.1.0" type="text/javascript"></script>
<div style='padding:5px;'>
{if count($MODELS) > 0}
<table class="table table-bordered listViewEntriesTable">
        <thead>
                <tr>
                        <th style="width:52%;">
                        <b>{vtranslate('LBL_NAME', $MODULE_NAME)}</b>
                        </th>
                        <th colspan="2">
                        <b>{vtranslate('LBL_BIRTHDATE', $MODULE_NAME)}</b>
                        </th>
                </tr>
        </thead>
        <tbody>
                {foreach item=MODEL from=$MODELS}
                        <tr class="birthdaywish" style="cursor:pointer;">
                                <td>
                                {$MODEL['fullname']}
                                </td>
                                <td>
                                {$MODEL['dateofbirth']}
                                </td>
                                <td>
                        <!--added by fadzil 27/2/15--><i class="icon-gift alignBottom" title="{vtranslate('LBL_BIRTHDAY_WISH')}"></i>
                        <input id="modulename" type="hidden" value="{$MODEL['module']}">
                        <input id="fieldname" type="hidden" value="{$MODEL['fieldname']}">
                        <input id="birthdayid" type="hidden" value="{$MODEL['id']}"></td></tr>
                {/foreach}
                <div class="clearfix"></div>
                        <a href="index.php?module=Users&view=List" class="btn-widget-view-more">{vtranslate('LBL_VIEW_MORE', $MODULE_NAME)}</a>
        </tbody>
</table>
{else}
        <span class="noDataMsg">
                {vtranslate('LBL_NO','Home')} {vtranslate('LBL_BIRTHDAY','Home')} {vtranslate($TYPELABEL,'Home')}
        </span>
{/if}
</div>
