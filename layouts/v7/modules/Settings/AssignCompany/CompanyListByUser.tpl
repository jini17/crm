{foreach key=COMPANY_KEY item=COMPANY_VALUE from=$COMPANY_LIST}
{if $ASSIGN_COMPANY_LIST|@count > 0}
	<div data-value="{$COMPANY_VALUE.organization_id}" data-id="{$COMPANY_VALUE.organization_id}" style="border: 1px solid #adadad;padding: 4%;overflow: hidden;text-overflow: ellipsis;" class="cursorPointer assignToUserCompanyListValue 
	{if in_array($COMPANY_VALUE.organization_id,$ASSIGN_COMPANY_LIST.OrganizationId)}selectedCell{else}unselectedCell{/if}">
	{if in_array($COMPANY_VALUE.organization_id,$ASSIGN_COMPANY_LIST.OrganizationId)}<i class="icon-ok pull-left"></i>{/if}{$COMPANY_VALUE.organization_name}
</div>
{else}
	<div data-value="{$COMPANY_VALUE.organization_id}" data-id="{$COMPANY_VALUE.organization_id}" style="border: 1px solid #adadad;padding: 4%;overflow: hidden;text-overflow: ellipsis;" class="cursorPointer assignToUserCompanyListValue unselectedCell">
{$COMPANY_VALUE.organization_name}
</div>
{/if}
{/foreach}
