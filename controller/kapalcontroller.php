<?php
//ini wajib ada di dalam setiap controller
    include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/controller/koneksi.php';
    //pendefinisian variable
    $aksi = $_GET['aksi'];
    $id = null;
    $nama = null;
    $id_jenis_kapal = null;
    $tenda_selar = null;
    $mesin = null;
    $panjang = null;
    $berat_kotor = null;
    $link = "/tb_bdl/view/admin/kapal/";

    if( isset($_POST['id']) ){
      $id = $_POST['id'];
    }

    //untuk $_POST, tulisan post harus ukuran besar
    //pengisian variable
    if($aksi == 'create' || $aksi == 'update' || $aksi == 'delete'){
      if ( isset($_POST['nama']) || isset($_POST['id_jenis_kapal']) || isset($_POST['tenda_selar']) || isset($_POST['mesin']) || isset($_POST['panjang']) || isset($_POST['berat_kotor'])){
        $nama = $_POST['nama'];
        $id_jenis_kapal = $_POST['id_jenis_kapal'];
        $tenda_selar = $_POST['tenda_selar'];
        $mesin = $_POST['mesin'];
        $panjang = $_POST['panjang'];
        $berat_kotor = $_POST['berat_kotor'];
          if($nama==null || $id_jenis_kapal == null || $tenda_selar == null || $mesin == null || $panjang == null || $berat_kotor == null){
            //masukan pesan jika data kosong
            if($aksi=='create'){
              $link = $link.'create.php';
                // die($link);
            }else if($aksi=='update'){
              $link = $link.'update.php?id='.$id;
            }
          }
      }
      //mengisi variable id


      if ($aksi == 'create') {
        $sql = "INSERT INTO public.kapal(nama, id_jenis_kapal, tanda_selar, mesin, panjang, berat_kotor)VALUES ('$nama', '$id_jenis_kapal', '$tenda_selar', '$mesin', '$panjang', '$berat_kotor')";
      }else if($aksi == 'update' && isset($_POST['id'])){
        $sql = "UPDATE public.kapal SET nama='$nama', id_jenis_kapal='$id_jenis_kapal', tanda_selar='$tenda_selar', mesin='$mesin', panjang=$panjang, berat_kotor='$berat_kotor' where id_kapal='$id'";
      }else if($aksi == 'delete' && isset($_POST['id'])){
        $sql = "DELETE FROM public.kapal WHERE id_kapal='$id'";
      }else{
        //masukan pesan gagal, karna link tidak ada
      }
      //masukan pesan berhasil

      // die(var_dump(['</br>aksi :'.$aksi.'</br>nama : '.$nama.'</br>ID : '.$id.'</br>SQL : '.$sql.'</br>id_jenis: '.$id_jenis_kapal.'</br>Tenda Selar : '.$tenda_selar.'</br>MEsin : '.$mesin.'</br>panjang : '.$panjang.'</br>berat : '.$berat_kotor.'</br>ajax: ']));

      $eksekusi = pg_query($sql);
      header('location:'.$link);

    }


//logika untuk ajak table
    if($aksi = 'table'){
      $sql = "SELECT kapal.id_kapal, kapal.nama as namakapal, count(abk.id_abk) as jabk, count(alat_tangkap_kapal.id_kapal) jalat,jenis_kapal.nama as jenis, tanda_selar, mesin, panjang, berat_kotor, pemilik.nama as pemilik FROM public.kapal left join jenis_kapal on kapal.id_jenis_kapal = jenis_kapal.id_jenis_kapal left join abk on kapal.id_kapal = abk.id_kapal left join alat_tangkap_kapal on kapal.id_kapal = alat_tangkap_kapal.id_kapal left join kepemilikan_kapal on kapal.id_kapal = kepemilikan_kapal.id_kapal left join pemilik on kepemilikan_kapal.id_pemilik = pemilik.id_pemilik group by kapal.id_kapal, jenis, alat_tangkap_kapal.id_kapal, pemilik.nama";
      $eksekusi = pg_query($sql);
      $data = array();
      $no = 0;
      while ($perulangan = pg_fetch_assoc($eksekusi)) {
        // $data[] = array(
        //   'id_kapal' => $perulangan['id_kapal'],
        //   'namakapal' => $perulangan['namakapal'],
        //   'jabk' => $perulangan['jabk'],
        //   'jalat' => $perulangan['jalat'],
        //   'jenis' => $perulangan['jenis'],
        //   'tanda_selar' => $perulangan['tanda_selar'],
        //   'mesin' => $perulangan['mesin'],
        //   'panjang' => $perulangan['panjang'],
        //   'pemilik' => $perulangan['pemilik'],
        //   'berat_kotor' => $perulangan['berat_kotor']
        // );
        array_push($data, $perulangan);
      }
      $mencoba = '{"data" : '.json_encode($data).'}';
      echo $mencoba;
    }

// header('location:/tb_bdl/view/admin/kapal/index.php');

?>
