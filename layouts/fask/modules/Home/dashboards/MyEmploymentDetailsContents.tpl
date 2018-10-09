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
    

<div class="row ">
    <div class="col-md-8" style="padding-right: 0;">
     <div class='col-md-12' style="padding:0;"> 
         <h4>{vtranslate('LBL_GOOD_DAY','Home')}, {$DATA['first_name']}..!</h4>
     </div>
        <div class='col-md-12' style="padding:5px 0 ;"> 
            
                <i class='ti ti-id-badge'></i> {$DATA['emp_name']}
            </div>
             <div class='col-md-12' style="padding:5px 0 ;"> 
                 <i class='ti ti-user'></i>  {vtranslate('LBL_WORKING_AS',"Home")}  {$DATA['designation']}
             </div>
             <div class='col-md-12' style="padding:5px 0 ;"> 
                 <i class='ti ti-list-ol'></i> in {$DATA['department']} {vtranslate('LBL_DEPARTMENT', 'Home')}
             </div>
              <div class='col-md-12' style="padding:5px 0 ;"> 
                  <i class='ti ti-briefcase'></i> {vtranslate('LBL_OF_JOB','Home')} {$DATA['job_grade']} 
              </div>
              <div class='col-md-12' style="padding:5px 0 ;"> 
                  <i class='ti ti-user'></i> {vtranslate('LBL_REPORTING_TO','Home')} 
                  <a href='{$URL}/index.php?module=Users&parent=Settings&view=Detail&record={$DATA['report_to']['id']}'>
                      {$DATA['report_to']['name']} 
                  </a>
              </div>
              <div class='col-md-12' style="padding:5px 0 ;"> 
                <i class='ti ti-calendar'></i> {vtranslate('LBL_CONTRACT',$MODULE_NAME)} {$DATA['job_type']} {vtranslate('LBL_SINCE','Home')} {$DATA['contract_start']}
            
           </div>
       <div class='col-md-12' style="padding:5px 0 ;"> 
                <i class='ti ti-calendar'></i> {vtranslate('LBL_CONTRACT_EXPIRE',$MODULE_NAME)}  {$DATA['expire']}
            
           </div>
    </div>
                <div class="col-md-4" style='padding-left: 0;'>
                    <div class="image-holder">
                        <img class="img-thumbnail" src="{$URL}/{$DATA['thumb'][0]['path']}_{$DATA['thumb'][0]['name']}">
                    </div>
                    <div class="clearfix"></div>
                    <a href="{$URL}/index.php?module=Users&parent=Settings&view=Detail&record={$DATA['employee_id']}" class="btn btn-lg btn-block btn-primary"> {vtranslate('LBL_VIEW_PROFILE',$MODULE_NAME)}</a>
                    <a href="{$URL}/index.php?module=EmployeeContract&view=Detail&record={$DATA['contract']}&app=MARKETING" class="btn  btn-lg btn-block btn-white">  {vtranslate('LBL_VIEW_CONTRACT',$MODULE_NAME)} </a>
                    <div class="clearfix"></div>
                    <div class="social text-center" >
                        <a href="{$DATA['facebook']}"><i class="fa fa-facebook"></i></a>
                        <a href="{$DATA['twitter']}"><i class="fa fa-twitter"></i></a>
                        <a href="{$DATA['linkedin']}"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
</div>
                    <div class="clearfix"></div>
                    {if $DATA['notify'] eq 'show'}
                    <small>
                        ** {vtranslate('LBL_CONTRACT_NOTIFICATION','Home')}
                    </small>
                    {/if}
                    
</div>
