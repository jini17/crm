<div class="alphabetSorting">
        <table width="100%" class="table-bordered" style="border: 1px solid #ddd;table-layout: fixed">
                <tbody>
                        <tr>
                        {foreach item=ALPHABET from=$ALPHABETS}
                                <td class="alphabetSearch textAlignCenter cursorPointer {if $ALPHABET_VALUE eq $TEXT_FILTER} highlightBackgroundColor {/if}" style="padding : 0px !important">
{*                                                                                                    <a id="{$ALPHABET}" data-alphabet="{$ALPHABET}" href="{$PAGE_URL}&empview={$EMP_VIEW}&search_value={$ALPHABET}">{$ALPHABET}</a>
*}                             <a id="{$ALPHABET}" data-alphabet="{$ALPHABET}">{$ALPHABET}</a>                                                            
                                </td>
                        {/foreach}
                        </tr>
                </tbody>
        </table>
</div>