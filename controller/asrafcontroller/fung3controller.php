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
      $sql = "SELECT kapal.nama as nama_kapal, pelayaran.tujuan, kub.id_kub as id_kub , kub.nama as nama, kub.tgl_berdiri, kub.alamat, jenis_tangkapan.nama as nama_jenis FROM public.kapal left join pelayaran on kapal.id_kapal=pelayaran.id_kapal left join produksi on pelayaran.id_pelayaran=produksi.id_pelayaran left join jenis_tangkapan on produksi.id_jenis_tangkapan=jenis_tangkapan.id_jenis_tangkapan left join detail_transaksi on produksi.id_produksi=detail_transaksi.id_produksi left join transaksi on detail_transaksi.id_transaksi=transaksi.id_transaksi left join kub on transaksi.id_kub=kub.id_kub where kub.id_kub=$pencarian";
    }else{
      $sql = "SELECT kapal.nama as nama_kapal, pelayaran.tujuan, kub.id_kub as id_kub , kub.nama as nama, kub.tgl_berdiri, kub.alamat, jenis_tangkapan.nama as nama_jenis FROM public.kapal left join pelayaran on kapal.id_kapal=pelayaran.id_kapal left join produksi on pelayaran.id_pelayaran=produksi.id_pelayaran left join jenis_tangkapan on produksi.id_jenis_tangkapan=jenis_tangkapan.id_jenis_tangkapan left join detail_transaksi on produksi.id_produksi=detail_transaksi.id_produksi left join transaksi on detail_transaksi.id_transaksi=transaksi.id_transaksi left join kub on transaksi.id_kub=kub.id_kub";
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
      $sql = "SELECT id_kub, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub where id_kub = $pencarian";
    }else{
      $sql = "SELECT id_kub, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub";
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
          'id' => $data['id_kub'],
          'nama' => $data['nama'],
          'lon' => $data['lng'],
          'lat' => $data['lat'],
         )
      );
      array_push($hasil['features'], $features);
  	}
  	echo json_encode($hasil);


  }
  else if($aksi== 'kub'){


    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT id_kub, nama,  ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub where id_kub = $pencarian";
    }else{
      $sql = "SELECT id_kub, nama,  ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub";
    }
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_kub'];
          $nama=$row['nama'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id,'nama'=>$nama,'longitude'=>$longitude,'latitude'=>$latitude);
    }
  	echo json_encode($dataarray);
  }




?>
