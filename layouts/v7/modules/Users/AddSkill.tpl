{strip}
<style>
.select2
{
	width:300px;
}
</style>
<div id="formcontainer">
	<div class="modal-header contentsBackground">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		 <h3>{vtranslate('LBL_ADD_SKILL', $MODULE)}</h3>
	</div>
	<form id="addSkill" name="addSkill" class="form-horizontal" method="POST">
		<input type="hidden" value="Users" name="module">
		<input type="hidden" value="SaveSubModuleAjax" name="action">
		<input type="hidden" value="Users" name="module">
		<input type="hidden" value="saveSkill" name="mode">
		<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">	
		<div class="modal-body">
			<div class="control-group">
				<label class="control-label">{vtranslate('LBL_ADD_SKILL', $MODULE)}</label>
				<div class="controls">
					<select  class="select2" onchange="updateSelectBox('skill','skillbox');" name="skill" id="skill">				{foreach key=SKILL_ID item=SKILL_MODEL from=$SKILL_LIST}
						<option value="{$SKILL_MODEL.skill_id}">{$SKILL_MODEL.skill}</option>
						{/foreach}
						<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
					</select>
				</div>
				<div class="controls">
					{if $SKILL_LIST|@count gt 0}
					<span class="hide" id="skillbox">
						<input style="width:190px;" type="text" name="skilltxt" id="skilltxt" data-validation-engine="validate[required]"/>
					</span>
					{else}
						<span id="skillbox">
						<span class="redColor">*</span>&nbsp;<input style="width:190px;" type="text" data-validation-engine="validate[required]"  name="skilltxt" id="skilltxt" />
					</span>
					{/if}
				</div>
			</div>
		</div>
		<div class="modal-footer">
			<div class="pull-right cancelLinkContainer" style="margin-top:0px;">
				<input class="cancelLink" type="button" value="Cancel" name="button" accesskey="LBL_CANCEL_BUTTON_KEY" title="Cancel" style="margin:0;background:none;border:none;" aria-hidden="true" data-dismiss="modal">
			</div>
			<input class="btn btn-success" type="submit" value="Save" name="saverecord" accesskey="LBL_SAVE_BUTTON_KEY" title="Save">
		</div>    		
	</form>			
</div>	
{literal}
<script>

function updateBox(selectbox, txtbox){

	var selectboxid = "#"+selectbox;
	
	$(selectboxid).select2("data", {id: "0", text: "Others"}); 
	$(selectboxid).select2("close");
	
	var selectobj = document.getElementById(selectbox);
	var txtobj    = document.getElementById(txtbox);

	txtobj.className = '';
}

function updateSelectBox(selectbox, txtbox)
{
	var selectobj = document.getElementById(selectbox);
	var txtobj    = document.getElementById(txtbox);
	if(selectobj.value=='0') {
		if(txtbox == 'skillbox') {
			txtobj.className = '';
		} 
	} else {
		txtobj.className = 'hide';
	}
}
</script>
{/literal}
</strip}
