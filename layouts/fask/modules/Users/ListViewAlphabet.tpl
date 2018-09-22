<div class="alphabetSorting">
	<table width="100%" class="table-bordered" style="border: 1px solid #ddd;table-layout: fixed">
		<tbody>
			<tr>
			{foreach item=ALPHABET from=$ALPHABETS}
				<td class="alphabetSearch textAlignCenter cursorPointer {if $ALPHABET_VALUE eq $TEXT_FILTER} highlightBackgroundColor {/if}" style="padding : 0px !important"><a id="{$ALPHABET}" href="{$PAGE_URL}&empview={$EMP_VIEW}&Alphabet={$ALPHABET}">{$ALPHABET}</a></td>
			{/foreach}
			</tr>
		</tbody>
	</table>
</div>