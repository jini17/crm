/*+***********************************************************************************
 * This file was created by Nirbhay Shah on 16/01/2018
 * This file was created mainly for Google-API-Integration Changes
 * All Rights Reserved.
 *************************************************************************************/
var placeSearch, autocompletepikcup,autocompletedispatch;
        var componentForm = {
       
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name'
        };

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    //console.log("Initializing Google Maps");
    //var myform = jQuery('input[name=lastname]').get(0).form;
    ///var formname = jQuery(myform).attr('name');
    //alert(formname);
   
    autocompletepikcup = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('Contacts_editView_fieldName_mailingcity')),
           { types: ['(cities)'] });
            //console.log("After Autocomplete Pickup Assignment");

               autocompletedispatch = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('Contacts_editView_fieldName_othercity')),
            { types: ['(cities)'] });
           //{types: ['geocode']});
            //console.log("After Autocomplete Dispatch Assignment");

        console.log(autocompletepikcup);
        console.log(autocompletedispatch);
    
    
        // When the user selects an address from the dropdown, populate the address
        // fields in the form.
            autocompletepikcup.addListener('place_changed', fillInAddresspickup);
             autocompletedispatch.addListener('place_changed', fillInAddressdispatch);
}

function fillInAddresspickup() {
    // Get the place details from the autocomplete object.
    var place = autocompletepikcup.getPlace();

    /* for (var component in componentForm) {
         document.getElementById(component).value = '';
         document.getElementById(component).disabled = false;
     }*/
    console.log(place);
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.

    for (var i = 0; i < place.address_components.length; i++) {
        ///alert('Nirbhjay');
        var addressType = place.address_components[i].types[0];
        /************* State ***************************/
        if (addressType == 'administrative_area_level_1') {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById('Contacts_editView_fieldName_mailingstate').value = val;
        }
        /************* Country ***************************/
        if (addressType == 'country') {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById('Contacts_editView_fieldName_mailingcountry').value = val;
        }
        /*********** City**************/
        if(addressType == 'locality'){
             var val = place.address_components[i][componentForm[addressType]];
            console.log(place.address_components);
        
            document.getElementById('Contacts_editView_fieldName_mailingcity').value = val;
        }
    }
}

function fillInAddressdispatch() {
    // Get the place details from the autocomplete object.
    var place = autocompletedispatch.getPlace();
    console.log(place);
    /* for (var component in componentForm) {
         document.getElementById(component).value = '';
         document.getElementById(component).disabled = false;
     }*/
    //console.log(place);
    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];

        if (addressType == 'administrative_area_level_1') {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById('Contacts_editView_fieldName_otherstate').value = val;
        }
        /************* Country ***************************/
        if (addressType == 'country') {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById('Contacts_editView_fieldName_othercountry').value = val;
        }
        /*********** City**************/
        if(addressType == 'locality'){
             var val = place.address_components[i][componentForm[addressType]];
            console.log(place.address_components);
        
            document.getElementById('Contacts_editView_fieldName_othercity').value = val;
        }
    
    }

}



function pickupgeolocate(){
    //console.log("Inside Dispatch Function");

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position){
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocompletepikcup.setBounds(circle.getBounds());
        });
    }
}

function dispatchgeolocate() {
    // console.log("Inside Dispatch Function");
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var geolocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
            };
            var circle = new google.maps.Circle({
                center: geolocation,
                radius: position.coords.accuracy
            });
            autocompletedispatch.setBounds(circle.getBounds());
        });
    }
}