<div id="modules-menu" class="modules-menu mmModulesMenu" style="width: 100%;">
        <div>
            {assign var=USERNAME value=Users_Record_Model::getCurrentUserModel()}
            <span class="mUserName"><i class="material-icons">email</i> {$USERNAME->get("first_name")} {$USERNAME->get("last_name")}</span>
            <div class="clearfix"></div>
            <span class="mmemail">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{$MAILBOX->username()}</span><br/><br/>
            <div class="btn-group text-center mmbtn">
                <span class="cursorPointer mailbox_refresh CountBadge  btn btn-secondary " title="{vtranslate('LBL_Refresh', $MODULE)}" tippytitle data-toggle="toolstip" data-original-title="{vtranslate('LBL_Refresh', $MODULE)}" data-tippy aria-describedby="tippy-1">
                    <i class="material-icons">refresh</i>
                </span>
                 
                <span class="cursorPointer mailbox_setting CountBadge btn btn-secondary  " title="{vtranslate('JSLBL_Settings', $MODULE)}" tippytitle data-toggle="toolstip" data-original-title="{vtranslate('JSLBL_Settings', $MODULE)}" data-tippy aria-describedby="tippy-2">
                    <i class="material-icons">settings</i> 
                </span>
                <span id="mail_compose" class="btn btn-secondary  cursorPointer " title="{vtranslate('LBL_Compose', $MODULE)}" tippytitle data-toggle="toolstip" data-original-title="{vtranslate('LBL_Compose', $MODULE)}" data-tippy aria-describedby="tippy-3">
            <i class="material-icons">create</i> 
                </span>
                
            </div>
        <div id='folders_list'></div>
        </div>
</div>