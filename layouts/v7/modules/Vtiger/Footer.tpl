{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}

{if !isset($CURRENT_USER_MODEL)} 
<footer class="footer-wrapper">
	<div>
		Agiliux Version 6 &copy; {date('Y')}  Soft Solvers Solutions. All right reserved.
	</div>
	<div>
		<label class="mr-3">Contacts</label>
		<label>Help</label>
	</div>
</footer>
{/if}
<!--
<footer class="app-footer">
	<p>Agiliux Version 6.0 © {date('Y')} 
		<a href="http://www.secondcrm.com/" target="_blank">Soft Solvers Solutions.</a>
 		All rights reserved
	</p>
</footer>-->
</div>
{if isset($CURRENT_USER_MODEL)} 
<footer class=" afterlogin" >
	<div align="center">
		Agiliux Version 6 &copy; {date('Y')}  Soft Solvers Solutions. All right reserved.
	</div>
</footer>
{/if}
<div id='overlayPage'>
	<!-- arrow is added to point arrow to the clicked element (Ex:- TaskManagement), 
	any one can use this by adding "show" class to it -->
	<div class='arrow'></div>
	<div class='data'>
	</div>
</div>

<div id='helpPageOverlay'></div>
<div id="js_strings" class="hide noprint">{Zend_Json::encode($LANGUAGE_STRINGS)}</div>
<div class="modal myModal fade"></div>
{include file='JSResources.tpl'|@vtemplate_path}
</body>

</html>