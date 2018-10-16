{*<!--
/* ===================================================================
Modified By: Zulhisyam, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 12 / 06 / 2014
Change Reason: Multiple Company Details Feature, New file created
=================================================================== */

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
<script>
function ifselected()
{ldelim}


      var sel =document.massdelete.selected_id.length;
      var returnval=false;

     for(i=0; i < sel; i++)
     {ldelim}

      if(document.massdelete.selected_id[i].checked == true)
        {ldelim}
            returnval=true;
            break;
        {rdelim}

      {rdelim}

{rdelim}
</script>
<!--start list-->
<div class="container-fluid" id="layoutEditorContainer" style="position: relative;"> <!--id attr added by jitu@tar -->
               <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 98% !important; z-index: 999 " title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
        <div class="clearfix"></div>
        <form method="POST" name="massdelete">
        <input type="hidden" name="idlist" id="idlist">	<!--id attr added by jitu@tar -->
        <div class="listViewPageDiv">	
                <div class="widget_header row-fluid"><h3>{vtranslate('LBL_COMPANY_DETAILS', $QUALIFIED_MODULE)} </h3></div>
                <!--start button-->
                <div class="listViewTopMenuDiv noprint">
                        <div class="listViewActionsDiv row-fluid">
                                <span class="btn-toolbar span4">
                                        <span class="btn-group">
                                                <input style="width:65px" class="btn btn-danger span10 marginLeftZero" type="button" value="{vtranslate('LBL_DELETE', $QUALIFIED_MODULE)}" id="deleteItem" > <!-- removed onclick event & change type submit to button-->
                                        </span>
                                        <span class="btn-group">
                                                <button class="btn addButton" type="button" name="profile" onclick="location.href='index.php?parent=Settings&module=MultipleCompany&view=Edit&block=3&fieldid=14'">
                                                        <i class="icon-plus"></i>{vtranslate('LBL_NEW_COMPANY', $QUALIFIED_MODULE)}
                                                </button>
                                        </span>
                                </span> 
                        </div>
                </div>
                <!--end button-->
                <!--start list-->
                <table class="table table-bordered listViewEntriesTable">
                        <thead>
                                <tr>
                                        <th nowrap>#</th>
                                        <th nowrap>{vtranslate('LBL_LIST_SELECT', $QUALIFIED_MODULE)}</th>
                                        <th nowrap>{vtranslate('LBL_ORGANIZATION_TITLE', $QUALIFIED_MODULE)}</th>
                                        <th nowrap>{vtranslate('LBL_ORGANIZATION_NAME', $QUALIFIED_MODULE)}</th>
                                        <th nowrap>{vtranslate('LBL_ORGANIZATION_WEBSITE', $QUALIFIED_MODULE)}</th>
                                                <!--<td width="20%" class="colHeader small">{$UMOD.LBL_TEMPLATE_TOOLS}</td>-->
                                </tr>
                        </thead>

                                {foreach name=companydetail1 item=companydetail from=$DETAILS}
                                <tr>
                                        <td class="listTableRow small" valign=top>{$viewer.foreach.companydetail1.iteration}</td>
                                        {if $companydetail.organization_id neq 1}
                                        <td class="listTableRow small" valign=top><input type="checkbox" name="selected_id" value="{$companydetail.organization_id}" onClick="ifselected(); " class=small></td>
                                        {else}
                                        <td>&nbsp;</td>
                                        {/if}
                                        <td class="listTableRow small" valign=top>
                                                <a href="index.php?parent=Settings&amp;module=MultipleCompany&amp;view=Detail&amp;block=3&amp;fieldid=14&amp;organizationid={$companydetail.organization_id}" >{$companydetail.organization_title}</a>
                                        </td>
                                        <td class="listTableRow small" valign=top>
                                                {$companydetail.organization_name}
                                        </td>
                                        <td class="listTableRow small" valign=top>{$companydetail.organization_website}&nbsp;</td>
                                                <!--<td class="listTableRow small" valign=top>
                                                <a href="index.php?module=Settings&action=detailviewemailtemplate&parenttab=Settings&templateid={$template.templateid}">{$UMOD.LNK_SAMPLE_EMAIL}</a>
                                        </td>-->
                                </tr>
                                {/foreach}	

                </table>
        </div>
        </form>
</div>
<!--end list-->
