
function initializeMap() {
  if (latContact != 0 && lngContact != 0) {
    setMapPosition(latContact, lngContact);
  }
};

function setMapPosition(latitude, longitude) {
  var map = new google.maps.Map(document.getElementById('map_canvas'), {
    center: new google.maps.LatLng(latitude,longitude),
    zoom: 15,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });

  var markerPosition = new google.maps.LatLng(latitude, longitude);

  new google.maps.Marker({
    position: markerPosition,
    map: map,
    draggable: true,
    icon : '/marker.png'
  });
}
