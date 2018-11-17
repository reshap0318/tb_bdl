<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>

<?php startblock('title') ?> Kabupaten Kota <?php endblock() ?>

<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Kabupaten Kota</a>
<?php endblock() ?>

<?php startblock('breadcrumb-title') ?>
Kabupaten Kota
<?php endblock() ?>

<?php startblock('content') ?>


<div class="card">
    <div class="card-block">
        <form method="post">
            <div class="input-group input-group-button">
                <input type="text" id="address" class="form-control" placeholder="Write your place">
                <span class="input-group-addon" id="basic-addon1">
                <button class="btn btn-primary">Search Location</button>
                </span>
            </div>
        </form>

        <div id="mapGeo"></div>
    </div>
</div>

<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/admin/kabkot/map.php'; ?>

    <a href="/tb_bdl/view/admin/kabkot/create.php" class="btn btn-out-dashed btn-info btn-square btn-block">Tambah Kabupaten Kota</a>
<?php endblock() ?>
