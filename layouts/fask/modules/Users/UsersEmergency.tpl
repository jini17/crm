{strip}
  {assign var=total value=$USER_EMERGENCY_CONTACTS|@count}

{assign var=EDIT_EMERGENCY_URL value=$EMERGENCY_RECORD_MODEL->getEditEmergencyUrl()}
<div id="UserEmergencyContainer">
	<div class="btn-group pull-right allprofilebtn">
                 {if $USER_MODEL->get('id') eq $USERID OR $USER_MODEL->get('roleid') eq "H2" OR   $USER_MODEL->get('roleid') eq "H12" OR  $USER_MODEL->get('roleid') eq "H13" OR $USER_MODEL->isAdminUser() }
			<button type="button" class="btn btn-primary {if $total neq 0}hide{/if}" onclick="Users_Emergency_Js.addEmergency('{$EDIT_EMERGENCY_URL}&userId={$USERID}');">
                                                                            <i class="fa fa-pencil"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_ADD_CONTACT', $MODULE)}</strong>
                                                                </button>
        {/if}                                                        
		</div>
        <div class="clearfix"></div>
      
{foreach item=contact key=k from=$USER_EMERGENCY_CONTACTS}
        <div class="block block_LBL_USER_EMERGENCY">
                            <div>
                                <div class="col-md-6">
                                <h5>{vtranslate('Emergency Contacts', $MODULE)}</h5>
                                </div>
                                     {if $USER_MODEL->get('id') eq $USERID OR $USER_MODEL->get('roleid') eq "H2" OR   $USER_MODEL->get('roleid') eq "H12" OR  $USER_MODEL->get('roleid') eq "H13" OR $USER_MODEL->isAdminUser() }
                                <div class="col-md-6">
                                    <span class="pull-right">
                                      {if $total lt '5'}  <a href="#" onclick="Users_Emergency_Js.addEmergency('{$EDIT_EMERGENCY_URL}&userId={$USERID}');"><li class="fa fa-plus-circle"></li></a> &nbsp; {/if}
                                        <a href="#" onclick="Users_Emergency_Js.editEmergency('{$EDIT_EMERGENCY_URL}&userId={$USERID}&record_id={$contact['id']}');"><li class="fa fa-pencil"></li></a> &nbsp;
                                      {if $k neq '0'}  <a href="#" onclick="Users_Emergency_Js.deleteEmergerncyContact('{$EDIT_EMERGENCY_URL}&userId={$USERID}&delete_id={$contact['id']}','{$USERID}');"><li class="fa fa-trash-o"></li></a> &nbsp;{/if}
                                    </span>
                                </div>
                              {/if}  
                                <div class="clearfix"></div>
                               
                                <hr>
                                <div class="blockData">
                                    <div class="table detailview-table no-border">
                                            <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_CONTACT_NAME" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_CONTACT_NAME', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_CONTACT_NAME" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$contact['contact_name']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_HOME_PH">
                                                    <span class="muted">{vtranslate('LBL_HOME_PH', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_HOME_PH" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$contact['home_phone']}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_OFFICE_PH" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_OFFICE_PH', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_OFFICE_PH" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$contact['office_phone']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_MOBILE">
                                                    <span class="muted">{vtranslate('LBL_MOBILE', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_MOBILE" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$contact['mobile']}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_RELATIONSHIP" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_RELATIONSHIP', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_RELATIONSHIP" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$contact['relationship']}</span>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
{/foreach}
</div>
{/strip}
