{strip}
{assign var=EDIT_EMERGENCY_URL value=$EMERGENCY_RECORD_MODEL->getEditEmergencyUrl()}
<div id="UserEmergencyContainer">
	<div class="myProfileBtn">
			<button type="button" class="btn btn-primary pull-right" onclick="Users_Emergency_Js.addEmergency('{$EDIT_EMERGENCY_URL}&userId={$USERID}');"><i class="fa fa-pencil"></i>&nbsp;&nbsp;<strong>{vtranslate('LBL_EDIT_CONTACT', $MODULE)}</strong></button>
		</div>
        <div class="clearfix"></div>

        <div class="block block_LBL_USER_EMERGENCY">
                            <div>
                                <h5>Emergency Contacts</h5>
                                <hr>
                                <div class="blockData">
                                    <div class="table detailview-table no-border">
                                            <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_CONTACT_NAME" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_CONTACT_NAME', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_CONTACT_NAME" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EMERGENCY_CONTACTS['contact_name']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_HOME_PH">
                                                    <span class="muted">{vtranslate('LBL_HOME_PH', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_HOME_PH" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EMERGENCY_CONTACTS['home_phone']}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_OFFICE_PH" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_OFFICE_PH', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_OFFICE_PH" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EMERGENCY_CONTACTS['office_phone']}</span>
                                                </div>
                                                <div class="fieldLabel col-xs-6 textOverflowEllipsis   col-md-3 medium" id="Users_detailView_fieldLabel_LBL_MOBILE">
                                                    <span class="muted">{vtranslate('LBL_MOBILE', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_MOBILE" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EMERGENCY_CONTACTS['mobile']}</span>
                                                </div>

                                                <div class="row">
                                                <div id="Users_detailView_fieldLabel_LBL_RELATIONSHIP" class="fieldLabel col-xs-6 textOverflowEllipsis col-md-3 medium">
                                                    <span class="muted">{vtranslate('LBL_RELATIONSHIP', $MODULE)}</span>
                                                </div>
                                                <div id="Users_detailView_fieldLabel_LBL_RELATIONSHIP" class="fieldValue  col-xs-6 col-md-3 medium">
                                                    <span class="value textOverflowEllipsis" data-field-type="string">{$USER_EMERGENCY_CONTACTS['relationship']}</span>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
        </div>
</div>
{/strip}
