{*+**********************************************************************************
* The contents of this file are subject to the vtiger CRM Public License Version 1.1
* ("License"); You may not use this file except in compliance with the License
* The Original Code is: vtiger CRM Open Source
* The Initial Developer of the Original Code is vtiger.
* Portions created by vtiger are Copyright (C) vtiger.
* All Rights Reserved.
************************************************************************************}


</div>
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

<script src="https://unpkg.com/tippy.js@2.5.4/dist/tippy.all.min.js"></script>


<script>
	tippy('[tippytitle]',{
	  placement: 'top',
	  animation: 'shift-toward',
	  inertia: true,
	  duration: 600,
	  arrow: true,
	  arrowtype: "round",
	  arrowtransform: "scale(0.7, 1)",	  
	  theme: "fask"
	});
	/*
	$(function(){
		var prevLeft = 0;
		var prevTop = 0;
		
		var scrollingVert = false;
		var scrollingHor = false;
		    
		$(".main-container *").scroll( function(evt) {
			return true;
			clearTimeout($.data(this, 'scrollTimer'));
		    $.data(this, 'scrollTimer', setTimeout(function() {
		        scrollingVert = false;
		        scrollingHor = false;
		        $(".main-container *").removeClass("stop-hor-scrol");
		        $(".main-container *").removeClass("stop-ver-scrol");	
		    }, 1000));
		    
		    var currentLeft = $(this).scrollLeft();
		    var currentTop = $(this).scrollTop();
		    
		    if(prevLeft != currentLeft) {
			    $(".main-container *").addClass("stop-ver-scrol");	
		        prevLeft = currentLeft;
		        console.log("I scrolled horizontally.");
		    }
		    
		    if(prevTop !== currentTop) {	
			    $(".main-container *").addClass("stop-hor-scrol");		    
		        prevTop = currentTop;
		        scrollingVert = true;
		        console.log("I scrolled vertically.");
		    }
		    
		    
		    
		});
	})
	*/
</script>
</body>
</html>