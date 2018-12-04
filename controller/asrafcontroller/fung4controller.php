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
      $sql = "SELECT kapal.nama as nama_kapal,pelayaran.id_pelayaran, pelayaran.tujuan , pelabuhan.id_pelabuhan, pelabuhan.nama, jenis_tangkapan.id_jenis_tangkapan , jenis_tangkapan.nama FROM public.kapal left join pelayaran on kapal.id_kapal=pelayaran.id_kapal left join pelabuhan on pelayaran.id_pelabuhan=pelayaran.id_pelabuhan left join produksi on pelayaran.id_pelayaran=produksi.id_pelayaran left join jenis_tangkapan on produksi.id_jenis_tangkapan=jenis_tangkapan.id_jenis_tangkapan where jenis_tangkapan.id_jenis_tangkapan=$pencarian";
    }else{
      $sql = "SELECT kapal.nama as nama_kapal,pelayaran.id_pelayaran, pelayaran.tujuan , pelabuhan.id_pelabuhan, pelabuhan.nama, jenis_tangkapan.id_jenis_tangkapan , jenis_tangkapan.nama FROM public.kapal left join pelayaran on kapal.id_kapal=pelayaran.id_kapal left join pelabuhan on pelayaran.id_pelabuhan=pelayaran.id_pelabuhan left join produksi on pelayaran.id_pelayaran=produksi.id_pelayaran left join jenis_tangkapan on produksi.id_jenis_tangkapan=jenis_tangkapan.id_jenis_tangkapan";
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
      $sql = "SELECT id_pelayaran, kapal.nama as nama_kapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pelayaran join kapal on pelayaran.id_kapal=kapal.id_kapal where id_pelayaran = $pencarian";
    }else{
      $sql = "SELECT id_pelayaran,kapal.nama as nama_kapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pelayaran join  kapal on pelayaran.id_kapal=kapal.id_kapal";
    }
    $eksekusi = pg_query($sql);
    $hasil = array(
       'type' => 'FeatureCollection',
       'features' => array()
     );

    while($data=pg_fetch_array($eksekusi))
    {
      $features = array(
        'type' => 'Feature',
        'geometry' => json_decode($data['geometry']),
        'properties' => array(
          'id' => $data['id_pelayaran'],
          'nama'=>$data['nama_kapal'],
          'lon' => $data['lng'],
          'lat' => $data['lat'],
         )
      );
      array_push($hasil['features'], $features);
    }
    echo json_encode($hasil);


  }
  else if($aksi== 'pelayaran'){


    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_pelayaran, kapal.nama as nama_kapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pelayaran join kapal on pelayaran.id_kapal=kapal.id_kapal where id_pelayaran = $pencarian";
    }else{
      $sql = "SELECT id_pelayaran,kapal.nama as nama_kapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pelayaran join kapal on pelayaran.id_kapal=kapal.id_kapal";
    }
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_pelayaran'];
          $nama=$row['nama_kapal'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id,'nama'=>$nama,'longitude'=>$longitude,'latitude'=>$latitude);
    }
    echo json_encode($dataarray);
  }




?>
