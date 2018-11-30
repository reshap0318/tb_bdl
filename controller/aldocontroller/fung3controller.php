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
      $sql = "select kub.id_kub, kub.nama, alamat, deskripsi, kub.tgl_berdiri, count(usaha_perikanan.*) as jumlahusaha, count(transaksi.*) as jumlahtransaksi, count(detail_transaksi.*) as jumlahproduksi from kub left join usaha_perikanan on kub.id_kub =usaha_perikanan.id_kub left join transaksi on kub.id_kub = transaksi.id_kub left join detail_transaksi on transaksi.id_transaksi = detail_transaksi.id_transaksi left join produksi on detail_transaksi.id_produksi = produksi.id_produksi where st_contains((select geom from kecamatan where id_kecamatan = $pencarian),st_astext(kub.geom)) group by kub.id_kub" ;
    }else{
      $sql = "select kub.id_kub, kub.nama, alamat, deskripsi, kub.tgl_berdiri, count(usaha_perikanan.*) as jumlahusaha, count(transaksi.*) as jumlahtransaksi, count(detail_transaksi.*) as jumlahproduksi from kub left join usaha_perikanan on kub.id_kub =usaha_perikanan.id_kub left join transaksi on kub.id_kub = transaksi.id_kub left join detail_transaksi on transaksi.id_transaksi = detail_transaksi.id_transaksi left join produksi on detail_transaksi.id_produksi = produksi.id_produksi group by kub.id_kub";
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
      $sql = "select *, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from kub where id_kub = $pencarian";
    }else{
      $sql = "select *, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat from kub";
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

  else if($aksi== 'detaillokasikub'){
    if(isset($_GET['pencarian'])){
      $pencarian = $_GET['pencarian'];
      $sql = "SELECT nama, alamat, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub where id_kub = $pencarian";
    }else{
      $sql = "SELECT nama, alamat, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.kub";
    }
    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $alamat=$row['alamat'];
          $nama=$row['nama'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('alamat'=>$alamat,'nama'=>$nama,'longitude'=>$longitude,'latitude'=>$latitude);
    }
  	echo json_encode($dataarray);
  }

  else if($aksi=='tabletransaksi'){
      $pencarian = $_GET['pencarian'];
      $sql = "Select distinct jenis_tangkapan.nama as ikan, berat, harga, tanggal from transaksi join detail_transaksi on transaksi.id_transaksi = detail_transaksi.id_transaksi join produksi on detail_transaksi.id_produksi = produksi.id_produksi join jenis_tangkapan on produksi.id_jenis_tangkapan = jenis_tangkapan.id_jenis_tangkapan where id_kub = $pencarian" ;
    $eksekusi = pg_query($sql);
    $data = array();
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;
  }

  else if($aksi=='tableusaha'){
      $pencarian = $_GET['pencarian'];
      $sql = "Select id_usaha, usaha_perikanan.nama_usaha,jenis_usaha.nama as jenis from usaha_perikanan join jenis_usaha on usaha_perikanan.id_jenisusaha = jenis_usaha.id_jenis_usaha  where id_kub = $pencarian" ;
    $eksekusi = pg_query($sql);
    $data = array();
    while ($perulangan = pg_fetch_assoc($eksekusi)) {
      array_push($data, $perulangan);
    }
    $mencoba = '{"data" : '.json_encode($data).'}';
    echo $mencoba;
  }

  else if($aksi== 'cariusaha'){
    $pencarian = $_GET['pencarian'];
    $sql = "SELECT nama_usaha, ST_asgeojson(geom) AS geometry, st_x(st_centroid(geom)) as lng, st_y(st_centroid(geom)) as lat FROM public.usaha_perikanan where id_kub = $pencarian";

    $eksekusi = pg_query($sql);
    while($row = pg_fetch_array($eksekusi))
    {
          $nama=$row['nama_usaha'];
          $longitude=$row['lng'];
          $latitude=$row['lat'];
          $dataarray[]=array('nama'=>$nama,'longitude'=>$longitude,'latitude'=>$latitude);
    }
  	echo json_encode($dataarray);
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

?>
