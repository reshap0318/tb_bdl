<?php
  include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
  $id = null;
  $nama = null;
  $geom = null;
  $alamat = null;
  $deskripsi = null;
  $tgl_berdiri = null;
  $link = "/tb_bdl/view/admin/kub/";
  $aksi = null;
  $sql = null;

  if(isset($_POST['id_kub'])){
    $id = $_POST['id_kub'];
  }

  if(isset($_POST['nama'])){
    $nama = $_POST['nama'];
  }

  if(isset($_POST['geom'])){
    $geom = $_POST['geom'];
  }

  if(isset($_POST['alamat'])){
    $alamat = $_POST['alamat'];
  }

  if(isset($_POST['deskripsi'])){
    $deskripsi = $_POST['deskripsi'];
  }

  if(isset($_POST['tgl_berdiri'])){
    $tgl_berdiri = $_POST['tgl_berdiri'];
  }

  if(isset($_GET['aksi'])){
    $aksi = $_GET['aksi'];
  }
  die($tgl_berdiri);
  if($aksi=="create" || $aksi=="update" || $aksi=="delete"){
      if($aksi=="create"){
        $sql = "INSERT into kub(nama, alamat, deskripsi, tgl_berdiri, geom) values ('$nama', '$alamat', '$deskripsi', '$tgl_berdiri',ST_GeomFromText('MULTIPOLYGON($geom)'))";
      }else if($aksi == "update" && isset($_POST['id'])){
        $sql = "UPDATE kub SET nama='$nama', alamat='$alamat',deskripsi = '$deskripsi', tgl_berdiri = '$tgl_berdiri', geom=ST_GeomFromText('MULTIPOLYGON($geom)') WHERE id_kub='$id'";
      }else if($aksi == "delete" && isset($_POST['id'])){
        $sql = "DELETE from kub where id_kub='$id'";
      }
      // die(var_dump(['<br>Link :'.$link.'<br>ID :'.$id.'<br>NAMA :'.$nama.'<br>alamat :'.$alamat.'<br>deskripsi :'.$deskripsi.'<br>tgl :'.$tgl_berdiri.'<br>GEOM :'.$geom.'<br><br>SQL :'.$sql.'<br>']));
      $eksekusi = pg_query($sql);

      if($eksekusi){

      }else{
        $link="";
        echo "eror";
      }

        header('location:'.$link);
  }





?>
