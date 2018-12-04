<?php
include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';

  $pencarian = null;
  $aksi = null;
  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
  if($aksi=='tablef3'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT distinct kub.id_kub, kub.nama as kub, kub.alamat, kub.deskripsi, kub.tgl_berdiri, count(transaksi.id_transaksi) as jtransaksi, count(usaha_perikanan.*) as jusaha FROM public.kub left join usaha_perikanan on kub.id_kub = usaha_perikanan.id_kub left join transaksi on usaha_perikanan.id_kub = transaksi.id_kub left join detail_transaksi on transaksi.id_transaksi = detail_transaksi.id_transaksi left join produksi on detail_transaksi.id_produksi = produksi.id_produksi left join pelayaran on produksi.id_pelayaran = pelayaran.id_pelayaran left join pelabuhan on pelayaran.id_pelayaran = pelabuhan.id_pelabuhan where pelabuhan.id_pelabuhan in ($pencarian) group by kub.id_kub, transaksi.harga, pelayaran.id_pelayaran, pelabuhan.nama" ;
    }else{
      $sql = "SELECT distinct kub.id_kub, kub.nama as kub, kub.alamat, kub.deskripsi, kub.tgl_berdiri, count(transaksi.id_transaksi) as jtransaksi, count(usaha_perikanan.*) as jusaha FROM public.kub left join usaha_perikanan on kub.id_kub = usaha_perikanan.id_kub left join transaksi on usaha_perikanan.id_kub = transaksi.id_kub left join detail_transaksi on transaksi.id_transaksi = detail_transaksi.id_transaksi left join produksi on detail_transaksi.id_produksi = produksi.id_produksi left join pelayaran on produksi.id_pelayaran = pelayaran.id_pelayaran left join pelabuhan on pelayaran.id_pelayaran = pelabuhan.id_pelabuhan group by kub.id_kub, transaksi.harga, pelayaran.id_pelayaran, pelabuhan.nama";
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
      $sql = "SELECT id_kub, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub where id_kub = $pencarian";
    }else{
      $sql = "SELECT id_kub, nama, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub";
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
