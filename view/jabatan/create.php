<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>
<?php startblock('title') ?> Jabatan <?php endblock() ?>
<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Jabatan</a>
<li class="breadcrumb-item"><a href="#!">Create</a>
<?php endblock() ?>
<?php startblock('breadcrumb-title') ?>
Jabatan
<?php endblock() ?>

<?php startblock('content') ?>
<div class="card">
  <div class="card-block">
      <div class="j-wrapper j-wrapper-680">
          <form action="https://colorlib.com//polygon/adminty/default/j-pro/php/action.php" method="post" class="j-pro" id="j-pro" novalidate>
              <div class="j-content">
                  <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/jabatan/_field.php'; ?>
              </div>
              <!-- end /.content -->
              <div class="j-footer text-center">
                  <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
              <!-- end /.footer -->
          </form>
      </div>
  </div>
</div>
<?php endblock() ?>
