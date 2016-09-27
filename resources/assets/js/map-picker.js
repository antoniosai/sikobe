google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
  var village = $('#village').find(':selected').data('village');
  var district = $('#village').find(':selected').data('district');
  updateMapPoition(village,district);
};

$('#village').change(function() {
  var village = $(this).find(':selected').data('village');
  var district = $(this).find(':selected').data('district');
  updateMapPoition(village,district);
});

function updateMapPoition(village,district){
  geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'address': village +', kecamatan '+district + 'Kabupaten Garut' }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var latitude = results[0].geometry.location.lat();
      var longitude = results[0].geometry.location.lng();
      var markerPosition = new google.maps.LatLng(latitude,longitude);
      map = new google.maps.Map(document.getElementById("map_canvas"), {
        center: new google.maps.LatLng(latitude,longitude),
        zoom: 16,
        panControl: false,
        mapTypeId: google.maps.MapTypeId.HYBRID
      });
      marker = new google.maps.Marker({
        position: markerPosition,
        map: map,
        draggable: true,
        icon : '/marker.png'
      });
      updateMarkerPosition(markerPosition);
      google.maps.event.addListener(marker, 'drag', function() {
        updateMarkerPosition(marker.getPosition());
      });
    }else{
      console.log("Error");
    }
  });
}

function updateMarkerPosition(markerPosition){
  $('#latitude').val(markerPosition.lat());
  $('#longitude').val(markerPosition.lng());
}
