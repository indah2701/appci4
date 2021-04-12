<?= $this->extend('layout/template') ?>
<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col-8">
            <h2 class="my-3">Form Tambah Data Buku</h2>
            <!-- <form action="/buku/save" method="post"> -->
            <?php
            echo form_open('buku/save');
            ?>
            <!-- csrf cross side resource forgary manipulasi atau pemalsuan dari halaman lain -->
            <div class="form-group row my-3">
                <label for="judul" class="col-sm-2 col-form-label">Judul</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="judul" name="judul" autofocus>
                </div>
            </div>
            <div class="form-group row my-3">
                <label for="penulis" class="col-sm-2 col-form-label">Penulis</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="penulis" name="penulis">
                </div>
            </div>
            <div class="form-group row my-3">
                <label for="penerbit" class="col-sm-2 col-form-label">Penerbit</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="penerbit" name="penerbit">
                </div>
            </div>
            <div class="form-group row my-3">
                <label for="sampul" class="col-sm-2 col-form-label">Sampul</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="sampul" name="sampul">
                </div>
            </div>
            <div class="form-group row my-3">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Tambah Data</button>
                </div>
            </div>
            <?php echo form_close() ?>

        </div>
    </div>

</div>
<?= $this->endSection() ?>