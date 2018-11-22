<?php
  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
  $id = null;
  $nama = null;
  $geom = null;
  $link = "/tb_bdl/view/admin/kabkot/";
  $aksi = null;
  $sql = null;

  if(isset($_POST['id_kabkot'])){
    $id = $_POST['id_kabkot'];
  }

  if(isset($_POST['nama'])){
    $nama = $_POST['nama'];
  }

  if(isset($_POST['geom'])){
    $geom = $_POST['geom'];
  }

  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }

  // die("ST_GeomFromText('MULTIPOLYGON($geom)')");

  if($aksi=="create" || $aksi=="update" || $aksi=="delete"){
    if($aksi=="create"){
      $sql = "INSERT into kabkota(nama, geom) values ('$nama', ST_GeomFromText('MULTIPOLYGON($geom)'))";
    }else if($aksi == "update" && isset($_POST['id_kabkot'])){
      $sql = "UPDATE kabkota SET nama='$nama', geom=ST_GeomFromText('MULTIPOLYGON($geom)') WHERE id_kabkot='$id'";
    }else if($aksi == "delete" && isset($_POST['id_kabkot'])){
      $sql = "DELETE from kabkota where id_kabkot=$id";
    }
    // die(var_dump(['<br>Link :'.$link.'<br>ID :'.$id.'<br>NAMA :'.$nama.'<br>GEOM :'.$geom.'<br>SQL :'.$sql.'<br>']));
    $eksekusi = pg_query($sql);

    if($eksekusi){

    }else{
      $link="";
      echo "eror";
    }

      header('location:'.$link);
  }


  if($aksi=="layerindex"){
    $sql = "select ST_asgeojson(geom) AS geometry, id_kabkot AS id,nama FROM kabkota";
    $layer = pg_query($sql);
       $hasil = array(
        	'type'	=> 'FeatureCollection',
        	'features' => array()
      	);
        while ($isinya = pg_fetch_assoc($layer)) {
          $features = array(
            'type' => 'Feature',
            'geometry' => json_decode($isinya['geometry']),
            'properties' => array(
              'id' => $isinya['id'],
              'nama' => $isinya['nama'],
             )
          );
          array_push($hasil['features'], $features);
        }

        echo json_encode($hasil);
  }

  if($aksi == 'detailpeta' && isset($_GET['id'])){
    $id = $_GET['id'];
    $sql = "SELECT row_to_json(fc) FROM (SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features FROM (SELECT 'Feature' As type , ST_AsGeoJSON(loc.geom)::json As geometry , row_to_json((SELECT l FROM (SELECT id_kabkot as id,nama, row_to_json((SELECT k FROM (SELECT ST_X(ST_CENTROID(geom)) AS lng, ST_Y(ST_CENTROID(geom)) AS lat) AS k)) AS center) As l )) As properties FROM kabkota As loc WHERE id_kabkot in ($id)) As f ) As fc";
    $eksekusi = pg_query($sql);
       while ($data = pg_fetch_assoc($eksekusi)) {
         $load=$data['row_to_json'];
         $tulis="loaddata(".$load.");";
       }
    echo $tulis;
  }


?>
