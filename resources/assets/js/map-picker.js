google.maps.event.addDomListener(window, 'load', initialize);

function initialize() {
  var lat = $.trim($("#latitude").val());
  var lng = $.trim($("#longitude").val());
  if (lat.length>0||lng.length>0) {
    setMapPosition(lat,lng);
  }else{
    var village = $('#village').find(':selected').data('village');
    var district = $('#village').find(':selected').data('district');
    setGeo(village,district);
  }
};

$('#village').change(function() {
  var village = $(this).find(':selected').data('village');
  var district = $(this).find(':selected').data('district');
  setGeo(village,district);
});

function setGeo(village,district){
  geocoder = new google.maps.Geocoder();
  geocoder.geocode({ 'address': village +', kecamatan '+district + 'Kabupaten Garut' }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
      var latitude = results[0].geometry.location.lat();
      var longitude = results[0].geometry.location.lng();
      setMapPosition(latitude,longitude);
    }else{
      console.log("Error");
    }
  });
}

function setMapPosition(latitude,longitude){
  map = new google.maps.Map(document.getElementById("map_canvas"), {
    center: new google.maps.LatLng(latitude,longitude),
    zoom: 16,
    panControl: false,
    mapTypeId: google.maps.MapTypeId.HYBRID
  });
  var markerPosition = new google.maps.LatLng(latitude,longitude);
  marker = new google.maps.Marker({
    position: markerPosition,
    map: map,
    draggable: true,
    icon : '/marker.png'
  });
  setMarker(markerPosition);
  google.maps.event.addListener(marker, 'drag', function() {
    setMarker(marker.getPosition());
  });
}

function setMarker(markerPosition){
  $('#latitude').val(markerPosition.lat());
  $('#longitude').val(markerPosition.lng());
}
