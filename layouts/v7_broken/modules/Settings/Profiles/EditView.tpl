{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}
{* modules/Settings/Profiles/views/Edit.php *}

{* START YOUR IMPLEMENTATION FROM BELOW. Use {debug} for information *}
<div class="editViewPageDiv">
	<div class="col-sm-12 col-xs-12 main-scroll">
		<form class="form-horizontal" id="EditView" name="EditProfile" method="post" action="index.php" enctype="multipart/form-data">
			<div class="editViewHeader">
				{if $RECORD_MODEL->getId()}
					<h4>
						{vtranslate('LBL_EDIT_PROFILE', $QUALIFIED_MODULE)}
					</h4>
				{else}
					<h4>
						{vtranslate('LBL_CREATE_PROFILE', $QUALIFIED_MODULE)}
					</h4>
				{/if}
			</div>
			<hr>
			<div class="editViewBody">
				<div class="editViewContents">
					<div id="submitParams">
						<input type="hidden" name="module" value="Profiles" />
						<input type="hidden" name="action" value="Save" />
						<input type="hidden" name="parent" value="Settings" />
						{assign var=RECORD_ID value=$RECORD_MODEL->getId()}
						<input type="hidden" name="record" value="{$RECORD_ID}" />
						<input type="hidden" name="mode" value="{$MODE}" />
						<input type="hidden" name="viewall" value="0" />
						<input type="hidden" name="editall" value="0" />
					</div>

					<div name='editContent'>
						 <div class="form-group">
                             <label class="control-label fieldLabel col-lg-3 col-md-3 col-sm-3">
                                <strong>{vtranslate('Select Plan', $QUALIFIED_MODULE)}&nbsp;<span class="redColor">*</span></strong>
                          </label>
                            <div class="controls fieldValue col-lg-4 col-md-4 col-sm-4" >
                               <select class="select2 inputElement col-lg-12" id="planFilter" name="plantitle">
                                    <option value="Foundation" {if $RECORD_MODEL->get('planid') eq 'Foundation'}selected{/if}>{vtranslate('Foundation', $QUALIFIED_MODULE)}</option>
                                    <option value="Sales" {if $RECORD_MODEL->get('planid') eq 'Sales'}selected{/if}>{vtranslate('Sales', $QUALIFIED_MODULE)}</option>
                                    <option value="Support" {if $RECORD_MODEL->get('planid') eq 'Support'}selected{/if}>{vtranslate('Support', $QUALIFIED_MODULE)}</option>
                                    <option value="Enterprise" {if $RECORD_MODEL->get('planid') eq 'Enterprise'}selected{/if}>{vtranslate('Enterprise', $QUALIFIED_MODULE)}</option>
                                    <option value="Sales+Support" {if $RECORD_MODEL->get('planid') eq 'Sales+Support'}selected{/if}>{vtranslate('Sales+Support', $QUALIFIED_MODULE)}</option>
                                </select>
                            </div>
                        </div>
						<div class="row form-group"><div class="col-lg-3 col-md-3 col-sm-3 control-label fieldLabel"> 
								<label>
									<strong>{vtranslate('LBL_PROFILE_NAME', $QUALIFIED_MODULE)}</strong>&nbsp;<span class="redColor">*</span>:&nbsp;
								</label></div>
							<div class="fieldValue col-lg-6 col-md-6 col-sm-6" > 
								<input type="text" class="inputElement" name="profilename" id="profilename" value="{$RECORD_MODEL->getName()}" data-rule-required="true" />
							</div>
						</div>

						<div class="row"><div class="col-lg-3 col-md-3 col-sm-3 control-label fieldLabel"> 
								<label>
									<strong>{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)}&nbsp;:&nbsp;</strong>
								</label></div>
							<div class="fieldValue col-lg-6 col-md-6 col-sm-6">
								<textarea name="description" class="inputElement" id="description" style="height:50px; resize: vertical;padding:5px 8px;">{$RECORD_MODEL->getDescription()}</textarea>
							</div>
						</div>
						<div class="form-group " data-content="new" >
                            <div class="profileData col-sm-12">
                            	{include file='EditViewContents.tpl'|vtemplate_path:$QUALIFIED_MODULE}
                            </div>
                        </div>
					</div>
				</div>
			</div>
			<div class='modal-overlay-footer clearfix'>
				<div class="row clearfix">
					<div class=' textAlignCenter col-lg-12 col-md-12 col-sm-12 '>
						<button type='submit' class='btn btn-success saveButton' >{vtranslate('LBL_SAVE', $MODULE)}</button>&nbsp;&nbsp;
						<a class='cancelLink' data-dismiss="modal" href="javascript:history.back()" type="reset">{vtranslate('LBL_CANCEL', $MODULE)}</a>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
