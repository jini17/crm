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
 <div class="educationModalContainer modal-dialog modal-xs modelContainer">
        {if $EDU_ID neq ''}
                {assign var="HEADER_TITLE" value={vtranslate('LBL_EDIT_EDUCATION', $QUALIFIED_MODULE)}}
        {else} 
                 {assign var="HEADER_TITLE" value={vtranslate('LBL_ADD_NEW_EDUCATION', $QUALIFIED_MODULE)}}
        {/if}
        {include file="ModalHeader.tpl"|vtemplate_path:$MODULE TITLE=$HEADER_TITLE}

        <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

                <form id="editEducation" class="form-horizontal" method="POST">
                        <input type="hidden" name="record" value="{$EDU_ID}" />
                        <!--<input type="hidden" value="Users" name="module">
                        <input type="hidden" value="SaveSubModuleAjax" name="action">
                        <input type="hidden" value="saveEducation" name="mode">-->
                        <input id="current_user_id" name="current_user_id" type="hidden" value="{$USERID}">
                        <div class="modal-body">
                                <!--start-->
                                <div class="row-fluid">
                        <div class="form-group" style="margin-bottom: 0px !important;">
                                <div class="col-md-12" style="margin-bottom: 15px;">
                                        <div class="col-md-4">
                                                                <label class="control-label fieldLabel" style="text-align: right;float: right;">
                                                                        &nbsp;{vtranslate('LBL_INSTITUTION_NAME', $QUALIFIED_MODULE)} <span class="redColor">*</span>
                                                                </label>
                                                        </div>
                                                        <div class="controls fieldValue col-md-8">
                                                                <select class="select2 inputElement" onchange="updateSelectBox('institution_name','institution_nametxt');" name="institution_name" id="institution_name" data-rule-required = "true">
                                                                {foreach key=INSTITUTION_ID item=INSTITUTION_MODEL from=$INSTITUTION_LIST name=institutionIterator}
                                                                <option value="{$INSTITUTION_MODEL.institution}" {if $EDUCATION_DETAIL.institution_name eq $INSTITUTION_MODEL.institution} selected {/if}>
                                                                ({$INSTITUTION_MODEL.institution})</option>
                                                                {/foreach}
                                                                <option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option> 	
                                                                <option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
                                                                </select>
                                                        </div>
                                                </div>

                                                <div class="col-md-12" style="margin-bottom: 15px;">
                                                        <div class="col-md-4">
                                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;"></label>
                                                        </div>

                                                        <div class="controls fieldValue col-md-8" align="right">
                                                                <span class="hide" id="institution_nametxt">
                                                                        <input class="inputElement" type="text" name="institutiontxt" id="institutiontxt" data-rule-required = "true" />
                                                                </span>
                                                        </div>
                                                </div>
                                        </div>
                                        <div class="form-group">
                                                <div class="col-md-12" style="margin-bottom: 15px;">
                                                        <div class="col-md-4">
                                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">{vtranslate('LBL_LOCATION',$QUALIFIED_MODULE)}</label>
                                                        </div>

                                                        <div class="controls fieldValue col-md-8" align="right">
                                                                <span d="location_nametxt">
                                                                        <input class="inputElement" type="text" place="Enter Street,City,Country" name="location" id="country" data-rule-required = "true" />
                                                                </span>
                                                              <div class="form-group">
                                                            <div class="col-md-12" style="margin-bottom:15px">
                                                                <div class="col-md-4">
                                                                    <label class="conrol-label fieldLabel" style="text-align:right; float:right;">&nbsp;{vtranslate('LBL_LOCATION',$QUALIFIED_MODULE)}</label>
                                                                </div>
                                                                <div class="controls col-md-8">
                                                                   <div class="pac-card" id="pac-card">
                                                                          
                                                                            <div id="pac-container">
                                                                              <input id="pac-input" type="text"
                                                                                  placeholder="Enter a location">
                                                                            </div>
                                                                          </div>
                                                                          <div id="map"></div>
                                                                          <div id="infowindow-content">
                                                                            <img src="" width="16" height="16" id="place-icon">
                                                                            <span id="place-name"  class="title"></span><br>
                                                                            <span id="place-address"></span>
                                                                          </div>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        </div>
                                                </div>
                                        </div>                          
                        <!--end-->
                                <div class="form-group" style="margin-bottom: 0px !important; position: relative;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_START_DATE', $QUALIFIED_MODULE)}<span class="redColor">*</span></label>
                                                </div>
                                                <div class="controls date col-md-8">
                                                        <input id="start_date" type="text" class="dateField inputElement" type="text" value="{$EDUCATION_DETAIL.start_date}" data-rule-required = "true" name="start_date" data-date-format="dd-mm-yyyy">	
                                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>		
                                                </div>
                                        </div>
                                </div>
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_CURRENTLY_STUDYING', $QUALIFIED_MODULE)}</label>
                                                </div>
                                                <div class="controls col-md-8">
                                                        <input type="checkbox" class="currentstudying inputElement" name="chkstudying" id="chkstudying" {if $EDUCATION_DETAIL.currently_studying eq 1} checked {/if}>
                                                </div>
                                        </div>
                                </div>	
                                <div class="form-group {if $EDUCATION_DETAIL.currently_studying eq 1} hide{/if}" id="enddate_div" style="margin-bottom: 0px !important; position:relative;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_END_DATE', $QUALIFIED_MODULE)}</label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                        <input id="end_date" type="text" class="dateField inputElement" type="text" value="{if $EDUCATION_DETAIL.end_date neq '00-00-0000'}{$EDUCATION_DETAIL.end_date}{/if}" data-rule-required = "true"  name="end_date" data-date-format="dd-mm-yyyy" >	
                                                        <span class="add-on">&nbsp;<i class="icon-calendar"></i></span>	
                                                </div>
                                        </div>
                                </div>	
                                          
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_EDUCATION_LEVEL', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                    <select class="select2 inputElement" name="education_level" id="education_level" data-rule-required = "true" style="width:100%;">
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_ASSOCIATE_DEGREE', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_ASSOCIATE_DEGREE', $QUALIFIED_MODULE)}">{vtranslate('LBL_ASSOCIATE_DEGREE', $QUALIFIED_MODULE)}</option>
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_BACHELOR_DEGREE', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_BACHELOR_DEGREE', $QUALIFIED_MODULE)}">{vtranslate('LBL_BACHELOR_DEGREE', $QUALIFIED_MODULE)}</option>
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_MASTER', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_MASTER', $QUALIFIED_MODULE)}">{vtranslate('LBL_MASTER', $QUALIFIED_MODULE)}</option>
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_MBA', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_MBA', $QUALIFIED_MODULE)}">{vtranslate('LBL_MBA', $QUALIFIED_MODULE)}</option>
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_JURIS', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_JURIS', $QUALIFIED_MODULE)}">{vtranslate('LBL_JURIS', $QUALIFIED_MODULE)}</option>
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_MD', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_MD', $QUALIFIED_MODULE)}">{vtranslate('LBL_MD', $QUALIFIED_MODULE)}</option>
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_PHD', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_PHD', $QUALIFIED_MODULE)}">{vtranslate('LBL_PHD', $QUALIFIED_MODULE)}</option> 	
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('LBL_ENG', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('LBL_ENG', $QUALIFIED_MODULE)}">{vtranslate('LBL_ENG', $QUALIFIED_MODULE)}</option> 	
                                                                <option {if $EDUCATION_DETAIL.education_level eq {vtranslate('OTHERS', $QUALIFIED_MODULE)}} selected {/if} value="{vtranslate('OTHERS', $QUALIFIED_MODULE)}">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 	
                                                        </select>
                                                </div>		
                                        </div>
                                </div>		 	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_AREA_OF_STUDY', $QUALIFIED_MODULE)} <span class="redColor">*</span></label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                        <select class="select2 inputElement" onchange="updateSelectBox('areaofstudy','areaofstudytxt');" name="areaofstudy" 	id ="areaofstudy" data-rule-required = "true">	
                                                                {foreach key=MAJOR_ID item=MAJOR_MODEL from=$MAJOR_LIST name=majorIterator}
                                                                <option value="{$MAJOR_MODEL.major}" {if $EDUCATION_DETAIL.areaofstudy eq $MAJOR_MODEL.major} selected {/if}>
                                                                ({$MAJOR_MODEL.major})</option>
                                                                {/foreach}
                                                                <option value="">{vtranslate('LBL_SELECT', $QUALIFIED_MODULE)}</option> 	
                                                                <option value="0">{vtranslate('OTHERS', $QUALIFIED_MODULE)}</option> 
                                                        </select>	
                                                </div>
                                        </div>
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;"></label>
                                                </div>
                                                <div class="controls fieldValue col-md-8" align="right">
                                                        <span class="hide" id="areaofstudytxt">
                                                            <input class="inputElement" type="text" name="majortxt" id="majortxt" data-rule-required = "true"/>
                                                        </span>
                                                </div>
                                        </div>		
                                </div>
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_DESCRIPTION', $QUALIFIED_MODULE)}</label>
                                                </div>			
                                                <div class="controls date col-md-8">
                                                        <textarea style="width:350px!important" name="description" id="description" class="span11" maxlength="300" data-rule-required = "true" >{$EDUCATION_DETAIL.description}</textarea>	
                                                </div>
                                        </div>	
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float:right;">&nbsp;</label>
                                                </div>	
                                                <div class="controls" id="charNum" style="font-size:12px;text-align: right;float:right;margin-right: 13px;">{vtranslate('LBL_MAX_CHAR_TXTAREA', $QUALIFIED_MODULE)}</div>
                                        </div>
                                </div>	
                                <div class="form-group" style="margin-bottom: 0px !important;">
                                        <div class="col-md-12" style="margin-bottom: 15px;">
                                                <div class="col-md-4">
                                                        <label class="control-label fieldLabel" style="text-align: right;float: right;">&nbsp;{vtranslate('LBL_WANT_TO_MAKE_PUBLIC', $QUALIFIED_MODULE)}</label>
                                                </div>	
                                                <div class="controls date col-md-8">
                                                      <label><input type="radio" {if $EDUCATION_DETAIL.public eq '0'} checked {/if} id="chkviewable" name='chkviewable' value="0" />&nbsp; {vtranslate('LBL_PUBLIC', $QUALIFIED_MODULE)} </label>&nbsp; 
                                                     <label><input type="radio"{if $EDUCATION_DETAIL.public eq '1'} checked {/if} id="chkviewable"  name='chkviewable' value="1" />&nbsp; {vtranslate('LBL_PRIVATE', $QUALIFIED_MODULE)} </label>&nbsp; 
                                                      <label><input type="radio" {if $EDUCATION_DETAIL.public eq '2'} checked {/if} name='chkviewable' value="2" />&nbsp; {vtranslate('LBL_PROTECTED', $QUALIFIED_MODULE)} </label>
{*                                                        <input class="inputElement" type="checkbox" name="chkviewable" id="chkviewable" {if $EDUCATION_DETAIL.public eq 1} checked {/if}>
*}                                                </div>	
                                        </div>
                                </div>
                        </div>
                        <div class="modal-footer" style="padding-top: 5px; padding-bottom: 5px;">
                                 {include file='ModalFooter.tpl'|@vtemplate_path:'Vtiger'}
                        </div>    	 	
                </form>
        </div>
</div>
{/strip}
{literal}
<script>


function updateBox(selectbox, txtbox){

        var selectboxid = "#"+selectbox;

        $(selectboxid).select2("data", {id: "0", text: "Others"}); 
        $(selectboxid).select2("close");

        var selectobj = document.getElementById(selectbox);
        var txtobj    = document.getElementById(txtbox);

        txtobj.className = '';
}

function updateSelectBox(selectbox, txtbox)
{
//alert(JSON.stringify(selectbox));
        var selectobj = document.getElementById(selectbox);

        var txtobj    = document.getElementById(txtbox);

        if(selectobj==null || selectobj==undefined || selectobj.value=='0') {
                if(txtbox == 'institution_nametxt' || txtbox == 'areaofstudytxt') {
                        txtobj.className = '';
                } 
        } else if(selectobj.value!=null) {
                        txtobj.className = 'hide';
        }
}
</script>


<!--*Google MAP - Khaled*} 
              <div class="form-group">
                                                            <div class="col-md-12" style="margin-bottom:15px">
                                                                <div class="col-md-4">
                                                                    <label class="conrol-label fieldLabel" style="text-align:right; float:right;">&nbsp;{vtranslate('LBL_LOCATION',$QUALIFIED_MODULE)}</label>
                                                                </div>
                                                                <div class="controls col-md-8">
                                                                   <div class="pac-card" id="pac-card">
                                                                          
                                                                            <div id="pac-container">
                                                                              <input id="pac-input" type="text"
                                                                                  placeholder="Enter a location">
                                                                            </div>
                                                                          </div>
                                                                          <div id="map"></div>
                                                                          <div id="infowindow-content">
                                                                            <img src="" width="16" height="16" id="place-icon">
                                                                            <span id="place-name"  class="title"></span><br>
                                                                            <span id="place-address"></span>
                                                                          </div>

                                                                </div>
                                                            </div>
                                                        </div>
-->
<script>
    
function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: -33.8688, lng: 151.2195},
          zoom: 13
        });
        var card = document.getElementById('pac-card');
        var input = document.getElementById('pac-input');
        var types = document.getElementById('type-selector');
        var strictBounds = document.getElementById('strict-bounds-selector');

        map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

        var autocomplete = new google.maps.places.Autocomplete(input);

        // Bind the map's bounds (viewport) property to the autocomplete object,
        // so that the autocomplete requests use the current map bounds for the
        // bounds option in the request.
        autocomplete.bindTo('bounds', map);

        // Set the data fields to return when the user selects a place.
        autocomplete.setFields(
            ['address_components', 'geometry', 'icon', 'name']);

        var infowindow = new google.maps.InfoWindow();
        var infowindowContent = document.getElementById('infowindow-content');
        infowindow.setContent(infowindowContent);
        var marker = new google.maps.Marker({
          map: map,
          anchorPoint: new google.maps.Point(0, -29)
        });

        autocomplete.addListener('place_changed', function() {
          infowindow.close();
          marker.setVisible(false);
          var place = autocomplete.getPlace();
          if (!place.geometry) {
            // User entered the name of a Place that was not suggested and
            // pressed the Enter key, or the Place Details request failed.
            window.alert("No details available for input: '" + place.name + "'");
            return;
          }

          // If the place has a geometry, then present it on a map.
          if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
          } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);  // Why 17? Because it looks good.
          }
          marker.setPosition(place.geometry.location);
          marker.setVisible(true);

          var address = '';
          if (place.address_components) {
            address = [
              (place.address_components[0] && place.address_components[0].short_name || ''),
              (place.address_components[1] && place.address_components[1].short_name || ''),
              (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
          }

          infowindowContent.children['place-icon'].src = place.icon;
          infowindowContent.children['place-name'].textContent = place.name;
          infowindowContent.children['place-address'].textContent = address;
          infowindow.open(map, marker);
        });

        // Sets a listener on a radio button to change the filter type on Places
        // Autocomplete.
        function setupClickListener(id, types) {
          var radioButton = document.getElementById(id);
          radioButton.addEventListener('click', function() {
            autocomplete.setTypes(types);
          });
        }

        setupClickListener('changetype-all', []);
        setupClickListener('changetype-address', ['address']);
        setupClickListener('changetype-establishment', ['establishment']);
        setupClickListener('changetype-geocode', ['geocode']);

        document.getElementById('use-strict-bounds')
            .addEventListener('click', function() {
              console.log('Checkbox clicked! New state=' + this.checked);
              autocomplete.setOptions({strictBounds: this.checked});
            });
      }
</script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDLL0rHGj4iF_ubU-M47QxkyRY-KbwEtIY&libraries=places&callback=initMap"
        async defer></script>



{/literal}