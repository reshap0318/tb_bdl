<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
<script type="text/javascript">
var pos ='null';
var info_windows = [];
var server = "http://localhost/tb_bdl/controller/asrafcontroller/fung4controller.php?aksi=";
var markers = [];
var layer = [];
var directionsDisplay;
var centerBaru;
var jalurAngkot=[];
var centerLokasi; //untuk fungsi CallRoute()

window.onload = function() {
  basemap();
  // pelayaran();
  // semuakapal();
};

function daerahpelayaran(id) {
  if(id==null){
    alert('Kapal Belum Melakukan Pelayaran, Rute Pelayaran Kapal Belum Ada');
  }else{
    pela(id);
    detaillokasipelayaran(id);
  }

}

function pela(id) //tampil digitasi kapal, tampilkan saja 1 table, disiko wak cuman menampilkan table pelayaran, karna yang memiliki geomnyo
{
    pelayaran = new google.maps.Data();
    pelayaran.loadGeoJson(server+'layer&pencarian='+id);
    pelayaran.setStyle(function(feature){
        return({
            fillColor: '#F0FFFF',
            strokeColor: '#000000',
            strokeWeight: 1,
            fillOpacity: 7
        });
    });
    layer.push(pelayaran);
    for (var i = 0; i < layer.length; i++) {
      layer[i].setMap(null);
    }
    pelayaran.setMap(map);
}

function basemap(){
    map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: new google.maps.LatLng(-1.000683, 100.370668),
    mapTypeId: google.maps.MapTypeId.ROADMAP,
  });
}


function hapusInfo() {
  for (var i = 0; i < info_windows.length; i++) {
    info_windows[i].setMap(null);
  }
}

function hapusmarker() {
  for (var i = 0; i < markers.length; i++) {
    markers[i].setMap(null);
  }
}

function detaillokasipelayaran(id) {
  $.ajax({ url: server+'pelayaran&pencarian='+id, data: "", dataType: 'json', success: function (rows){
    console.log(rows);
    tampilkanmappelayaran(rows);
  }});
}

function tampilkanmappelayaran(rows) {
  hapusInfo();
  hapusmarker();
  if(rows==null){
    alert('Pelayaran Tidak ditemukan');
  }
  for (var i in rows)
  {
    var row = rows[i];
    // console.log(row);
    var id = row.id;
    var kapal = row.nama;
    var latitude = row.latitude ;
    var longitude = row.longitude ;
    centerBaru = new google.maps.LatLng(latitude, longitude);
    marker = new google.maps.Marker({
      position: centerBaru,
      icon:'http://localhost/tb_bdl/img/icon/placeholder.png',
      map: map,
      animation: google.maps.Animation.DROP,
    });
    // console.log(id);
    // console.log(latitude);
    // console.log(longitude);
    kapal = 'Lokasi Kapal "'+kapal+'"'
    markers.push(marker);
    map.setCenter(centerBaru);
    infowindowslokasipelayaran(kapal, centerBaru);
    map.setZoom(14);
  }
}

function infowindowslokasipelayaran(tujuan, center) {
  google.maps.event.addListener(marker, "click", function(){
    infowindow = new google.maps.InfoWindow({
      position: center,
      content: tujuan,
      pixelOffset: new google.maps.Size(0, -33)
    });
    info_windows.push(infowindow);
    hapusInfo();
    infowindow.open(map);
  });
}



</script>