<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
  if($aksi=='tablef2'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $pencarian = date('d/m/Y', strtotime($pencarian));
      $sql = "SELECT distinct pemilik.id_pemilik, pemilik.nama, count(alat_tangkap.id_alat_tangkap) as jalat,pemilik.tgl_lahir, pemilik.agama, pemilik.pendidikan, kapal.nama as kapal, jenis_kapal.nama as jenis, count(keterangan_pelayaran_abk.id_pelayaran) as jabk FROM kepemilikan_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik left join kapal on kepemilikan_kapal.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join pelayaran on kapal.id_kapal = pelayaran.id_kapal left join keterangan_pelayaran_abk on pelayaran.id_pelayaran = keterangan_pelayaran_abk.id_pelayaran left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap where pelayaran.tanggal_keluar='$pencarian' group by pemilik.id_pemilik, kapal.nama, jenis_kapal.nama, alat_tangkap.id_alat_tangkap" ;
    }else{
      $sql = "SELECT distinct pemilik.id_pemilik, pemilik.nama, count(alat_tangkap.id_alat_tangkap) as jalat,pemilik.tgl_lahir, pemilik.agama, pemilik.pendidikan, kapal.nama as kapal, jenis_kapal.nama as jenis, count(keterangan_pelayaran_abk.id_pelayaran) as jabk FROM kepemilikan_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik left join kapal on kepemilikan_kapal.id_kapal = kapal.id_kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join pelayaran on kapal.id_kapal = pelayaran.id_kapal left join keterangan_pelayaran_abk on pelayaran.id_pelayaran = keterangan_pelayaran_abk.id_pelayaran left join alat_tangkap on alat_tangkap_kapal.id_alat_tangkap = alat_tangkap.id_alat_tangkap group by pemilik.id_pemilik, kapal.nama, jenis_kapal.nama, alat_tangkap.id_alat_tangkap";
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
