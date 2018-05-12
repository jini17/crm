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
		{if $LANG_ID neq ''}
		 <h3>{vtranslate('LBL_EDIT_LANGUAGE', $MODULE)}</h3>
		{else} 
		 <h3>{vtranslate('LBL_ADD_LANGAUGE', $MODULE)}</h3>
		{/if}
	</div>
	<form id="editLanguage" name="editLanguage" class="form-horizontal" method="POST">			
		<input type="hidden" value="Users" name="module">
		<input type="hidden" name="record" value="{$LANG_ID}" />	
		<input type="hidden" value="SaveSubModuleAjax" name="action">
		<input type="hidden" value="saveLanguage" name="mode">
		<input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">	
		<div class="modal-body">	
			<div class="control-group">
				<label class="control-label"><span class="redColor">*</span>{vtranslate('LBL_SELECT_LANGUAGE', $MODULE)}</label>
				<div class="controls">
					<select  class="select2" {if $LANGUAGE_DETAIL.language_id neq ''} disabled {/if}  onchange="updateSelectBox('language','languagebox');" name="language" id="language">		{foreach key=LANG_ID item=LANG_MODEL from=$LANGUAGE_LIST}
							<option value="{$LANG_MODEL.language_id}" {if $LANGUAGE_DETAIL.language_id eq $LANG_MODEL.language_id} selected {/if}>{$LANG_MODEL.language}</option>
						{/foreach}
							<option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
					</select>
				</div>
				<div class="controls">
					{if $LANGUAGE_LIST|@count gt 0}
					<span class="hide" id="languagebox">
						<input style="width:190px;" data-validation-engine="validate[required]" type="text" name="langtxt" id="langtxt" />
					</span>
					
					{else}
						<input style="width:190px;" data-validation-engine="validate[required]" type="text" name="langtxt" id="langtxt" />
					</span>
					{/if}
				</div>	
			</div>
			<div class="control-group">
				<label class="control-label">{vtranslate('LBL_EXPERTISE_LEVEL', $MODULE)}</label>	
				<div class="controls">
					<select  class="select2" name="proficiency" id="proficiency"> 					
						<option value="{vtranslate('LBL_PROFICIENCY', $QUALIFIED_MODULE)}" {if $LANGUAGE_DETAIL.proficiency eq {vtranslate('LBL_PROFICIENCY', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('LBL_PROFICIENCY', $QUALIFIED_MODULE)}...</option>
						<option value="{vtranslate('LBL_ELEMENTRY', $QUALIFIED_MODULE)}" {if $LANGUAGE_DETAIL.proficiency eq {vtranslate('LBL_ELEMENTRY', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('LBL_ELEMENTRY', $QUALIFIED_MODULE)}</option>
						<option value="{vtranslate('LBL_LIMITED_WORKING', $QUALIFIED_MODULE)}" {if $LANGUAGE_DETAIL.proficiency eq {vtranslate('LBL_LIMITED_WORKING', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('LBL_LIMITED_WORKING', $QUALIFIED_MODULE)}</option>
						<option value="{vtranslate('LBL_PROFESSIONAL_WORKING', $QUALIFIED_MODULE)}" {if $LANGUAGE_DETAIL.proficiency eq {vtranslate('LBL_PROFESSIONAL_WORKING', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('LBL_PROFESSIONAL_WORKING', $QUALIFIED_MODULE)}</option>
						<option value="{vtranslate('LBL_FULL_PROFESSIONAL', $QUALIFIED_MODULE)}" {if $LANGUAGE_DETAIL.proficiency eq {vtranslate('LBL_FULL_PROFESSIONAL', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('LBL_FULL_PROFESSIONAL', $QUALIFIED_MODULE)}</option>
						<option value="{vtranslate('LBL_NATIVE_BILINGUAL', $QUALIFIED_MODULE)}" {if $LANGUAGE_DETAIL.proficiency eq {vtranslate('LBL_NATIVE_BILINGUAL', $QUALIFIED_MODULE)}} selected {/if}>{vtranslate('LBL_NATIVE_BILINGUAL', $QUALIFIED_MODULE)}</option>
					</select>
				</div>
				<div class="controls">
					<span class="hide" id="languagebox">
						<input style="width:290px;" type="text" name="skilltxt" id="skilltxt" />
					</span>
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
		if(txtbox == 'languagebox') {
			txtobj.className = '';
		} 
	} else {
		txtobj.className = 'hide';
	}
}
</script>
{/literal}
{/strip}
