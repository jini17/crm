{*<!--
/*+***********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************/
-->*}

{strip}
		
		<hr>
		<div class="col-lg-3 col-md-3 col-xs-12">
                {assign var=RECORD_COUNT value=$LISTVIEW_ENTIRES_COUNT}
                {include file="Pagination.tpl"|vtemplate_path:$MODULE SHOWPAGEJUMP=true}
                <button class="essentials-toggle hidden-sm hidden-xs pull-right" style="top: 1px;left: 96%;" title="Left Panel Show/Hide">
                    <span class="essentials-toggle-marker fa fa-chevron-right cursorPointer"></span></button>                    
        </div>

    </div>
</div>
</div>
</div>
{/strip}