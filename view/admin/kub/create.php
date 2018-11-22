<?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/blank.php'; ?>
<?php startblock('title') ?> Create KUB <?php endblock() ?>
<?php startblock('breadcrumb-link') ?>
<li class="breadcrumb-item"><a href="#!">Kelompok Usaha Bersama</a>
<li class="breadcrumb-item"><a href="#!">Create</a>
<?php endblock() ?>
<?php startblock('breadcrumb-title') ?>
Create Kelompok Usaha Bersama
<?php endblock() ?>

<?php startblock('content') ?>
<div class="card">
    <div class="card-block">
        <form id="second" action="/tb_bdl/controller/kubcontroller.php?aksi=create" method="post" novalidate>
            <?php include $_SERVER['DOCUMENT_ROOT'].'/tb_bdl/view/admin/kub/_field.php'; ?>
            <div class="row">
                <div class="col-sm-12 text-center">
                    <button type="submit" class="btn btn-primary m-b-0">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<?php endblock() ?>
