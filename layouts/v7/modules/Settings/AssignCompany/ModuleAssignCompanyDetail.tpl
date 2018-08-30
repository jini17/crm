<div class="row-fluid layoutContent col-md-12" style="margin-bottom: 15px;">
	<div class="row-fluid col-md-6" style="margin-bottom: 15px;">
		<div class="col-sm-5">
			<div class="span2 textAlRight"><strong>{vtranslate('LBL_ASSIGN_COMPANY',$QUALIFIED_MODULE)} </strong></div>
		</div>		
		<div class="col-sm-7">	
			<div class="span3" style="overflow: hidden">
				<div id="assignToRolepickListValuesTable" class="row-fluid fontBold textAlignCenter">
					{foreach key=COMPANY_KEY item=COMPANY_VALUE from=$COMPANY_LIST}
						<div data-value="{$COMPANY_VALUE.organization_id}" data-id="{$COMPANY_VALUE.organization_id}" style="border: 1px solid #adadad;padding: 4%;overflow: hidden;text-overflow: ellipsis;" class="cursorPointer assignToUserCompanyListValue {if in_array($COMPANY_VALUE.organization_id,$ASSIGN_COMPANY_LIST.OrganizationId)}selectedCell{else}unselectedCell{/if}">
						{if $ASSIGN_COMPANY_LIST.OrganizationId|@count gt 0}
							{if in_array($COMPANY_VALUE.organization_id,$ASSIGN_COMPANY_LIST.OrganizationId)}<i class="fa fa-check pull-left"></i>{/if}{/if}{$COMPANY_VALUE.organization_name}
						</div>
					{/foreach}
				</div>

			</div>
		</div>
	</div>
	<div class="row-fluid col-md-6" style="margin-bottom: 15px;">
		<div><i class="fas fa-info-circle"></i>&nbsp;&nbsp;<span class="selectedCell padding1per">{vtranslate('LBL_SELECTED_VALUES',$QUALIFIED_MODULE)}</span>&nbsp;<span>{vtranslate('LBL_SELECTED_VALUES_MESSGAE',$QUALIFIED_MODULE)}</span></div><br>
		<div><i class="fas fa-info-circle"></i>&nbsp;&nbsp;<span>{vtranslate('LBL_ENABLE/DISABLE_MESSGAE',$QUALIFIED_MODULE)}</span></div><br>
		&nbsp;&nbsp;
	</div>
	
		<div class="col-md-12" style="display: block;margin: 0 auto;text-align: center;">
			<button id="saveOrder" disabled="" class="btn btn-success">{vtranslate('LBL_SAVE',$QUALIFIED_MODULE)}</button>
		</div>
			
</div>	
