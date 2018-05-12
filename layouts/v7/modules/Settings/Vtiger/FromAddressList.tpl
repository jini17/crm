<div class="modal-dialog">
    <div class='modal-content'>
 
        <hr>
        <br>
    </div>

    <div class="contents tabbable clearfix">
        <button class="btn btn-danger span10 marginLeftZero"  id="deleteEmail">{vtranslate('LBL_DELETE_VALUE',$QUALIFIED_MODULE)}</button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;      

        <div class="contents">
            <table class="table table-bordered table-condensed themeTableColor">
                <thead>
                <th class="{$WIDTHTYPE}">
                    <span class="alignMiddle">{vtranslate('LBL_FROM_ADDRESS_SETTING', $QUALIFIED_MODULE)}</span>
                </th>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            Select
                        </td>
                        <td>
                            Name
                        </td>
                        <td>
                            Email Address
                        </td>                        
                    </tr>
                    {foreach item=VALUE from=$DATA}
                    <tr>
                        <td>
                            <input type="checkbox" name="selected_id" value="{$VALUE.id}" class="smallchkd">
                        </td>
                        <td>
                            {$VALUE.name}
                        </td>
                        <td>
                            {$VALUE.email}
                        </td>                        
                    </tr>
                    {/foreach}
                </tbody>
            </table>
        </div>
    </div>
    </div>