<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
  if($aksi=='tablef3'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "" ;
    }else{
      $sql = "select kub.id_kub, kub.nama, alamat, deskripsi, kub.tgl_berdiri, count(usaha_perikanan.*) as jumlahusaha, kecamatan.nama from kub join usaha_perikanan on kub.id_kub =usaha_perikanan.id_kub join kecamatan on st_contains(st_astext(kecamatan.geom), st_astext(kub.geom)) group by kub.id_kub, kecamatan.nama";
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
