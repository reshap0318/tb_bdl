<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }

  if($aksi == 'table'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $pencarian = date('Y-m-d', strtotime($pencarian));
      $sql = "SELECT DISTINCT pelayaran.id_pelayaran, kapal.id_kapal, kapal.nama as namakapal, count(abk.id_abk) as jabk, count(alat_tangkap_kapal.id_kapal) jalat,jenis_kapal.nama as jenis, tanda_selar, mesin, panjang, berat_kotor, count(pemilik.nama) as pemilik FROM public.kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join abk on kapal.id_kapal = abk.id_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik left join pelayaran on pelayaran.id_kapal = kapal.id_kapal where pelayaran.tanggal_keluar = '$pencarian' group by kapal.id_kapal, jenis, alat_tangkap_kapal.id_kapal, pelayaran.id_pelayaran";
    }else{
      $sql = "SELECT DISTINCT pelayaran.id_pelayaran, kapal.id_kapal, kapal.nama as namakapal, count(abk.id_abk) as jabk, count(alat_tangkap_kapal.id_kapal) jalat,jenis_kapal.nama as jenis, tanda_selar, mesin, panjang, berat_kotor, count(pemilik.nama) as pemilik FROM public.kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join abk on kapal.id_kapal = abk.id_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik left join pelayaran on pelayaran.id_kapal = kapal.id_kapal group by kapal.id_kapal, jenis, alat_tangkap_kapal.id_kapal, pelayaran.id_pelayaran";
    }
    $eksekusi = pg_query($sql);
    $data = array();
    $no = 0;
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;




  }else if($aksi == 'layer') {



    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "Select *, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from pelayaran where id_pelayaran = '$pencarian'";
    }else{
      $sql = "Select *, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from pelayaran";
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
          'id' => $data['id_pelayaran'],
          'tujuan' => $data['tujuan'],
          'lon' => $data['lng'],
          'lat' => $data['lat'],
         )
      );
      array_push($hasil['features'], $features);
  	}
  	echo json_encode($hasil);



  }else if($aksi == 'cari'){
    $pencarian = $_GET['pencarian'];
    $sql = "Select *, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from pelayaran where id_pelayaran = '$pencarian'";
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_pelayaran'];
          $tujuan=$row['tujuan'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id, 'tujuan'=>$tujuan, 'longitude'=>$longitude,'latitude'=>$latitude);
    }
    echo json_encode ($dataarray);


  }else if($aksi == 'tableabk'){


    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "select abk.id_abk, abk.nama, jabatan.nama as jabatan, kebangsaan.nama as kebangsaan from abk join jabatan on abk.id_jabatan = jabatan.id_jabatan join kebangsaan on abk.id_kebangsaan = kebangsaan.id_kebangsaan where abk.id_kapal = $pencarian";
    }else{
      $sql = "select abk.id_abk, abk.nama, jabatan.nama as jabatan, kebangsaan.nama as kebangsaan from abk join jabatan on abk.id_jabatan = jabatan.id_jabatan join kebangsaan on abk.id_kebangsaan = kebangsaan.id_kebangsaan";
    }
    $eksekusi = pg_query($sql);
    $data = array();
    $no = 0;
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;



  }else if($aksi == 'cariabk'){


    $pencarian = $_GET['pencarian'];
    $sql = "select st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) lat, abk.id_abk, abk.nama, jabatan.nama as jabatan, kebangsaan.nama as kebangsaan from abk join jabatan on abk.id_jabatan = jabatan.id_jabatan join kebangsaan on abk.id_kebangsaan = kebangsaan.id_kebangsaan where abk.id_abk = $pencarian";
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_abk'];
          $jabatan=$row['jabatan'];
          $kebangsaan=$row['kebangsaan'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id, 'kebangsaan'=>$kebangsaan,'jabatan'=>$jabatan,  'longitude'=>$longitude,'latitude'=>$latitude);
    }
    echo json_encode ($dataarray);


  }


?>
