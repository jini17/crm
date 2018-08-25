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
	

	<!--<h1 style="color:red;">Edited</h1>-->
	<div class="container-fluid login-container" style="padding-left: 0px !important;
    padding-right: 0px !important;">
		<!-- Start logo area / welcome message-->
		<div class="row-fluid">
			<div class="span3">
			</div><br />
			<!-- End logo area / welcome message-->
			<div class="row-fluid">
				<div class="span12">
					<div class="content-wrapper">
						<div class="container-fluid">
							<div class="row-fluid">
								<div class="login-wrapper">
									<div class="box-wrapper">
										<div class="login-box-container">
											<div class="left-bar d-none d-md-flex">
												<!-- <img src="/src/images/login-bg-left.png"> -->
												<h5>
													{if $LOGINPAGE['wcmsg'] eq ''}{vtranslate('LBL_WELCOME_SECONDCRM',$MODULE)}{else}{$LOGINPAGE['wcmsg']}{/if}
												</h5>
												<label class="mt-auto">Connect with us</label>
												<!-- Start Social Media Link -->
												<div class="social-wrapper">
													<a class="login-sc-icon" target="_blank" href="https://www.facebook.com/secondcrm"><i class="icon-sc icon-sc-facebook2"></i></a>
													<a class="login-sc-icon" target="_blank" href="https://www.linkedin.com/company/soft-solvers-solutions"><i class="icon-sc icon-sc-linkedin"></i></a>
													<a class="login-sc-icon" target="_blank" href="https://twitter.com/secondcrm"><i class="icon-sc icon-sc-twitter"></i></a>
													<a class="login-sc-icon" target="_blank" href="https://plus.google.com/+Secondcrm21909"><i class="icon-sc icon-sc-google-plus"></i></a>
												</div>
												<!-- End Social Media Link -->
											</div>
											<div class="right-bar">
												<img src="layouts/v7/lib/ui/src/images/agiliux-logo.png">
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
												<span class="{if !$MAIL_STATUS}hide{/if} successMessage">{$MESSAGE}</span>
											</div>
												<div id="loginFormDiv">
													<form class="form-horizontal login-form" style="margin:0;" action="index.php?module=Users&action=Login" method="POST">	
														<!-- Added by jitu@secondcrm.com on 24092015 for keep return url-->
														<input type="hidden" name="return_params" value="{$RETURN_PARAMS}" />			<!-- End here -->
														<div class="control-group">
															<div class="input-group p-3" id="usernameloginpg">
																<input type="text" id="fieldsize1" class="form-control" type="text" id="username" name="username" placeholder="Username" aria-label="Username">
															</div>

															<div class="input-group p-3" id="passwordloginpg">
																<input type="password" id="fieldsize2" class="form-control" type="password" id="password" name="password" placeholder="Password" aria-label="Username">
															</div>
														</div>
														<div class="custom-control custom-checkbox align-self-start ml-3">
															<input type="checkbox" class="custom-control-input" id="customCheck1" style="    height: 0px !important;">
															<label class="custom-control-label" for="customCheck1" id="login-checkbox" >Keep me logged in</label>
														</div>
														<div class="control-group signin-button">
															<div id="forgotPassword" >
																<div class="p-3 align-self-stretch">
																	<button type="submit" class="btn btn-login btn-md btn-block" onclick="myFunction()">Sign in</button>
																</div>
															</div>
														</div>
														<div class="form-check my-1 p-0" style="text-align: center;">
															<a class="forgotPasswordLink pull-right">Forgot password?</a>
														</div>	
													</form>
												</div>
												<div id="forgotPasswordDiv" class="hide">
													<form  action="forgotPassword.php" method="POST" id="forgetform">
														<div class="form-group">
														<label class="sr-only" for="inlineFormInputGroup">Username</label>
														    <input type="text" class="form-control" id="username" placeholder="Username" name="username">
														</div>

														<div class="form-group">
														<label class="sr-only" for="inlineFormInputGroup">Email</label>
														    <input type="email" class="form-control" id="emailId" placeholder="Email" name="emailId">
															</div>
														<div class="text-center">
															<button type="button" class="button buttonPurple forgot-submit-btn">Submit</button></div>
															<a class="purple forgotPasswordLink pull-right">Back</a>
													</form>
												</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>			
			</div>
		</div><br /><br />
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


			var validationMessage = jQuery('#validationMessage');
			var forgotPasswordDiv = jQuery('#forgotPasswordDiv');

				var loginFormDiv = jQuery('#loginFormDiv');
				loginFormDiv.find('#password').focus();

				loginFormDiv.find('a').click(function () { 
					loginFormDiv.toggleClass('hide');
					forgotPasswordDiv.toggleClass('hide');
					validationMessage.addClass('hide');
				});

				forgotPasswordDiv.find('a').click(function () {
					loginFormDiv.toggleClass('hide');
					forgotPasswordDiv.toggleClass('hide');
					validationMessage.addClass('hide');
				});

				loginFormDiv.find('button').on('click', function () {
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

				forgotPasswordDiv.find('button').on('click', function () { 
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