{*<!--
   /*********************************************************************************
   ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
   * ("License"); You may not use this file except in compliance with the License
   * The Original Code is:  vtiger CRM Open Source
   * The Initial Developer of the Original Code is vtiger.
   * Portions created by vtiger are Copyright (C) vtiger.
   * All Rights Reserved.
   ********************************************************************************/
-->*}

{strip}
<input type="hidden" id="supportedImageFormats" value='{ZEND_JSON::encode(Settings_Vtiger_CustomLogin_Model::$logoSupportedFormats)}' />
<div class="padding-left1per">
<div class="row-fluid widget_header">
   <div class="span8">
      <h3>{vtranslate('LBL_CUSTOM_LOGIN_PAGE', $QUALIFIED_MODULE)}</h3>
      {if $DESCRIPTION}<span style="font-size:12px;color: black;"> - &nbsp;{vtranslate({$DESCRIPTION}, $QUALIFIED_MODULE)}</span>{/if}
   </div>
   <div class="span4">
      <button id="updateCompanyDetails" class="btn editButton pull-right">{vtranslate('LBL_EDIT',$QUALIFIED_MODULE)}</button>
   </div>
</div>
<hr>
{assign var=WIDTHTYPE value=$CURRENT_USER_MODEL->get('rowheight')}
<div  id="CompanyDetailsContainer" class="{if !empty($ERROR_MESSAGE)}hide{/if}">
   <div class="row-fluid">
      <table class="table table-bordered">
         <thead>
            <tr class="blockHeader">
               <th colspan="2" class="{$WIDTHTYPE}"><strong>{vtranslate('LBL_COMPANY_LOGO',$QUALIFIED_MODULE)}</strong></th>
            </tr>
         </thead>
         <tbody>
            <tr>
               <td class="{$WIDTHTYPE}">
                  <div class="companyLogo">
                     <img height="150" width="550" src="{$MODULE_MODEL->getLogoPath()}" class="alignMiddle" />
                  </div>
               </td>
            </tr>
         </tbody>
      </table>
      <br>
      <table class="table table-bordered">
         <thead>
            <tr class="blockHeader">
               <th colspan="2" class="{$WIDTHTYPE}"><strong>{vtranslate('LBL_COMPANY_INFORMATION',$QUALIFIED_MODULE)}</strong></th>
            </tr>
         </thead>
         <tbody>
            {foreach from=$MODULE_MODEL->getFields() item=FIELD_TYPE key=FIELD}
            {if $FIELD neq 'logoname' && $FIELD neq 'logo' && $FIELD neq 'id' }
            <tr>
               <td class="{$WIDTHTYPE}" style="width:25%"><label class="pull-right">{vtranslate($FIELD,$QUALIFIED_MODULE)}</label></td>
               <td class="{$WIDTHTYPE}">
                  {if $FIELD eq 'address'} {$MODULE_MODEL->get($FIELD)|nl2br} {else} {$MODULE_MODEL->get($FIELD)} {/if}
               </td>
            </tr>
            {/if}
            {/foreach}
         </tbody>
      </table>
   </div>
</div>
<!--Finish Heading-->
<div class="col-md-12">
    <div class="col-md-2"></div>
     <form class="col-md-8 form-horizontal {if empty($ERROR_MESSAGE)}hide{/if}" id="updateCompanyDetailsForm" method="post" action="index.php" enctype="multipart/form-data">
            <input type="hidden" name="module" value="Vtiger" />
            <input type="hidden" name="parent" value="Settings" />
            <input type="hidden" name="action" value="CustomLoginSave" />
            <div class="control-group" style="margin-bottom: 15px;">
                <div class="control-label2 col-md-2">{vtranslate('LBL_COMPANY_LOGO',$QUALIFIED_MODULE)}</div>   
                <div class="controls col-md-10" >
                <div class="companyLogo col-md-12" id="logoarea" style="border: 1px solid #cecece;padding: 15px;margin-bottom: 20px;">
                    <img src="{$MODULE_MODEL->getLogoPath()}" class="alignMiddle" />
                </div>
              
                <div id="uploadclogo" class="col-sm-4" >
                    <input type="file" name="logo" id="logoFile" />&nbsp;&nbsp;
                </div>
                <div class="col-sm-8" id="uploadclogoalert">
                    <span class="alert alert-info" id="customlogalert">
                        {vtranslate('LBL_LOGO_RECOMMENDED_MESSAGE',$QUALIFIED_MODULE)}
                    </span>
                </div>
                {if !empty($ERROR_MESSAGE)}
                <br>
                <br>
                <div class="marginLeftZero span9 alert alert-error" style="margin-top: 10px;">
                    {vtranslate($ERROR_MESSAGE,$QUALIFIED_MODULE)}
                </div>
                {/if}
            </div>
        </div>
   {foreach from=$MODULE_MODEL->getFields() item=FIELD_TYPE key=FIELD}
   {if $FIELD neq 'logoname' && $FIELD neq 'logo' }
   <div class="col-md-12">
        <div class="col-md-2"></div>
        <div class="control-group col-md-8" style="margin-bottom: 15px;">
            <div class="control-label2 col-sm-2 {if $FIELD eq 'id'}hide{/if}">
                        {vtranslate($FIELD,$QUALIFIED_MODULE)}
            </div>
            <div class="controls col-md-10">
   
                {if $FIELD eq 'wcmsg' || $FIELD eq 'smdetail'}
                <textarea name="{$FIELD}" class="col-md-10" style="margin-bottom: 15px;">{$MODULE_MODEL->get($FIELD)}</textarea>
                {else if $FIELD eq 'smicon' }
                <select name="{$FIELD}" class="select2 col-md-10" data-validation-engine="validate[required]" style="margin-bottom: 15px;">
                    <option value="TW" {if $MODULE_MODEL->get($FIELD) eq 'TW'}selected{/if}>{vtranslate('TW',$QUALIFIED_MODULE)}</option>
                    <option value="FB" {if $MODULE_MODEL->get($FIELD) eq 'FB'}selected{/if}>{vtranslate('FB',$QUALIFIED_MODULE)}</option>
                </select>
                {else if $FIELD eq 'sessionout'}
                <select name="{$FIELD}" class="select2 col-md-10" data-validation-engine="validate[required]" style="margin-bottom: 15px;">
                    <option value="1" {if $MODULE_MODEL->get($FIELD) eq '1'}selected{/if}>1 min</option>
                    <option value="5" {if $MODULE_MODEL->get($FIELD) eq '5'}selected{/if}>5 min</option>
                    <option value="10" {if $MODULE_MODEL->get($FIELD) eq '10'}selected{/if}>10 min</option>
                    <option value="15" {if $MODULE_MODEL->get($FIELD) eq '15'}selected{/if}>15 min</option>
                    <option value="20" {if $MODULE_MODEL->get($FIELD) eq '20'}selected{/if}>20 min</option>
                    <option value="25" {if $MODULE_MODEL->get($FIELD) eq '25'}selected{/if}>25 min</option>
                    <option value="30" {if $MODULE_MODEL->get($FIELD) eq '30'}selected{/if}>30 min</option>
                    <option value="40" {if $MODULE_MODEL->get($FIELD) eq '40'}selected{/if}>40 min</option>
                    <option value="60" {if $MODULE_MODEL->get($FIELD) eq '60'}selected{/if}>60 min</option>
                    <option value="90" {if $MODULE_MODEL->get($FIELD) eq '90'}selected{/if}>90 min</option>
                    <option value="120" {if $MODULE_MODEL->get($FIELD) eq '120'}selected{/if}>120 min</option>
                    <option value="300" {if $MODULE_MODEL->get($FIELD) eq '300'}selected{/if}>300 min</option>
                </select>
                  <!-- added by jitu@secondcrm.com for showhide tooltip -->
                  {else if $FIELD eq 'istooltip'}
                      <select name="{$FIELD}" class="select2" data-validation-engine="validate[required]" >
                          <option value="Yes">Yes</option>
                          <option value="No">No</option>          
                      </select>

                 <!-- End here-->
                {else if $FIELD eq 'id' }
                    <input class="col-md-10" style="margin-bottom: 15px;padding: 6px 8px;" type="hidden" value="{$MODULE_MODEL->get($FIELD)}" name="{$FIELD}" /> 
                {else}
                    <input class="col-md-10" style="margin-bottom: 15px;padding: 6px 8px;" type="text" {if $FIELD eq 'wcmsg'} data-validation-engine="validate[required]" {/if} class="input-xlarge" name="{$FIELD}" value="{$MODULE_MODEL->get($FIELD)}" /> 
                {/if}
            </div>
        </div>
        <div class="col-md-2"></div> 
    </div>
     {/if}       
    {/foreach}

    <div class="ModalFooterContainer">
            {include file="ModalFooter.tpl"|@vtemplate_path:$QUALIFIED_MODULE}
    </div>
    <div class="col-md-2"></div>
</div>
 </form>  
{/strip}