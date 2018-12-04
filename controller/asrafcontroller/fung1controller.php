<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
  if($aksi=='tablef1'){
    if(isset($_GET['pencarian1'])){
      $pencarian1 = $_GET['pencarian1'];
      $pencarian2 = $_GET['pencarian2'];
      $pencarian2 = date('Y-m-d', strtotime($pencarian2));
      $sql = "SELECT jenis_kapal.id_jenis_kapal, pemilik.id_pemilik, jenis_kapal.nama as jenis, kapal.nama as nama, pemilik.nama as pemilik, pelayaran.id_pelayaran as kode, pelayaran.tanggal_masuk as tanggal_masuk, pelayaran.tanggal_keluar as tanggal_keluar FROM public.jenis_kapal  left join kapal on jenis_kapal.id_jenis_kapal=kapal.id_jenis_kapal left join kepemilikan_kapal on kapal.id_kapal=kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik=pemilik.id_pemilik left join pelayaran on kapal.id_kapal=pelayaran.id_kapal Where pelayaran.tanggal_keluar='$pencarian2' AND pemilik.id_pemilik in $pencarian1";
    }else{
      $sql = "SELECT jenis_kapal.id_jenis_kapal, pemilik.id_pemilik,jenis_kapal.nama as jenis, kapal.nama as nama, pemilik.nama as pemilik, pelayaran.id_pelayaran as kode, pelayaran.tanggal_masuk as tanggal_masuk, pelayaran.tanggal_keluar as tanggal_keluar FROM public.jenis_kapal  left join kapal on jenis_kapal.id_jenis_kapal=kapal.id_jenis_kapal left join kepemilikan_kapal on kapal.id_kapal=kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik=pemilik.id_pemilik left join pelayaran on kapal.id_kapal=pelayaran.id_kapal";
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




?>
