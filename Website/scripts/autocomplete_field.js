// This example displays an address form, using the autocomplete feature
// of the Google Places API to help users fill in the information.

// This example requires the Places library. Include the libraries=places
// parameter when you first load the API. For example:
// <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

var placeSearch, autocomplete, autocomplete2;
var componentForm = {
    street_number: 'short_name',
    route: 'long_name',
    locality: 'long_name',
    administrative_area_level_1: 'short_name',
    country: 'long_name',
    postal_code: 'short_name',
    lat: ''
};

function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical
    // location types.
    autocomplete = new google.maps.places.Autocomplete(
        /** @type {!HTMLInputElement} */(document.getElementById('autocomplete')),
        { types: ['geocode'] });

    autocomplete2 = new google.maps.places.Autocomplete(
        document.getElementById('autocomplete2'),
        { types: [ 'geocode' ] });


    google.maps.event.addListener(autocomplete, 'place_changed', function() {
        let place = autocomplete.getPlace();
        let lat = place.geometry.location.lat();
        let lng = place.geometry.location.lng();
        console.log(lat + " " + lng);

        document.getElementById("start_lat").value = lat;
        document.getElementById("start_lng").value = lng;
        //fillInAddress(place);

    });

    google.maps.event.addListener(autocomplete2, 'place_changed', function() {
        let placedes = autocomplete2.getPlace();
        let latdes = placedes.geometry.location.lat();
        let lngdes = placedes.geometry.location.lng();
        console.log(latdes + " " + lngdes);

        document.getElementById("dest_lat").value = latdes;
        document.getElementById("dest_lng").value = lngdes;
        //fillInAddress(placedes);

    });
    // When the user selects an address from the dropdown, populate the address
    // fields in the form.
    //autocomplete.addListener('place_changed', fillInAddress);
}

function fillInAddress(place) {
    // Get the place details from the autocomplete object.


    for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
    }

    // Get each component of the address from the place details
    // and fill the corresponding field on the form.
    for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
            var val = place.address_components[i][componentForm[addressType]];
            document.getElementById(addressType).value = val;

        }
    }
}

// Bias the autocomplete object to the user's geographical location,
// as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
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
            autocomplete.setBounds(circle.getBounds());
        });
    }
}