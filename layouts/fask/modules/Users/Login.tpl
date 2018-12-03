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
{strip}
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- for Login page we are added -->
<link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<link href="libraries/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="libraries/bootstrap/css/jqueryBxslider.css" rel="stylesheet" />
<!--UI team-->
<link rel="stylesheet" type="text/css" href="layouts/v7/lib/ui/css/bootstrap.css" crossorigin="anonymous">
<!-- Custom icon -->
<link rel="stylesheet" type="text/css" href="layouts/v7/lib/ui/css/social-med.css" crossorigin="anonymous">
<!-- custom-style -->
<link rel="stylesheet" type="text/css" href="layouts/v7/lib/ui/css/styles.css" crossorigin="anonymous">
<!--UI team-end-->
<script src="libraries/jquery/jquery.min.js"></script>
<script src="libraries/jquery/boxslider/jqueryBxslider.js"></script>
<script src="libraries/jquery/boxslider/respond.min.js"></script>
<style>
   .failureMessage {
   color: red;
   display: block;
   text-align: center;
   padding: 0px 0px 10px;
   }
   .successMessage {
   color: green;
   display: block;
   text-align: center;
   padding: 0px 0px 10px;
   }
   .alert, .alert-error{
   position: relative !important;
   padding: 2px !important;
   margin-bottom: 0px !important;
   border: 1px solid transparent !important;
   }
   #multilogin {
    display: block; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 999; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}
.modal-box-modal-dialog{
    width: 30%;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    
}
.modal-box-header h4{
    font-size: 15px;
}
.modal-box-body h5{
    font-size: 13px;
}
.modal-box-body {
    font-size: 12px;
}
</style>
<div style="    background-color: #fff;
   display: block;
   margin: 0 auto;
   text-align: center;
   position: fixed;
   top: 0;
   width: 100%;
   z-index: 100;    left: 0;">
   {if $LOGINPAGE['logo'] eq '' || !file_exists("test/loginlogo/{$LOGINPAGE['logo']}")}
   <img src="layouts/v7/lib/ui/src/images/agiliux-logo.png" style="width: 120px;height: auto;margin: 15px 0px;">
   {else}
   <img src="test/loginlogo/{$LOGINPAGE['logo']}" class="loginlogo" width="150" height="150" style="width: 120px;height: auto;margin: 15px 0px;">
   {/if} 
</div>
<!--<h1 style="color:red;">Edited</h1>-->
<div class="container-fluid login-container" style="padding-left: 0px !important;
   padding-right: 0px !important;">
<!-- Start logo area / welcome message-->
<div class="row-fluid">
   <div class="span3">
   </div>
   <br />
   <!-- End logo area / welcome message-->
   <div class="row-fluid">
      <div class="span12">
         <div class="content-wrapper">
            <div class="container-fluid">
               <div class="row-fluid">
                  <div class="login-wrapper">
                     <div class="box-wrapper">
                        <div class="login-box-container">
                           <div class="right-bar">
                               {if $smarty.get.parallel_logout eq "logout" }
                                     <div id="multilogin" class="modal-box">
                                    <div class="modal-box-modal-dialog">
                                      <!-- Modal content-->
                                      <div class="modal-box-content">
                                        <div class="modal-box-header">
                                            <h4><i class="fa fa-power-off"></i> Previous login session auto logout.</h4>
                                            <button type="button" class="close" data-dismiss="modal" style="margin-top: -29px;">&times;</button>

                                        </div>
                                        <div class="modal-box-body">
                                            <h5>Additional information:</h5>
                                            <ul style="margin-left: 20px;">           
                                                <li> You may receive this message if there are currently multiple sessions logged in with this username & password. </li>
                                                <li> Someone has logged in as this user from a different computer or browser window. Only one user session is allowed.</li>
                                                <li> As a consequence, the other session has been terminated.</li>
                                            </ul>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                     {/if}
                              <span class="login-page-title">
                              {if $LOGINPAGE['wcmsg'] eq ''}{vtranslate('LBL_WELCOME_SECONDCRM',$MODULE)}{else}{$LOGINPAGE['wcmsg']}{/if}
                              </span>
                              <div class="alert alert-success hide"></div>
                              {if isset($smarty.request.error)}
                              {if $smarty.request.error eq 1}
                              <div class="alert alert-error">
                                 <p>{vtranslate('LBL_INVALID_USER_OR_PASSWORD',$MODULE)}</p>
                              </div>
                              {else if $smarty.request.error eq 2}
                              <div class="alert alert-error">
                                 <p>{vtranslate('LBL_SUBSCRIPTION_OUTDATE', $MODULE)}</p>
                              </div>
                              {else if $smarty.request.error eq 3 || $smarty.request.error eq 4}
                              <div class="alert alert-error">
                                 <p>{vtranslate('LBL_NO_SUBSCRIPTION', $MODULE)}</p>
                              </div>
                              {else if $smarty.request.error eq 5}              
                              <div class="alert alert-error">
                                 <p>{vtranslate('LBL_MANY_ATTEMPTS',$MODULE)}</p>
                              </div>
                              {else if $smarty.request.error eq 7}              
                              <div class="alert alert-error">
                                 <p>{vtranslate('LBL_SESSION_EXPIRED',$MODULE)}</p>
                              </div>
                              {/if}
                              {/if}
                              {if isset($smarty.request.fpError)}
                              <div class="alert alert-error">
                                 <p>Invalid Username or Email address.</p>
                              </div>
                              {/if}
                              {if isset($smarty.request.status)}
                              <div class="alert alert-success">
                                 <p>Mail was send to your inbox, please check your e-mail.</p>
                              </div>
                              {/if}
                              {if isset($smarty.request.statusError)}
                              <div class="alert alert-error">
                                 <p>Outgoing mail server was not configured.</p>
                              </div>
                              {/if}
                              <div>
                                 <span class="{if !$ERROR}hide{/if} failureMessage" id="validationMessage">{$MESSAGE}</span>
                                 <span class="success {if !$MAIL_STATUS}hide{/if} successMessage">{$MESSAGE}</span>
                              </div>
                              <div id="loginFormDiv">
                                 <form class="form-horizontal login-form" style="margin:0;" action="index.php?module=Users&action=Login" method="POST">
                                    <!-- Added by jitu@secondcrm.com on 24092015 for keep return url-->
                                    <input type="hidden" name="return_params" value="{$RETURN_PARAMS}" />           <!-- End here -->
                                    <div class="control-group">
                                       <div class="input-group p-3" id="usernameloginpg">
                                          <input type="text" id="fieldsize1" class="form-control" type="text" id="username" name="username" placeholder="Username" aria-label="Username" value="{$LOGINDETAILS.user}">
                                       </div>
                                       <div class="input-group p-3" id="passwordloginpg">
                                          <input type="password" id="fieldsize2" class="form-control" type="password" id="password" name="password" placeholder="Password" aria-label="Username" value="{$LOGINDETAILS.pass}">
                                       </div>
                                    </div>
                                    <div class="custom-control custom-checkbox align-self-start ml-3">
                                       <input type="checkbox" class="custom-control-input" id="customCheck1" name="keepcheck" style="height: 0px !important;" 
                                       {if $LOGINDETAILS.keepcheck eq 1} checked {/if}>
                                       <label class="custom-control-label" for="customCheck1" id="login-checkbox" >Keep me logged in</label>
                                    </div>
                                    <div class="control-group signin-button">
                                       <div id="forgotPassword" >
                                          <div class="p-3 align-self-stretch">
                                             <button type="submit" class="btn btn-login btn-md btn-block" onclick="myFunction()">Sign in</button>
                                          </div>
                                       </div>
                                    </div>
                                 </form>
                                    <!--<div class="sc-media">
                                       added by jitu@Demo for different edition -
                                       <div class="col-sm-9" style="display:inline;">
                                              <div class="col-sm-3" style="padding:0;">
                                                      <input type="radio" name="demotype" class="demotype" value="Sales" {if $EDITION eq 'Sales'}checked{/if} style="width:25%;">Foundation
                                              </div>
                                       
                                              <div class="col-sm-3" style="padding:0;">
                                                      <input value="Support" {if $EDITION eq 'Support'}checked{/if} class="demotype" name="demotype" type="radio" style="width:25%;">Sales
                                              </div>
                                       
                                              <div class="col-sm-3" style="padding:0;">
                                                      <input type="radio" name="demotype" class="demotype" value="Enterprise" {if $EDITION eq 'Enterprise'} checked{/if} style="width:25%;">Service
                                              </div>
                                       </div>
                                       end here -->
                                     <div class="form-check">
                                         <a class="forgotPasswordLink pull-right">Forgot password?</a>
                                     </div>
                              </div>

                               <div id="forgotPasswordDiv" class="hide">
                                   <form  action="forgotPassword.php" method="POST" id="forgetform">
                                       <div class="control-group">
                                           <label class="sr-only" for="inlineFormInputGroup">Username</label>
                                           <input type="text" class="input-group p-3" id="username" placeholder="Username" name="username">
                                       </div>
                                       <div class="control-group">
                                           <label class="sr-only" for="inlineFormInputGroup">Email</label>
                                           <input type="email" class="input-group p-3" id="emailId" placeholder="Email" name="emailId">
                                       </div>
                                       <div class="control-group ">
                                           <button type="button" class="button btn btn-primary forgot-submit-btn">Submit</button>
                                       </div>
                                       <a class="purple forgotPasswordLink pull-right">Back</a>
                                   </form>
                               </div>
                            
                              <div id="social">
  <div id="container">
     <label class="SocialMedLabel">Connect with us</label>
     <ul style="margin: 0;">
        <li>
           <a class="socialiconnew" href="https://www.facebook.com/secondcrm" title="facebook" target="_blank">
              <i class="icon-sc icon-sc-facebook2"></i>
           </a>
        </li>

        <li>
           <a class="socialiconnew" href="https://www.linkedin.com/company/soft-solvers-solutions" title="linkedin" target="_blank">
              <i class="icon-sc icon-sc-linkedin"></i>
           </a>
        </li>

        <li>
           <a class="socialiconnew" href="https://twitter.com/secondcrm" title="twitter" target="_blank">
              <i class="icon-sc icon-sc-twitter"></i>
           </a>
        </li>

        <li>
           <a class="socialiconnew" href="https://plus.google.com/+Secondcrm21909" title="instagram" target="_blank">
              <i class="icon-sc icon-sc-google-plus"></i>
           </a>
        </li>
     </ul>
  </div>
</div>
                                    
                                       <!-- Start Social Media Link --> 
                                    </div>   

                           </div>

                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<br /><br />
<script>
   jQuery(document).ready(function(){
jQuery("button.close").on("click",function(){
    jQuery("#multilogin").addClass("hide")
});
       var validationMessage = jQuery('#validationMessage');
       var forgotPasswordDiv = jQuery('#forgotPasswordDiv');
   
       var loginFormDiv = jQuery('#loginFormDiv');
       loginFormDiv.find('#password').focus();

       loginFormDiv.on('click','.forgotPasswordLink',function () {
           loginFormDiv.toggleClass('hide');
           forgotPasswordDiv.toggleClass('hide');
           validationMessage.addClass('hide');
       });

       forgotPasswordDiv.on('click','.forgotPasswordLink',function () {
           loginFormDiv.toggleClass('hide');
           forgotPasswordDiv.toggleClass('hide');
           validationMessage.addClass('hide');
       });

       loginFormDiv.on('click','button', function () {
           var username = loginFormDiv.find('#username').val();
           var password = jQuery('#password').val();
           var result = true;
           var errorMessage = '';
           if (username === '') {
               errorMessage = 'Please enter valid username';
               result = false;
           } else if (password === '') {
               errorMessage = 'Please enter valid password';
               result = false;
           }
           if (errorMessage) {
               validationMessage.removeClass('hide').text(errorMessage);
           }
           return result;
       });

       forgotPasswordDiv.on('click','.forgot-submit-btn', function () {
           var username = jQuery('#forgotPasswordDiv #username').val();
           var email = jQuery('#emailId').val();

           var email1 = email.replace(/^\s+/, '').replace(/\s+$/, '');
           var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
           var illegalChars = /[\(\)\<\>\,\;\:\\\"\[\]]/;

           var result = true;
           var errorMessage = '';
           if (username === '') {
               errorMessage = 'Please enter valid username';
               result = false;
           } else if (!emailFilter.test(email1) || email == '') {
               errorMessage = 'Please enter valid email address';
               result = false;
           } else if (email.match(illegalChars)) {
               errorMessage = 'The email address contains illegal characters.';
               result = false;
           }
           if (errorMessage) {
               validationMessage.removeClass('hide').text(errorMessage);
           } else {
               jQuery('form#forgetform').submit();
           }
           return result;
       });

       jQuery('input').blur(function (e) {
           var currentElement = jQuery(e.currentTarget);
           if (currentElement.val()) {
               currentElement.addClass('used');
           } else {
               currentElement.removeClass('used');
           }
       });
       loginFormDiv.find('#username').focus();
   });
</script>
{/strip}