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
<!DOCTYPE html>
<html>
<head>
	<title>SecondCRM login page</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- for Login page we are added -->
	<link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<link href="libraries/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
	<link href="libraries/bootstrap/css/jqueryBxslider.css" rel="stylesheet" />
	<script src="libraries/jquery/jquery.min.js"></script>
	<script src="libraries/jquery/boxslider/jqueryBxslider.js"></script>
	<script src="libraries/jquery/boxslider/respond.min.js"></script>
	<script>
		jQuery(document).ready(function(){
			scrollx = jQuery(window).outerWidth();
			window.scrollTo(scrollx,0);
			slider = jQuery('.bxslider').bxSlider({
				auto: true,
				pause: 4000,
				randomStart : true,
				autoHover: true
			});

		jQuery('.bx-prev, .bx-next, .bx-pager-item').live('click',function(){ slider.startAuto(); });
	
		jQuery("#forgotPassword a").click(function() {
			jQuery("#loginDiv").hide();
			jQuery("#forgotPasswordDiv").show();
		});
	
		jQuery("#backButton a").click(function() {
			jQuery("#loginDiv").show();
			jQuery("#forgotPasswordDiv").hide();
		});

		jQuery(".changepwd-button a ").click(function() {
			jQuery("#loginDiv").show();
			jQuery("#forgotPasswordDiv").hide();
			jQuery("#changePasswordDiv").hide();
		});
		
		jQuery(".sbutton").click(function(){
			var username = jQuery('#username').val();
			var password = jQuery('#password').val();
				if(username == ''){
					alert('Please enter valid username');
					return false;
				} else if(password ==''){
					alert('Please enter valid password');
					return false;
				}	
				else {
					return true;
				}
		});

		jQuery("input[name='retrievePassword']").click(function(){
			var username = jQuery('#user_name').val();
			var email = jQuery('#emailId').val();
			
			var email1 = email.replace(/^\s+/,'').replace(/\s+$/,'');
			var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
			var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
		
			if(username == ''){
				alert('Please enter valid username');
				return false;
			} else if(!emailFilter.test(email1) || email == ''){
				alert('Please enater valid email address');
				return false;
			} else if(email.match(illegalChars)){
				alert( "The email address contains illegal characters.");
				return false;
			} else {
				return true;
			}
		
		});
	}); 
</script>
</head>
<body>
<div class="container-fluid login-container">
	<!-- Start logo area / welcome message-->
	<div class="row-fluid">
		<div class="span3">
			<div class="logo" id="loginpagelogo">
				<a target="_blank" href="{if $LOGINPAGE['linkurl'] eq ''}https://secondcrm.com{else}{$LOGINPAGE['linkurl']}{/if}">
					<img src="test/loginlogo/{if $LOGINPAGE['logo'] eq ''}second-crm-logo.png{else}{$LOGINPAGE['logo']}{/if}"></a>
			</div>
		</div>
	</div><br />
	<!-- End logo area / welcome message-->
	<div class="row-fluid">
		<div class="span12">
			<div class="content-wrapper">
				<div class="container-fluid">
					<div class="row-fluid">
						<!--Start Twitter/FB widgets--> 
						<div class="span6 loginpagecontainer">
							<div class="carousal-container">
								{if $LOGINPAGE['smicon'] eq 'TW'}
									<!-- 496494730402734081-->
									<div class="twitterfb-wrap">
										<a class="twitter-timeline" height="440" data-widget-id="{if $LOGINPAGE['smdetail'] eq ''}496494730402734081{else}{$LOGINPAGE['smdetail']}{/if}"></a>
									</div>
									{literal}
										<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
									{/literal}
									{else}
									<!--https://www.facebook.com/secondcrm-->
									<div id="fb-root"></div>
									<script>(function(d, s, id) {
									  var js, fjs = d.getElementsByTagName(s)[0];
									  if (d.getElementById(id)) return;
									  js = d.createElement(s); js.id = id;
									  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4";
									  fjs.parentNode.insertBefore(js, fjs);
									}(document, 'script', 'facebook-jssdk'));</script>
									<div class="twitterfb-wrap">
										<div class="fb-page" data-href="{if $LOGINPAGE['smdetail'] eq ''}https://www.facebook.com/secondcrm{else}{$LOGINPAGE['smdetail']}{/if}" data-width="380" data-height="440" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false" data-show-posts="true"><div class="fb-xfbml-parse-ignore"><blockquote cite="{if $LOGINPAGE['smdetail'] eq ''}https://www.facebook.com/secondcrm{else}{$LOGINPAGE['smdetail']}{/if}"><a href="{if $LOGINPAGE['smdetail'] eq ''}https://www.facebook.com/secondcrm{else}{$LOGINPAGE['smdetail']}{/if}">Facebook</a></blockquote></div></div>
									</div>
									{/if}
							</div>
						</div>
						<!--End Twitter/FB widgets--> 
						<div class="span6 loginpagecontainer">
							<div class="login-area"><!--Main Login Window welcome msg-->
						
								<div class="login-box {if $smarty.request.error eq 6}hide{/if}" id="loginDiv">
									<div class="">
										<h3 class="login-header">
											{if $LOGINPAGE['wcmsg'] eq ''}{vtranslate('LBL_WELCOME_SECONDCRM',$MODULE)}{else}{$LOGINPAGE['wcmsg']}{/if}
										</h3>
									</div>
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
                                        {else if $smarty.request.error eq 9}
											<div class="alert alert-error">
												<p>{vtranslate('LBL_BLOCKED_IP',$MODULE)}</p>
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
									<form class="form-horizontal login-form" style="margin:0;" action="index.php?module=Users&action=Login" method="POST">	
									<!-- Added by jitu@secondcrm.com on 24092015 for keep return url-->
										<input type="hidden" name="return_params" value="{$RETURN_PARAMS}" />			<!-- End here -->
											<div class="control-group">
												<label class="control-label" for="username"><b>Username</b></label>
												<div class="controls" id="usernameloginpg" >
													<input id="fieldsize1" type="text" id="username" name="username" placeholder="Username" >
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="password"><b>Password</b></label>
												<div class="controls" id="passwordloginpg" >
													<input id="fieldsize2" type="password" id="password" name="password" placeholder="Password">
												</div>
											</div>
											<div class="control-group signin-button">
													<div class="controls" id="forgotPassword" >
														<button type="submit" class="btn btn-primary sbutton">Sign in</button><br>
														<a>Forgot Password ?</a>
													</div>
											</div>	
										</form>
										<!-- Start Social Media Link -->
										<div class="sc-media">
											<a target="_blank" href="https://plus.google.com/+Secondcrm21909"><img src="layouts/v7/skins/images/googleplus.png"></a>
											<a target="_blank" href="https://www.linkedin.com/company/soft-solvers-solutions">
											<img src="layouts/v7/skins/images/linkedin.png">
											</a>
											<a target="_blank" href="https://twitter.com/secondcrm">
											<img src="layouts/v7/skins/images/twitter.png">
											</a>
											<a target="_blank" href="https://www.facebook.com/secondcrm">
											<img src="layouts/v7/skins/images/facebook.png">
											</a>
										</div>
										<!-- End Social Media Link -->
										<!-- Help/Contact Link-->	
										<br />
										<div class="login-subscript">
											<small style="color:#777;">
												<a target="_blank" href="http://www.secondcrm.com/contact-us">Contact</a>&nbsp;|&nbsp;
												<a target="_blank" href="http://www.secondcrm.com/support">Help</a>
											</small>
										</div>
										<!--End Help/Contact Link-->
									</div>	
									<!-- Start Change Password -->
									

									<div class="login-box {if $smarty.request.error neq 6 || $aUserId eq ' '}hide{/if}" id="changePasswordDiv">	
										<form id="changePassword" class="form-horizontal" action="index.php" method="post" name="changePassword">
										<input type="hidden" value="Users" name="module">							<input type="hidden" value="{$aUserId}" name="userid">	
											<div class="">
												<h3 class="login-header">Change Password</h3>								</div>	
											 {if $smarty.request.error eq 6}				
												<div class="alert alert-error cperr">
													<p>{vtranslate('LBL_PWD_EXPIRE',$MODULE)}</p>
												</div>
											{/if}
											<div class="control-group">
					<label class="control-label" for="username"><b>User name</b></label>
												{$aUserName}
											</div>
											<div class="control-group">
												<label class="control-label" for="newpassword"><b>New Password</b></label>
												<div class="controls">
													<input type="password" id="new_password" name="new_password" placeholder="New Password" data-validation-engine="validate[required]" >
												</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="confirmpassword"><b>Confirm Password</b></label>
												<div class="controls">
													<input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" data-validation-engine="validate[required]">
												</div>
											</div>
											<div class="modal-footer">
												<button class="btn btn-success changepassword" name="changepassword" type="button">
														<strong>Save</strong>
												</button>
											</div>	
										</form>
									</div>
									<!-- End Change Password -->
									<!-- Start Forget Password-->	
									<div class="login-box hide" id="forgotPasswordDiv">
										<form class="form-horizontal login-form" style="margin:0;" action="forgotPassword.php" method="POST">
											<div class="">
												<h3 class="login-header">Forgot Password</h3>
											</div>
											<div class="control-group">
												<label class="control-label" 	for="user_name"><b>User name</b></label>
													<div class="controls">
														<input type="text" id="user_name" name="user_name" placeholder="Username">
													</div>
											</div>
											<div class="control-group">
												<label class="control-label" for="email"><b>Email</b></label>						<div class="controls">
														<input type="text" id="emailId" name="emailId"  placeholder="Email">
													</div>
											</div>
											<div class="control-group signin-button">
												<div class="controls" id="backButton">
													<input type="submit" class="btn btn-primary sbutton" value="Submit" name="retrievePassword">
													&nbsp;&nbsp;&nbsp;<a>Back</a>
												</div>
											</div>
										</form>
									</div>
										<!-- End Forget Password-->
								</div>
							</div>	
						</div>
					</div>
				</div>
			</div>
		</div>			
	</div>
</div><br /><br />
</body>
</html>	
{/strip}