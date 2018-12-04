<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBNnzxae2AewMUN0Tt_fC3gN38goeLVdVE"></script>
<script type="text/javascript">
var pos ='null';
var circles=[];
var info_windows = [];
//ubah
var server = "http://localhost/tb_bdl/controller/asrafcontroller/fung5controller.php?aksi=";
var markers = [];
var directionsDisplay;
var rute = [];  //NAVIGASI
var angkot = [];
var centerBaru;
var jalurAngkot=[];
var centerLokasi; //untuk fungsi CallRoute()

window.onload = function() {
  pemilik();
  basemap();
  semuapemilik();
};

function pemilik() //tampil digitasi pemilik
{
    pemilik = new google.maps.Data();
    pemilik.loadGeoJson(server+'layer');
    pemilik.setStyle(function(feature){
        return({
            fillColor: '#42cb6f',
            strokeColor: '#42cb6f',
            strokeWeight: 1,
            fillOpacity: 7
        });
    });
    pemilik.setMap(map);
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

function semuapemilik(){ //menampilkan semua pemilik
  $.ajax({ url: server+'pemilik', data: "", dataType: 'json', success: function (rows){
    tampilsemuapemilik(rows, 10);
  }});
}

function tampilsemuapemilik(rows, zoom){ //fungsi cari mesjid berdasarkan nama
  if(rows==null){
    alert('pemilik not found');
  }
  for (var i in rows)
  {
    var row = rows[i];
    var id = row.id;
    var nama = row.nama;
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
    markers.push(marker);
    map.setCenter(centerBaru);
    detail_info(nama, centerBaru);
    map.setZoom(zoom);
  }
}

function detail_info(nama, center){  //menampilkan informasi masjid
  google.maps.event.addListener(marker, "click", function(){
    infowindow = new google.maps.InfoWindow({
      position: center,
      content: "Rumah "+nama,
      pixelOffset: new google.maps.Size(0, -33)
    });
    info_windows.push(infowindow);
    hapusInfo();
    infowindow.open(map);
  });
}

function satupemilik(id) {
  $.ajax({ url: server+'pemilik&pencarian='+id, data: "", dataType: 'json', success: function (rows){
    hapusInfo();
    hapusmarker();
    tampilsemuapemilik(rows, 18);
  }});
}

function jamakpemilik(id) {
  $.ajax({ url: server+'pemiliks&pencarian='+id, data: "", dataType: 'json', success: function (rows){
    hapusInfo();
    hapusmarker();
    tampilsemuapemilik(rows, 18);
  }});
}



// function cek(){
//  var cek = document.getElementById('km').innerHTML=document.getElementById('inputradiusmes').value*100;
// }
//
// function aktifkanRadius(){ //fungsi radius
//   if (pos == 'null'){
//     alert ('Click button current position or manual position first !');
//   }
//   else {
//     hapusRadius();
//     var inputradiusmes=document.getElementById("inputradiusmes").value;
//     console.log(inputradiusmes);
//     var circle = new google.maps.Circle({
//       center: pos,
//       radius: parseFloat(inputradiusmes*100),
//       map: map,
//       strokeColor: "blue",
//       strokeOpacity: 0.8,
//       strokeWeight: 2,
//       fillColor: "blue",
//       fillOpacity: 0.35
//     });
//     map.setZoom(14);
//     map.setCenter(pos);
//     circles.push(circle);
//   }
//   cekRadiusStatus = 'on';
//   masjidradius();
// }


</script>
