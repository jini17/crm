{*<!--
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
-->*}
{strip}
<style>
.passwordSetting label{
	display:inline-block;
	margin-right:20px;
}
.passwordSetting input[type="checkbox"] {
	margin-right:10px;
}
</style>
<div class="container-fluid">
	<div class="clearfix treeView">
		<form id="PassForm" class="form-horizontal">
			<div class="widget_header row-fluid">
				<div class="span8"><h3>{vtranslate($MODULE, $MODULE)}</h3>&nbsp;{vtranslate('LBL_PASSWORD_DESCRIPTION', $MODULE)}</div>
			</div>
			<hr>
			<div class="col-md-8" >
				<table class="table table-bordered table-condensed themeTableColor passwordSetting">
					<thead>
						<tr class="blockHeader"><th colspan="2" class="mediumWidthType">{vtranslate('LBL_Password_Header', $MODULE)}</th></tr>
					</thead>
					<tbody>
						<tr>
							
							<td class="col-sm-6">
								<input type="checkbox" name="is_minlen" id="is_minlen" {if $DETAIL['min_length'] neq ''}checked{/if} />
								<label class="muted marginRight10px">{vtranslate('Minimum password length', $MODULE)}</label>
							</td>
							<td class="col-sm-6">
								<input type="text" name="min_length" id="min_length" value="{$DETAIL['min_length']}" {if $DETAIL['min_length'] eq ''}disabled{/if} />
							</td>
						</tr>
						<tr>
							<td class="col-sm-6">
								<input type="checkbox" name="is_maxlen" id="is_maxlen" {if $DETAIL['max_length'] neq ''}checked{/if} />
								<label class="muted marginRight10px">{vtranslate('Maximum password length', $MODULE)}</label>
							</td>
							<td class="col-sm-6">
								<input type="text" name="max_length" id="max_length" value="{$DETAIL['max_length']}" {if $DETAIL['max_length'] eq ''}disabled{/if} />
							</td>
						</tr>
						<tr>
							<td style="border-left: none;" class="marginRight col-sm-6">
								<input type="checkbox" name="big_letters" id="big_letters" {if $DETAIL['big_letters'] == 'true' }checked{/if} />
								<label class="muted">{vtranslate('Password must contain atleast one uppercase letters from A to Z', $MODULE)}</label>
							</td>
							<td class="col-sm-6"></td>
							
						</tr>
						<tr>
							<td class="col-sm-6" style="border-left: none;">
								<input type="checkbox" name="small_letters" id="small_letters" {if $DETAIL['small_letters'] == 'true'}checked{/if} />
								<label class="muted">{vtranslate('Password must contain atleast one lowercase letters a to z', $MODULE)}</label>
							</td>
							<td class="col-sm-6"></td>
							
						</tr>
						<tr>
							<td class="col-sm-6" style="border-left: none;">
								<input type="checkbox" name="numbers" id="numbers" {if $DETAIL['numbers'] == 'true'}checked{/if} />
								<label class="muted">{vtranslate('Password should contain atleast one numbers', $MODULE)}</label>
							</td>
							<td class="col-sm-6"></td>
							
						</tr>
			<!-- &nbsp;<span>{vtranslate('LBL_ALLOWCHAR',$MODULE)} [!@#$%^&*()\-_=+{};:,<.>]</span>-->
						<tr>
							<td class="col-sm-6" style="border-left: none;">
								<input type="checkbox" name="special" id="special"  {if $DETAIL['special'] == 'true'}checked{/if} />
								<label class="muted">{vtranslate('Password should contain special characters', $MODULE)}</label>
							</td>		
							<td class="col-sm-6"></td>			
						</tr>
						<tr>
							<td class="col-sm-6">
								<input type="checkbox" name="is_pwdexp" id="is_pwdexp" {if $DETAIL['pwd_exp'] neq ''}checked{/if} />
								<label class="muted  marginRight10px">{vtranslate('LBL_PWD_EXP_DAYS', $MODULE)}</label>
							</td>
							<td class="col-sm-6">
								<input type="text" {if $DETAIL['pwd_exp'] eq ''}disabled{/if} name="pwd_exp" id="pwd_exp" value="{$DETAIL['pwd_exp']}" />
							</td>
						</tr>

						<tr>
							<td class="col-sm-6">
								<input type="checkbox" name="is_pwdreuse" id="is_pwdreuse" {if $DETAIL['pwd_reuse'] neq ''}checked{/if} />
								<label class="muted  marginRight10px">{vtranslate('LBL_REMEMBER_PWD', $MODULE)}</label>
							</td>
							<td class="col-sm-6">
								<input type="text" {if $DETAIL['pwd_reuse'] eq ''}disabled{/if} name="pwd_reuse" id="pwd_reuse" value="{$DETAIL['pwd_reuse']}" /> &nbsp;
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</form>
	</div>
</div>
{/strip}
