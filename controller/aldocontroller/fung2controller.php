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
      $sql = "SELECT DISTINCT pelayaran.id_pelayaran, pelayaran.id_kapal, kapal.nama as namakapal, kapal.tanda_selar, kapal.mesin, kapal.panjang, kapal.berat_kotor, jenis_kapal.nama as jeniskapal, tanggal_keluar, count(alat_tangkap_kapal.*) as jmlhalattgkp, count(keterangan_pelayaran_abk.*) as jabk, count(pemilik.*) as jmlhpemilik,administrasi, tujuan, pelayaran.geom FROM pelayaran left join kapal on pelayaran.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join keterangan_pelayaran_abk on pelayaran.id_pelayaran = keterangan_pelayaran_abk.id_pelayaran left join kepemilikan_kapal on kepemilikan_kapal.id_kapal = kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik where tanggal_keluar = '$pencarian' group by pelayaran.id_pelayaran, kapal.nama, jenis_kapal.nama, kapal.tanda_selar, kapal.mesin, kapal.panjang, kapal.berat_kotor";
    }else{
      $sql = "SELECT DISTINCT pelayaran.id_pelayaran, pelayaran.id_kapal, kapal.nama as namakapal, kapal.tanda_selar, kapal.mesin, kapal.panjang, kapal.berat_kotor, jenis_kapal.nama as jeniskapal, tanggal_keluar, count(alat_tangkap_kapal.*) as jmlhalattgkp, count(keterangan_pelayaran_abk.*) as jabk, count(pemilik.*) as jmlhpemilik,administrasi, tujuan, pelayaran.geom FROM pelayaran left join kapal on pelayaran.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join keterangan_pelayaran_abk on pelayaran.id_pelayaran = keterangan_pelayaran_abk.id_pelayaran left join kepemilikan_kapal on kepemilikan_kapal.id_kapal = kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik group by pelayaran.id_pelayaran, kapal.nama, jenis_kapal.nama, kapal.tanda_selar, kapal.mesin, kapal.panjang, kapal.berat_kotor";
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
      $sql = "Select *, kapal.nama as namakapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from pelayaran left join kapal on pelayaran.id_kapal = kapal.id_kapal where id_pelayaran = '$pencarian'";
    }else{
      $sql = "Select *, kapal.nama as namakapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from pelayaran left join kapal on pelayaran.id_kapal = kapal.id_kapal";
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
          'namakapal' => $data['namakapal'],
          'lon' => $data['lng'],
          'lat' => $data['lat'],
         )
      );
      array_push($hasil['features'], $features);
  	}
  	echo json_encode($hasil);



  }else if($aksi == 'cari'){
    $pencarian = $_GET['pencarian'];
    $sql = "Select *, kapal.nama as namakapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from pelayaran left join kapal on pelayaran.id_kapal = kapal.id_kapal where id_pelayaran = '$pencarian'";
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_pelayaran'];
          $nama=$row['nama'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id, 'nama'=>$nama, 'longitude'=>$longitude,'latitude'=>$latitude);
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
          $nama=$row['nama'];
          $kebangsaan=$row['kebangsaan'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id, 'kebangsaan'=>$kebangsaan,'nama'=>$nama,  'longitude'=>$longitude,'latitude'=>$latitude);
    }
    echo json_encode ($dataarray);


  }


?>
