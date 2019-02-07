{*<!--
   /*********************************************************************************
     ** The contents of this file are subject to the vtiger CRM Public License Version 1.0
      * ("License"); You may not use this file except in compliance with the License
      * The Original Code is:  vtiger CRM Open Source
      * The Initial Developer of the Original Code is vtiger.
      * Portions created by vtiger are Copyright (C) vtiger.
      * All Rights Reserved.
     *
    ********************************************************************************/
   -->*}
<div style='padding:5px;'>
    <style>
        .fa-facebook {
          background: #3B5998;
          color: white;
          padding: 8px;
        }
        .fa-twitter {
          background: #55ACEE;
          color: white;
          padding:8px;
        }
        .fa-envelope {
          background: #ff6600;
          color: white;
          padding: 8px;
        }
        .fa-linkedin {
          background: #007bb5;
          color: white;
          padding: 8px;
        }
            </style>
{if $DATA['contract'] neq 0}
<div class="row ">
    <div class="col-md-8" style="padding-right: 0;">
     <div class='col-md-12' style="padding:0;"> 
         <h4>{vtranslate('LBL_GOOD_DAY','Home')}, {$DATA['first_name']}..!</h4>
     </div>
        <div class='col-md-12' style="padding:5px 0 ;"> 
            
                <i class='ti ti-id-badge'></i>&nbsp;&nbsp;{$DATA['employee_id']}
            </div>
             <div class='col-md-12' style="padding:5px 0 ;"> 
                 <i class='ti ti-user'></i>&nbsp;&nbsp;{vtranslate('LBL_WORKING_AS',"Home")}  {$DATA['designation']}
             </div>
             <div class='col-md-12' style="padding:5px 0 ;"> 
                 <i class='ti ti-list-ol'></i>&nbsp;&nbsp;{$DATA['department']} {vtranslate('LBL_DEPARTMENT', 'Home')}
             </div>
              <div class='col-md-12' style="padding:5px 0 ;"> 
                  <i class='ti ti-briefcase'></i>&nbsp;&nbsp;{vtranslate('LBL_OF_JOB','Home')} {$DATA['job_grade']} 
              </div>
              <div class='col-md-12' style="padding:5px 0 ;"> 
                  <i class='ti ti-user'></i>&nbsp;&nbsp;{vtranslate('LBL_REPORTING_TO','Home')} 
                  <a href='{$URL}/index.php?module=Users&parent=Settings&view=Detail&record={$DATA['report_to']['id']}'>
                      {$DATA['report_to']['name']} 
                  </a>
              </div>
              <div class='col-md-12' style="padding:5px 0 ;"> 
                <i class='ti ti-calendar'></i>&nbsp;&nbsp;{$DATA['job_type']} {vtranslate('LBL_JOB',$MODULE_NAME)} {vtranslate('LBL_SINCE','Home')} {$DATA['contract_start']}
            
           </div>
        {if $DATA['job_type'] eq 'Contract'  }
            <div class='col-md-12' style="padding:5px 0 ;"> 
                         <i class='ti ti-calendar'></i>&nbsp;&nbsp;{vtranslate('LBL_CONTRACT_EXPIRE',$MODULE_NAME)}  {$DATA['expire']}
            </div>
        {/if}
    </div>
    {assign var=image value=Users_Record_Model::getCurrentUserModel()}
     {assign var=IMAGE_DETAILS value=$image->getImageDetails()}
  
                <div class="col-md-4" style='padding-left: 0;'>
                    <div class="image-holder">
                        <img class="img-thumbnail" src="{$URL}/{$DATA['thumb']}">
                    </div>
                    <div class="clearfix"></div>
                    <a href="{$URL}/index.php?module=Users&parent=Settings&view=Detail&record={$DATA['emp_id']}" class="btn btn-lg btn-block btn-primary"> {vtranslate('LBL_VIEW_PROFILE',$MODULE_NAME)}</a>
                    <a href="{$URL}/index.php?module=EmployeeContract&view=Detail&record={$DATA['contract']}&app=MARKETING" class="btn  btn-lg btn-block btn-default">  {vtranslate('LBL_VIEW_CONTRACT',$MODULE_NAME)} </a>
                    <div class="clearfix"></div>
                    <div class="clearfix" style="heigth:15px;"></div>
                    <div class="clearfix"></div>
                    <div class="social text-center" style="margin-top:5px;">
                          <a href="{$DATA['facebook']}" class="fab fa-facebook-f"></a>
                            <a href="{$DATA['twitter']}" class="fab fa-twitter"></a>
                            <a href="{$DATA['linkedin']}" class="fab fa-linkedin-in"></a>
                            <a href="#" onclick="javascript:Vtiger_Helper_Js.getInternalMailer({$DATA['emp_id']},'email','Users');" class="fa fa-envelope"></a>
                     
                    </div>
                </div>
</div>
<div class="clearfix"></div>
{else}
  <small>
      {vtranslate('LBL_NO_CONTRACT_FOUND','Home')}
  </small>
{/if}
                    
</div>