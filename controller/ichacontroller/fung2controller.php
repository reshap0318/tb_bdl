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
      $sql = "select distinct kapal.id_kapal,jenis_kapal.nama as jenis_kapal, pemilik.nama as nama_pemilik, pemilik.id_pemilik, count(alat_tangkap.id_alat_tangkap) as jalat_tangkap, pelayaran.id_pelayaran as kode_pelayaran, pelayaran.tanggal_keluar, pelayaran.tanggal_masuk, pelabuhan.nama as pelabuhan, pelayaran.geom, pelabuhan.geom, kapal.nama as kapal from pelayaran left join kapal on pelayaran.id_kapal=kapal.id_kapal join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik=pemilik.id_pemilik  left join pelabuhan on pelayaran.id_pelabuhan = pelabuhan.id_pelabuhan where pemilik.id_pemilik in ($pencarian) group by kapal.id_kapal, jenis_kapal.nama, pemilik.nama, pemilik.id_pemilik, pelayaran.id_pelayaran, pelabuhan.id_pelabuhan" ;
    }else{
      $sql = "select distinct kapal.id_kapal,jenis_kapal.nama as jenis_kapal, pemilik.nama as nama_pemilik, pemilik.id_pemilik, count(alat_tangkap.id_alat_tangkap) as jalat_tangkap, pelayaran.id_pelayaran as kode_pelayaran, pelayaran.tanggal_keluar, pelayaran.tanggal_masuk, pelabuhan.nama as pelabuhan, pelayaran.geom, pelabuhan.geom, kapal.nama as kapal from pelayaran left join kapal on pelayaran.id_kapal=kapal.id_kapal join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik=pemilik.id_pemilik  left join pelabuhan on pelayaran.id_pelabuhan = pelabuhan.id_pelabuhan group by kapal.id_kapal, jenis_kapal.nama, pemilik.nama, pemilik.id_pemilik, pelayaran.id_pelayaran, pelabuhan.id_pelabuhan";
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




?>
