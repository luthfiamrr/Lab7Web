<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>

<article class="entry">
    <h1><?= $title; ?></h1>
    <hr>
    <img src="<?= base_url('gambar/' . $artikel['gambar']); ?>" alt="<?= esc($artikel['judul']); ?>" style="max-width:50%; margin-top:10px; height:auto; margin-bottom: 20px;">
    <p><?= $artikel['isi']; ?></p>
</article>

<?= $this->endSection() ?>