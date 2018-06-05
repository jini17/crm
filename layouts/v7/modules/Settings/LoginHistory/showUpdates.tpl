{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
* Created By Mabruk on 25/05/2018
********************************************************************************/
-->*}
{strip}
   <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
            	History
            </div>
            <div class="modal-body">
            	<table border=1 style="width:100%">

            			<tr>
		            		<th>&nbsp;Date</th>
		            		<th>&nbsp;Action</th>
		            		<th>&nbsp;Module</th>
		            		<th>&nbsp;Record Name</th>
		            		<th>&nbsp;Modification Details</th>
	            		</tr>
            			{foreach from=$DATA item=VALUES}
            			<tr>
            				<td> &ensp;&nbsp;{$VALUES.changedon}</td>
		            		<td> &ensp;&nbsp;{$VALUES.status}</td>
		            		<td> &ensp;&nbsp;{$VALUES.module}</td>
		            		<td> &ensp;&nbsp;{$VALUES.name}</td>
		            		{if $VALUES.status eq "Modified"}
			            		<td> {foreach from=$VALUES.modificationData item=INNERVALUES}
				            			&ensp;&nbsp;Label: <b>{$INNERVALUES.fieldname}</b><br>
				            			&ensp;&nbsp;Changed From: <span style="color:blue">{$INNERVALUES.prevalue}</span><br>
				            			&ensp;&nbsp;Changed To: <span style="color:blue">{$INNERVALUES.postvalue}</span><br><br>
			            			 {/foreach}
			            		</td>
		            		{else}
								<td> &ensp;&nbsp;Not Applicable</td>
							{/if}			            		
            			</tr>
            			{/foreach}	
            	</table>
            </div>
            <div class="modal-footer">
            	<input class="btn btn-success saveButton" type="button" value="Close" id="close">
            </div>
        </div>
    </div>
{/strip}
