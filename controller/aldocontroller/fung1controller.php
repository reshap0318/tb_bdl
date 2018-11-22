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
      $sql = "select distinct abk.id_abk, abk.nama as namaabk, kebangsaan.nama as kebangsaan, jabatan.nama as jabatan, abk.sertifikat as sertifikat, abk.geom, kapal.nama as kapal from abk join kebangsaan on abk.id_kebangsaan = kebangsaan.id_kebangsaan join jabatan on abk.id_jabatan = jabatan.id_jabatan join kapal on abk.id_kapal = kapal.id_kapal join pelayaran on kapal.id_kapal = pelayaran.id_kapal JOIN produksi on pelayaran.id_pelayaran = produksi.id_pelayaran join jenis_tangkapan on produksi.id_jenis_tangkapan = jenis_tangkapan.id_jenis_tangkapan where jenis_tangkapan.id_jenis_tangkapan in ($pencarian)" ;
    }else{
      $sql = "select distinct abk.id_abk, abk.nama as namaabk, kebangsaan.nama as kebangsaan, jabatan.nama as jabatan, abk.sertifikat as sertifikat, abk.geom, kapal.nama as kapal from abk join kebangsaan on abk.id_kebangsaan = kebangsaan.id_kebangsaan join jabatan on abk.id_jabatan = jabatan.id_jabatan join kapal on abk.id_kapal = kapal.id_kapal join pelayaran on kapal.id_kapal = pelayaran.id_kapal JOIN produksi on pelayaran.id_pelayaran = produksi.id_pelayaran join jenis_tangkapan on produksi.id_jenis_tangkapan = jenis_tangkapan.id_jenis_tangkapan";
    }
    $eksekusi = pg_query($sql);
    $data = array();
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;



  }else if($aksi == 'layer') {

    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_abk, nama, id_kebangsaan, sertifikat, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.abk where id_abk = $pencarian";
    }else{
      $sql = "SELECT id_abk, nama, id_kebangsaan, sertifikat, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.abk";
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
          'id' => $data['id_abk'],
          'nama' => $data['nama'],
          'lon' => $data['lng'],
          'lat' => $data['lat'],
         )
      );
      array_push($hasil['features'], $features);
  	}
  	echo json_encode($hasil);


  }else if($aksi== 'abk'){


    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_abk, nama, id_kebangsaan, sertifikat, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.abk where id_abk = $pencarian";
    }else{
      $sql = "SELECT id_abk, nama, id_kebangsaan, sertifikat, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.abk";
    }
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_abk'];
          $nama=$row['nama'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id,'nama'=>$nama,'longitude'=>$longitude,'latitude'=>$latitude);
    }
  	echo json_encode($dataarray);
  }




?>
