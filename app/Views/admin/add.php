<?= $this->include('template/admin_header'); ?>

<form action="" method="post" enctype="multipart/form-data">
    <h2><?= $title; ?></h2>

    <!-- Validasi Judul -->
    <p>
        <input type="text" name="judul" placeholder="Judul Artikel" value="<?= old('judul') ?>">
        <?php if (isset($errors['judul'])): ?>
            <span style="color:red; font-size:12px;"><?= $errors['judul'] ?></span>
        <?php endif; ?>
    </p>

    <!-- Validasi Kategori -->
    <p>
        <select name="kategori" id="kategoriSelect" onchange="toggleKategoriBaru()">
            <option value="">- Pilih Kategori -</option>
            <?php foreach ($kategori as $kat) : ?>
                <option value="<?= $kat['id_kategori'] ?>"
                    <?= old('kategori') == $kat['id_kategori'] ? 'selected' : '' ?>>
                    <?= $kat['nama_kategori'] ?>
                </option>
            <?php endforeach; ?>
            <option value="new" <?= old('kategori') === 'new' ? 'selected' : '' ?>>+ Buat Kategori Baru</option>
        </select>
        <?php if (isset($errors['kategori'])): ?>
            <span style="color:red; font-size:12px;"><?= $errors['kategori'] ?></span>
        <?php endif; ?>
    </p>

    <!-- Validasi Kategori Baru -->
    <p id="newKategoriContainer" style="<?= old('kategori') === 'new' ? '' : 'display:none;' ?>">
        <input type="text" name="kategori_baru" placeholder="Nama Kategori Baru" value="<?= old('kategori_baru') ?>">
        <?php if (isset($errors['kategori_baru'])): ?>
            <span style="color:red; font-size:12px;"><?= $errors['kategori_baru'] ?></span>
        <?php endif; ?>
    </p>

    <p>
        <textarea name="isi" cols="50" rows="7" placeholder="Isi Artikel"><?= old('isi') ?></textarea>
    </p>

    <p>
        <input type="file" name="gambar">
    </p>

    <p>
        <input type="submit" value="Kirim" class="btn-large">
    </p>
</form>

<script>
    function toggleKategoriBaru() {
        const select = document.getElementById('kategoriSelect');
        const container = document.getElementById('newKategoriContainer');

        if (select.value === 'new') {
            container.style.display = 'block';

        } else {
            container.style.display = 'none';
        }
    }
</script>

<?= $this->include('template/admin_footer'); ?>