<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
if($aksi=='tablef1'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "select distinct usaha_perikanan.id_usaha, usaha_perikanan.nama_usaha, jenis_usaha.nama as jenis_usaha, kub.nama as nama_kub, transaksi.tanggal, jenis_tangkapan.nama as jenis_tangkapan, count(jenis_tangkapan.nama) as jumlah_tangkapan from usaha_perikanan left join jenis_usaha on usaha_perikanan.id_jenisusaha=jenis_usaha.id_jenis_usaha left join kub on usaha_perikanan.id_kub=kub.id_kub left join transaksi on kub.id_kub=transaksi.id_kub left join detail_transaksi on transaksi.id_transaksi=detail_transaksi.id_transaksi left join produksi on detail_transaksi.id_produksi=produksi.id_produksi left join jenis_tangkapan on produksi.id_jenis_tangkapan=jenis_tangkapan.id_jenis_tangkapan where jenis_tangkapan.id_jenis_tangkapan in ($pencarian) group by usaha_perikanan.id_usaha, jenis_usaha.nama, kub.nama, transaksi.tanggal, jenis_tangkapan.nama, produksi.id_produksi, detail_transaksi.id_detail_transaksi" ;
    }else{
      $sql = "select distinct usaha_perikanan.id_usaha, usaha_perikanan.nama_usaha, jenis_usaha.nama as jenis_usaha, kub.nama as nama_kub, transaksi.tanggal, jenis_tangkapan.nama as jenis_tangkapan, count(jenis_tangkapan.nama) as jumlah_tangkapan from usaha_perikanan left join jenis_usaha on usaha_perikanan.id_jenisusaha=jenis_usaha.id_jenis_usaha left join kub on usaha_perikanan.id_kub=kub.id_kub left join transaksi on kub.id_kub=transaksi.id_kub left join detail_transaksi on transaksi.id_transaksi=detail_transaksi.id_transaksi left join produksi on detail_transaksi.id_produksi=produksi.id_produksi left join jenis_tangkapan on produksi.id_jenis_tangkapan=jenis_tangkapan.id_jenis_tangkapan group by usaha_perikanan.id_usaha, jenis_usaha.nama, kub.nama, transaksi.tanggal, jenis_tangkapan.nama, produksi.id_produksi, detail_transaksi.id_detail_transaksi";
    }
    $eksekusi = pg_query($sql);
    $data = array();
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;



  }

else if($aksi == 'layer') {

    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_usaha, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.usaha_perikanan where id_usaha = $pencarian";
    }else{
      $sql = "SELECT id_usaha, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.usaha_perikanan";
    }
    $eksekusi = pg_query($sql);
    $hasil = array(
       'type'	=> 'FeatureCollection',
       'features' => array()
     );

    while($data=pg_fetch_array($eksekusi))
  	{
      $features = array(
        'type' => 'Feature',
        'geometry' => json_decode($data['geometry']),
        'properties' => array(
          'id' => $data['id_usaha'],
          'lon' => $data['lng'],
          'lat' => $data['lat'],
         )
      );
      array_push($hasil['features'], $features);
  	}
  	echo json_encode($hasil);


  }

else if($aksi== 'usaha_perikanan'){


    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_usaha, nama_usaha, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.usaha_perikanan where id_usaha = $pencarian";
    }else{
      $sql = "SELECT id_usaha, nama_usaha, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.usaha_perikanan";
    }
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_usaha'];
          $nama=$row['nama_usaha'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id,'nama'=>$nama,'longitude'=>$longitude,'latitude'=>$latitude);
    }
  	echo json_encode($dataarray);
  }




?>
