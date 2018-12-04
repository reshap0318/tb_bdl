<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
  if($aksi=='tablef5'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "select distinct abk.nama as abk, abk.id_abk, jabatan.nama as jabatan, kebangsaan.nama as kebangsaan, kapal.nama as kapal, jenis_kapal.nama as jenis_kapal, count(alat_tangkap_kapal.id_kapal) as jalat, count(keterangan_pelayaran_abk.id_abk) as jpelayaran from abk left join jabatan on abk.id_jabatan = jabatan.id_jabatan left join kebangsaan on abk.id_kebangsaan = kebangsaan.id_kebangsaan left join kapal on abk.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap left join keterangan_pelayaran_abk on abk.id_abk = keterangan_pelayaran_abk.id_abk where alat_tangkap.id_alat_tangkap in ($pencarian) group by abk.id_abk, kapal.id_kapal, jabatan.id_jabatan, kebangsaan.id_kebangsaan, jenis_kapal.id_jenis_kapal, alat_tangkap.id_alat_tangkap, keterangan_pelayaran_abk.id_abk" ;
    }else{
      $sql = "select distinct abk.nama as abk, abk.id_abk, jabatan.nama as jabatan, kebangsaan.nama as kebangsaan, kapal.nama as kapal, jenis_kapal.nama as jenis_kapal, count(alat_tangkap_kapal.id_kapal) as jalat, count(keterangan_pelayaran_abk.id_abk) as jpelayaran from abk left join jabatan on abk.id_jabatan = jabatan.id_jabatan left join kebangsaan on abk.id_kebangsaan = kebangsaan.id_kebangsaan left join kapal on abk.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap left join keterangan_pelayaran_abk on abk.id_abk = keterangan_pelayaran_abk.id_abk group by abk.id_abk, kapal.id_kapal, jabatan.id_jabatan, kebangsaan.id_kebangsaan, jenis_kapal.id_jenis_kapal, alat_tangkap.id_alat_tangkap, keterangan_pelayaran_abk.id_abk";
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


  }
  else if($aksi== 'abk'){


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
