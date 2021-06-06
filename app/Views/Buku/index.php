<?= $this->extend('layout/template') ?>

<?= $this->section('content') ?>
<div class="container">
    <div class="row">
        <div class="col">
            <a href="/Buku/tambah" class="btn btn-primary mt-3">Tambah Data Buku</a>
            <h3 class="my-2">Daftar Buku</h3>
            <?php if (session()->getFlashdata('pesan')) : ?>
                <div class="alert alert-success" role="alert">
                    <?= session()->getFlashdata('pesan'); ?>
                </div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('hapus')) : ?>
                <div class="alert alert-danger" role="alert">
                    <?= session()->getFlashdata('hapus'); ?>
                <?php endif; ?>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Sampul Buku</th>
                            <th scope="col">Judul Buku</th>
                            <th scope="col">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach ($buku as $b) : ?>
                            <tr>
                                <th scope="row"><?= $i++; ?></th>
                                <td><img src="/img/<?= $b['sampul']; ?>" alt="" class="sampul"></td>
                                <td><?= $b['judul']; ?></td>
                                <td>
                                    <a href="/buku/<?= $b['slug']; ?>" class="btn btn-success">Detail</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>