/*+***********************************************************************************
 * This file was created by Nirbhay Shah on 16/01/2018
 * This file was created mainly for Google-API-Integration Changes
 * All Rights Reserved.
 *************************************************************************************/
var placeSearch, autocompletepikcup;
    var componentForm = {
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        country: 'long_name'
    };

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
   
    autocompletepikcup = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('Vendors_editView_fieldName_city')),
        { types: ['(cities)'] });
     
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    autocompletepikcup.addListener('place_changed', fillInAddresspickup);
           
}

function fillInAddresspickup() {
    // Get the place details from the autocomplete object.
    var place = autocompletepikcup.getPlace();
    console.log(place);

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.

    for (var i = 0; i < place.address_components.length; i++) {
        
        var addressType = place.address_components[i].types[0];
        /************* State ***************************/
        if (addressType == 'administrative_area_level_1') {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById('Vendors_editView_fieldName_state').value = val;
        }
        /************* Country ***************************/
        if (addressType == 'country') {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById('Vendors_editView_fieldName_country').value = val;
        }
        /*********** City**************/
        if(addressType == 'locality'){
             var val = place.address_components[i][componentForm[addressType]];
            console.log(place.address_components);
        
            document.getElementById('Vendors_editView_fieldName_city').value = val;
        }
    }
}


function pickupgeolocate(){
    
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

