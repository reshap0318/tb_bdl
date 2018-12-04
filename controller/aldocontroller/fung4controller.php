<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
  if($aksi=='tablef4'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT pelayaran.id_pelayaran, pelayaran.id_kapal, tanggal_masuk, tanggal_keluar, administrasi, tujuan, pelabuhan.nama as pelabuhan, kapal.nama as kapal, jenis_kapal.nama as jenis, count(kepemilikan_kapal.id_kepemilikan) as jumlah_pemilik, count(keterangan_pelayaran_abk.id_pelayaran) as jumlah_abk_pergi FROM pelayaran left join pelabuhan on pelayaran.id_pelabuhan = pelabuhan.id_pelabuhan left join kapal on pelayaran.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik left join keterangan_pelayaran_abk on pelayaran.id_pelayaran = keterangan_pelayaran_abk.id_pelayaran left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap where alat_tangkap.id_alat_tangkap in ($pencarian) group by pelayaran.id_pelayaran, pelabuhan.nama, kapal.nama, jenis_kapal.nama, pelayaran.id_kapal" ;
    }else{
      $sql = "SELECT pelayaran.id_pelayaran, pelayaran.id_kapal, tanggal_masuk, tanggal_keluar, administrasi, tujuan, pelabuhan.nama as pelabuhan, kapal.nama as kapal, jenis_kapal.nama as jenis, count(kepemilikan_kapal.id_kepemilikan) as jumlah_pemilik, count(keterangan_pelayaran_abk.id_pelayaran) as jumlah_abk_pergi FROM pelayaran left join pelabuhan on pelayaran.id_pelabuhan = pelabuhan.id_pelabuhan left join kapal on pelayaran.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik left join keterangan_pelayaran_abk on pelayaran.id_pelayaran = keterangan_pelayaran_abk.id_pelayaran group by pelayaran.id_pelayaran, pelabuhan.nama, kapal.nama, jenis_kapal.nama, pelayaran.id_kapal";
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

  }
  else if($aksi== 'cari'){
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
  }
  else if($aksi == 'tableabk'){

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

  }
  else if($aksi == 'cariabk'){

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
  else if($aksi == 'tablepemilik'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "select pemilik.id_pemilik, pemilik.nama, tgl_lahir, agama, pendidikan from  pemilik left join kepemilikan_kapal on pemilik.id_pemilik = kepemilikan_kapal.id_pemilik join kapal on kepemilikan_kapal.id_kapal = kapal.id_kapal where kapal.id_kapal = $pencarian";
    }else{
      $sql = "select pemilik.id_pemilik, pemilik.nama, tgl_lahir, agama, pendidikan from  pemilik left join kepemilikan_kapal on pemilik.id_pemilik = kepemilikan_kapal.id_pemilik join kapal on kepemilikan_kapal.id_kapal = kapal.id_kapal";
    }
    $eksekusi = pg_query($sql);
    $data = array();
    $no = 0;
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;
  }
  else if($aksi == 'caripemilik'){

    $pencarian = $_GET['pencarian'];
    $sql = "select st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) lat, pemilik.nama from pemilik where id_pemilik = $pencarian";
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $nama=$row['nama'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('nama'=>$nama,  'longitude'=>$longitude,'latitude'=>$latitude);
    }
    echo json_encode ($dataarray);


  }









?>
