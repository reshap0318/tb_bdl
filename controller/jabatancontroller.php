<?php
//ini wajib ada di dalam setiap controller
    include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
    //pendefinisian variable
    $aksi = $_GET['aksi'];
    $nama = null;
    $id = null;
    $sql = null;

    //untuk $_POST, tulisan post harus ukuran besar
    //pengisian variable
    if ( isset($_POST['nama'])){
      $nama = $_POST['nama'];
        if($nama==null){
          //masukan pesan jika nama kosong
          header('location:/tb_bdl/view/admin/jabatan/index.php');
        }
    }


    //mengisi variable id
    if( isset($_POST['id']) ){
      $id = $_POST['id'];
    }


//logika untuk mengarahkan apakah create, edit, delete
    if ($aksi == 'create') {
      $sql = "insert into jabatan(nama) values ('$nama')";
    }else if($aksi == 'update' && isset($_POST['id'])){
      $sql = "update jabatan set nama='$nama' where id_jabatan = '$id' ";
    }else if($aksi == 'delete' && isset($_POST['id'])){
      $sql = "delete from jabatan where id_jabatan = '$id'";
    }else{
      //masukan pesan gagal, karna link tidak ada
    }
    //masukan pesan berhasil

    var_dump([$aksi, $nama, $id, $sql]);
    $eksekusi = pg_query($sql);
    header('location:/tb_bdl/view/admin/jabatan/index.php');

?>
