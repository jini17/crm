<style>
	.themecard{
		margin: 15px;
		padding: 10px;
		border: 1px solid black;
		background-color: white;
		border-radius: 5px;
		-webkit-box-shadow: 6px 6px 15px -4px rgba(0,0,0,0.75);
		-moz-box-shadow: 6px 6px 15px -4px rgba(0,0,0,0.75);
		box-shadow: 6px 6px 15px -4px rgba(0,0,0,0.75);
		text-align: center;
		cursor: pointer;
		min-height: 460px;
		height: auto !important;
	}
	
	.mycthemeswitchercnt{
		background-color: white;
		border: 3px dashed lightgray;
		width:90%;
		margin:auto;
		margin-top:20px;
		margin-bottom:20px;
		padding-bottom:20px;
	}

	
	.themescontainer{
		width: 100%;
		padding-bottom: 20px;
	}
	
	.themescontainer .span4{
		width: 30%;
		margin-left: 3%;
	}
	@media (max-width: 800px) {
	.themescontainer .span4{
		width: 100%;
	}
}
	.themethumbs{
		width: 100%;
		height: auto;
	}
	
	.globalapplytooltip{
		padding: 5px;
	    padding-bottom: 0px;
	    padding-top: 0px;
	    border-radius: 40%;
	    background-color: rgba(0,0,0,0.3);
	    font-size: smaller;
	}
	
	.licensebox{
		background-color: #5bb75b;
		border-radius: 5px;
		padding: 5px;
		color: white !important;
	}
	
	.myclogo{
		max-width: 80px;
		height: auto;
		float: left;
		margin-right:5px;
	}
	.myctsheader{
		padding-top: 10px;    height: 80px;
	}
	.myctsheader h1{
		line-height: 40px;
	}
</style>


<div class="mycthemeswitchercnt" >
		<div class="myctsheader">
			<img class="myclogo" src="layouts/vlayout/modules/MYCThemeSwitcher/images/MYCThemeSwitcher.png">
			<h1 class="">MYC Theme Switcher</h1>
			<small>{'LBL_WELCOME'|vtranslate:$MODULE}</small>
		<hr>
	</div>
			
			
			<br>
			<div class="container themescontainer">
			{if $ZIP_CHECK eq false}
				<div class="alert alert-danger"><b>PHP-ZIP EXTENSION NOT FOUND!</b><br> The <b>php-zip</b> extension is <b>not loaded</b> on this server, please setup and load it to use the MYC Theme Switcher module, after you installed and loaded correctly the php-zip extension this error will disappear, you need then to disable and enable again the MYC Theme Switcher module from the Module Manager to complete the setup! </div>
			{/if}
			
			{if $MCRYPT_CHECK eq false}
				<div class="alert alert-danger"><b>PHP-MCRYPT EXTENSION NOT FOUND!</b><br> The <b>php-mcrypt</b> extension is <b>not loaded</b> on this server, please setup and load it to use the MYC Theme Switcher module, after you installed and loaded correctly the php-mcrypt extension this error will disappear, you need then to disable and enable again the MYC Theme Switcher module from the Module Manager to complete the setup! </div>
			{/if}
			
			{if $PERMISSIONS_CHECK_ERROR}
				<div class="alert alert-danger"><b>CHECK FOR FILES AND FOLDERS PERMISSIONS!</b><br> The following Files/Folder are not writeable by the php user, please check it and follow the instructions above to fix this problem:<br>
				{foreach key=FILENAME item=ERROR from=$PERMISSIONS_CHECK}
				<br>
				<b>- {$FILENAME} : </b> {$ERROR} 
				<br>
				{/foreach}
				 </div>
			{/if}
			
			{if $ZIP_CHECK eq false || $MCRYPT_CHECK eq false || $PERMISSIONS_CHECK_ERROR}
			<a class="btn btn-warning btn-lg" href="index.php?module=MYCThemeSwitcher&view=List&mode=check">Check Again</a>
			{else}
			<div class="alert alert-success"><b>ALL THE CHECK PASSEDD!</b><br> All the check are successfully passed, you are ready now to complete the setup! </div>
			<a class="btn btn-success btn-lg" href="index.php?module=MYCThemeSwitcher&view=List&mode=finalize">Complete Setup</a>
			{/if}
			
			
</div>
