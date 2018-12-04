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
      $sql = "SELECT pemilik.id_pemilik, pemilik.nama, pemilik.tgl_lahir, pemilik.agama, pemilik.pendidikan, pemilik.geom FROM public.pemilik left join kepemilikan_kapal on pemilik.id_pemilik=kepemilikan_kapal.id_pemilik left join kapal on kepemilikan_kapal.id_kapal=kapal.id_kapal left join abk on kapal.id_kapal=abk.id_kapal left join kebangsaan on abk.id_kebangsaan=kebangsaan.id_kebangsaan where st_contains((select geom from kecamatan where id_kecamatan = $pencarian),st_astext(pemilik.geom))";
    }else{
      $sql = "SELECT pemilik.id_pemilik, pemilik.nama, pemilik.tgl_lahir, pemilik.agama, pemilik.pendidikan, pemilik.geom FROM public.pemilik left join kepemilikan_kapal on pemilik.id_pemilik=kepemilikan_kapal.id_pemilik left join kapal on kepemilikan_kapal.id_kapal=kapal.id_kapal left join abk on kapal.id_kapal=abk.id_kapal left join kebangsaan on abk.id_kebangsaan=kebangsaan.id_kebangsaan";
    }
    $eksekusi = pg_query($sql);
    $data = array();
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;



  }
  else if($aksi == 'kecamatan'){
    $pencarian = $_GET['pencarian'];
    $sql = "select * from kecamatan where st_contains(st_astext((select geom from kabkota where id_kabkot = $pencarian)),st_astext(geom))";
    $eksekusi = pg_query($sql);
    $dataarray=array();

    while($row = pg_fetch_array($eksekusi))
      {
    	 $idkecamatan=$row['id_kecamatan'];
    	 $namakecamatan=$row['nama'];
    	 $dataarray[]=array('id'=>$idkecamatan,'nama'=>$namakecamatan);
      }
      echo json_encode ($dataarray);
  }
  else if($aksi == 'layer') {

    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      //untuk geom
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
          //menyesuaikan digunakan pada map pada bagian layer
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
  else if($aksi== 'pemiliks'){


    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_pemilik, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.pemilik where st_contains((select geom from kecamatan where id_kecamatan = $pencarian),st_astext(pemilik.geom)";
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
