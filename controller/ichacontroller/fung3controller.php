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
      $sql = "select distinct pemilik.id_pemilik,  pemilik.nama as nama_pemilik, kapal.id_kapal, kapal.nama as nama_kapal, count(abk.id_abk) as jabk, jenis_kapal.nama as jenis_kapal,  alat_tangkap.nama as alat_tangkap, kepemilikan_kapal.keterangan, pemilik.geom from pemilik left join kepemilikan_kapal on pemilik.id_pemilik = kepemilikan_kapal.id_pemilik left join kapal on kepemilikan_kapal.id_kapal=kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap left join abk on kapal.id_kapal=abk.id_kapal where jenis_kapal.id_jenis_kapal in ($pencarian) group by pemilik.id_pemilik, kapal.id_kapal, jenis_kapal.nama, alat_tangkap.nama, kepemilikan_kapal.keterangan " ;
    }else{
      $sql = "select distinct pemilik.id_pemilik,  pemilik.nama as nama_pemilik, kapal.id_kapal, kapal.nama as nama_kapal, count(abk.id_abk) as jabk, jenis_kapal.nama as jenis_kapal,  alat_tangkap.nama as alat_tangkap, kepemilikan_kapal.keterangan, pemilik.geom from pemilik left join kepemilikan_kapal on pemilik.id_pemilik = kepemilikan_kapal.id_pemilik left join kapal on kepemilikan_kapal.id_kapal=kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap left join abk on kapal.id_kapal=abk.id_kapal group by pemilik.id_pemilik, kapal.id_kapal, jenis_kapal.nama, alat_tangkap.nama, kepemilikan_kapal.keterangan ";
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
      $sql = "SELECT id_pemilik, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pemilik where id_pemilik = $pencarian";
    }else{
      $sql = "SELECT id_pemilik, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pemilik";
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
          'id' => $data['id_pemilik'],
          'nama' => $data['nama'],
          'lon' => $data['lng'],
          'lat' => $data['lat'],
         )
      );
      array_push($hasil['features'], $features);
    }
    echo json_encode($hasil);


  }
  else if($aksi== 'pemilik'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_pemilik, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pemilik where id_pemilik = $pencarian";
    }else{
      $sql = "SELECT id_pemilik, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pemilik";
    }
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_pemilik'];
          $nama=$row['nama'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id,'nama'=>$nama,'longitude'=>$longitude,'latitude'=>$latitude);
    }
    echo json_encode($dataarray);
  }





?>
