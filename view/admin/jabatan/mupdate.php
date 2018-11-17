<!-- Modal static-->
<form class="" action="/tb_bdl/controller/jabatancontroller.php?aksi=update" method="POST">
  <div class="modal fade" id="jabatan-model-edit" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambahkan Jabatan</h4>
            </div>
            <div class="modal-body">
              <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1"><i class="icofont icofont-king-crown"></i></span>
                  <input type="text" name="nama" id="edit_nama" value="" class="form-control" placeholder="Ex : Ketua">
                  <input type="hidden" name="id" id="edit_id" value="" class="form-control" placeholder="Ex : Ketua">
              </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect " data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary waves-effect waves-light ">Save changes</button>
            </div>
        </div>
    </div>
  </div>
</form>
