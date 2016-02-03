<?php
echo"<div id='map'></div>
    <script>
    
    //data Load
    var arrMap = [
        {lat:32.891723, lng:-117.225990},
        {lat:32.899251, lng:-117.191149},
        {lat:32.899754, lng:-117.191140},
        {lat:32.899642, lng:-117.191949},
        {lat:32.882602, lng:-117.234811}
    ];
    
    function initMap() {
      var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 18,
        scrollwheel: true
      });
      for(var i=0; i<arrMap.length; i++ ){
          var marker = new google.maps.Marker({
            position: arrMap[i],
            map: map,
            title: 'ourhouse!'
      });
      }
      
      var infoWindow = new google.maps.InfoWindow({map: map});
      var location ;
      // Try HTML5 geolocation.
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
          var pos = {
            lat: position.coords.latitude,
            lng: position.coords.longitude
          };
          var cityCircle = new google.maps.Circle({
              strokeColor: '#F6E791',
              strokeOpacity: 0.8,
              strokeWeight: 2,
              fillColor: '#F6E791',
              fillOpacity: 0.35,
              map: map,
              center: pos,
              radius: 80
            });
          infoWindow.setPosition(pos);
          infoWindow.setContent('im here now.');
          map.setCenter(pos);
        }, function() {
          handleLocationError(true, infoWindow, map.getCenter());
        });
      } else {
        // Browser doesn't support Geolocation
        handleLocationError(false, infoWindow, map.getCenter());
      }
      console.log(location.lat);
      
    }
 
function handleLocationError(browserHasGeolocation, infoWindow, pos) {
  infoWindow.setPosition(pos);
  infoWindow.setContent(browserHasGeolocation ?
                        'Error: The Geolocation service failed.' :
                        'Error: Your browser doesn\'t support geolocation.');
}

</script>
<script src='https://maps.googleapis.com/maps/api/js?key=AIzaSyA0TpDbluv-HUkadtVlsV9kiwZJ8mHrkE0&signed_in=true&callback=initMap'
    async defer>
</script>"
?>