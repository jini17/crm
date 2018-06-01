<div class="modal-dialog">
    <div class='modal-content'>
        <div class="contents">
            &ensp;<button class="addFromAddress btn btn-danger span10 marginLeftZero"  id="addFromAddress">{vtranslate('LBL_ADD_VALUE',$QUALIFIED_MODULE)}</button>
            &ensp;<button class="deleteFromEmail btn btn-danger span10 marginLeftZero"  id="deleteFromEmail">{vtranslate('LBL_DELETE_VALUE',$QUALIFIED_MODULE)}</button>

            <form id="addFromAddressForm" class="addFromAddressForm form-horizontal" method="POST">               
                <div class="container float-left">
                    <div class="contents row form-group float-left">
                        <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Name :</label></div>
                        <div class="col-lg-4 col-md-4">
                            <input type="text" placeholder="Type the name here..." id="name" name="name">
                        </div>
                    </div>
                </div>
                <div class="container float-left">

                    <div class="contents row form-group">
                        <div class="col-lg-offset-1 col-lg-2 col-md-2 col-sm-2 control-label fieldLabel"><label>Email :</label></div>
                        <div class="fieldValue col-lg-4 col-md-4 col-sm-4 ">
                            <input type="email" placeholder="abcd@yourdomain.com" id="email" name="email">
                        </div>
                    </div>
                </div>
                <center>
                    <button class="saveFromAddress btn btn-success" type="button" id="saveFromAddress" name="saveFromAddress"><strong>{vtranslate('LBL_SAVE', $MODULE)}</strong></button>
                    <a href="#" id="cancelForm" class="cancelForm" style="color:red;">{vtranslate('LBL_CANCEL', $MODULE)}</a>
                </center>  
                <br>  
            </form>

            <div id="listFromAddress" class="listFromAddress">    
                <table class="table table-bordered table-condensed themeTableColor">
                    <thead>
                        <th>
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
</div>