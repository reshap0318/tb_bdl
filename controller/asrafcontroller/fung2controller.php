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
      $sql = "SELECT distinct kapal.nama as nama_kapal, pelayaran.id_pelayaran, kapal.tanda_selar, kapal.mesin, kapal.panjang as panjang_kapal, kapal.berat_kotor ,pelayaran.tujuan, produksi.nilai_produksi,sum(transaksi.harga) as harga, kub.nama as nama_kub ,  usaha_perikanan.nama_usaha FROM public.kapal left join pelayaran on kapal.id_kapal=pelayaran.id_kapal left join produksi on pelayaran.id_pelayaran=produksi.id_pelayaran left join detail_transaksi on produksi.id_produksi=detail_transaksi.id_produksi left join transaksi on detail_transaksi.id_transaksi=transaksi.id_transaksi left join kub on transaksi.id_kub=kub.id_kub left join usaha_perikanan on kub.id_kub=usaha_perikanan.id_kub where usaha_perikanan.id_usaha=$pencarian group by kapal.id_kapal, pelayaran.id_pelayaran, produksi.id_produksi, kub.id_kub, usaha_perikanan.id_usaha" ;
    }else{
      $sql = "SELECT distinct kapal.nama as nama_kapal, pelayaran.id_pelayaran, kapal.tanda_selar, kapal.mesin, kapal.panjang as panjang_kapal, kapal.berat_kotor ,pelayaran.tujuan, produksi.nilai_produksi,sum(transaksi.harga) as harga, kub.nama as nama_kub ,  usaha_perikanan.nama_usaha FROM public.kapal left join pelayaran on kapal.id_kapal=pelayaran.id_kapal left join produksi on pelayaran.id_pelayaran=produksi.id_pelayaran left join detail_transaksi on produksi.id_produksi=detail_transaksi.id_produksi left join transaksi on detail_transaksi.id_transaksi=transaksi.id_transaksi left join kub on transaksi.id_kub=kub.id_kub left join usaha_perikanan on kub.id_kub=usaha_perikanan.id_kub group by kapal.id_kapal, pelayaran.id_pelayaran, produksi.id_produksi, kub.id_kub, usaha_perikanan.id_usaha ";
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
    $sql = "Select *, kapal.nama as namakapal, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from pelayaran left join kapal on pelayaran.id_kapal = kapal.id_kapal where id_pelayaran = $pencarian";
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $id=$row['id_pelayaran'];
          $nama=$row['namakapal'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('id'=>$id, 'nama'=>$nama, 'longitude'=>$longitude,'latitude'=>$latitude);
    }
    echo json_encode ($dataarray);
  }




?>
