
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>
<script src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false&libraries=visualization"></script>

<script type="text/javascript">

  var infowindow;
  var geomarker;
  var markerarray = [];
  var map;
  var objek;
  var directionsService;
  var directionDisplay;
  var usegeolocation;
  var server="http://localhost/tb_bdl/controller/kabkotcontroller.php?aksi=";
  var markerarraygeo=[];
  var circlearray=[];
  var layernya;

  function initialize() {
     geolocation();
     basemap();
  }
  function basemap() {
  		google.maps.visualRefresh = true;
      map = new google.maps.Map(document.getElementById('mapGeo'), {
          zoom: 10,
          center: new google.maps.LatLng(-0.914813, 100.458801),
          mapTypeId: google.maps.MapTypeId.ROADMAP
      });
      loadLayer();
  };

  function loadLayer(){
      layernya = new google.maps.Data();
      layernya.loadGeoJson(server+'layerindex');
      layernya.setMap(map);
  }
      function loaddata(results){
        	if(results.features === null)
               {
                   alert("Data yang dicari tidak ada");
               }
               else
               {
                for (var i = 0; i < results.features.length; i++) {
                  console.log(results.features.length);
                    var data = results.features[i];
                    var coords = data.geometry.coordinates;
                    var id = data.properties.id;
                    var nama = data.properties.nama;
                    var titiktengah = data.properties.center
                    console.log(titiktengah);
                    var latitude = titiktengah.lat;
                    var longitude = titiktengah.lng;
                    var latLng = new google.maps.LatLng(latitude,longitude);
                    var iconBase = 'http://localhost/tb_bdl/img/icon/placeholder.png';
                    var marker = new google.maps.Marker({
                      position: latLng,
                      map: map,
                      zoom: 18,
                      animation: google.maps.Animation.DROP,
                      icon: iconBase,
                      title: nama
                      //shadow: iconBase + 'schools_maps.shadow.png'
                    });
        	           markerarray.push(marker); //menmpilkan informasi pada marking
                     var isiinfo="<div><b><h2><center>"+nama+"</center></h2></b></div>";
                     createInfoWindow(marker, isiinfo);
                 }
        	    }
          }

     var infowindow = new google.maps.InfoWindow();
     function createInfoWindow(marker, isiinfo) {
        google.maps.event.addListener(marker, 'click', function() {
        infowindow.setContent(isiinfo);
        infowindow.open(map, this);
        });
     }
    google.maps.event.addDomListener(window, 'load', initialize);

   function clearmarkergeo(){
         for (var i = 0; i < markerarraygeo.length; i++) {
          markerarraygeo[i].setMap(null);
         }
         markerarraygeo=[];
     }

     function clearmarker(){
         for (var i = 0; i < markerarray.length; i++) {
          markerarray[i].setMap(null);
         }
         markerarray=[];
     }


   function geolocation(){
     navigator.geolocation.getCurrentPosition(geolocationSuccess, geolocationError);
     }

     function geolocationSuccess(posisi){
     var pos=new google.maps.LatLng(posisi.coords.latitude,posisi.coords.longitude);
     geomarker = new google.maps.Marker({
          map: map,
          position: pos,
          animation: google.maps.Animation.DROP
    });

      map.panTo(pos);
        infowindow = new google.maps.InfoWindow();
        infowindow.setContent('Your Position');
        infowindow.open(map, geomarker);
      usegeolocation=true;
     }

     function geolocationError(err){
         usegeolocation=false;

     }
</script>

<script type="text/javascript">
function pin(id) {
     clearmarker();
     var script1 = document.createElement('script');
     script1.src = server+'detailpeta&id='+id+'';
     console.log(server+'detailpeta&id='+id+'');
     document.getElementsByTagName('head')[0].appendChild(script1);
}
</script>

<script async defer
  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC3UDFwI28UYpMQQqpV7YxlSBShk-7fGCc&callback=initMap">
</script>
