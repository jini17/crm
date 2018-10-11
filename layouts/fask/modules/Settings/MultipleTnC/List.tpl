<!-- ===================================================================
Modified By: Zulhisyam, Soft Solvers Technologies (M) Sdn Bhd (www.softsolvers.com)
Modified Date: 11 / 06 / 2014
Change Reason: Multiple Terms An Conditions , New file created
=================================================================== -->
<!--start list-->
<div class="listViewPageDiv" id="layoutEditorContainer" style="position: relative;"> <!--id attr added by jitu@tar -->
               <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 0;right:0 !important ; left: 98% !important; z-index: 999 " title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span>
            </button>  
        <div class="clearfix"></div>
        <div class="widget_header row-fluid"><h3>{vtranslate('LBL_TANDC_TEXT', $QUALIFIED_MODULE)}</h3></div>
        <form name="massdelete" method="POST" onsubmit="VtigerJS_DialogBox.block();">
                <input name="idlist" type="hidden" id="idlist">	<!--id attr added by jitu@tar -->
                <input name="view" type="hidden">
                        <!--start button-->
                        <div class="listViewTopMenuDiv noprint">
                                <div class="listViewActionsDiv row-fluid">
                                        <span class="btn-toolbar span4">
                                                <span class="btn-group">
                                                        <input style="width:65px" class="btn btn-danger span10 marginLeftZero" type="button" value="{vtranslate('LBL_DELETE', $QUALIFIED_MODULE)}" id="deleteItem" > <!-- removed onclick event & change type submit to button-->
                                                </span>
                                                <span class="btn-group">
                                                        <button class="btn addButton" type="button" name="profile" onclick="location.href='index.php?parent=Settings&module=MultipleTnC&view=Edit&block=4&fieldid=21'">
                                                                <i class="icon-plus"></i>{vtranslate('LBL_NEW_TERMS', $QUALIFIED_MODULE)}
                                                        </button>
                                                </span>
                                        </span>
                                </div>
                        </div>
                <!--end button-->
                <!--start table-->
                <table class="table table-bordered listViewEntriesTable">
                        <thead>
                                <tr>
                                        <th nowrap>{vtranslate('LBL_LIST_SELECT', $QUALIFIED_MODULE)}</th>
                                        <th nowrap>{vtranslate('LBL_INVENTORY_TYPE', $QUALIFIED_MODULE)}</th>
                                        <th nowrap>{vtranslate('LBL_TERMS_TITLE', $QUALIFIED_MODULE)}</th>
                                        <th nowrap>{vtranslate('LBL_TERMS', $QUALIFIED_MODULE)}</th>
                                        <!--<th nowrap>{vtranslate('LBL_TEMPLATE_TOOLS', $QUALIFIED_MODULE)}</th>-->
                                </tr>
                        </thead>
                        {foreach name=termdetail1 item=termdetail from=$DETAILS}
                        <tr>
                                <td class="listTableRow small" valign=top><input type="checkbox" name="selected_id" value="{$termdetail.id}" onclick="ifselected(); " class="small"></td>
                                <td class="listTableRow small" valign=top>{$termdetail.type}</td>
                                <td class="listTableRow small" valign=top><a href="index.php?parent=Settings&amp;module=MultipleTnC&amp;view=Detail&amp;block=4&amp;fieldid=21&amp;id={$termdetail.id}"><b>{$termdetail.title}</b></a></td>
                                <td class="listTableRow small" valign=top>{$termdetail.tandc}&nbsp;</td>
                                <!--<td class="listTableRow small" valign=top><a href="index.php?module=Settings&action=detailviewemailtemplate&parenttab=Settings&templateid={$template.templateid}">{vtranslate('LNK_SAMPLE_EMAIL', $QUALIFIED_MODULE)}</a></td>-->
                        </tr>
                        {/foreach}
                </table>
                <!--end table-->
        </form>
</div>
<!--end list-->
