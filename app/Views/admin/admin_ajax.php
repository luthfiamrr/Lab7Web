<?= $this->include('template/admin_header.php'); ?>

<form method="get" class="form-search">
    <input type="text" id="searchInput" name="q" placeholder="Cari data">
    <button type="button" id="searchBtn" class="btn btn-primary">Cari</button>
</form>

<table class="table" id="artikelTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>Kategori</th>
            <th>Tanggal</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script src="<?= base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        function showLoadingMessage() {
            $('#artikelTable tbody').html('<tr><td colspan="5">Memuat data...</td></tr>');
        }

        function loadData(q = '') {
            showLoadingMessage();

            $.ajax({
                url: "<?= base_url('admin/ajax/getData') ?>",
                method: "GET",
                data: {
                    q: q
                },
                dataType: "json",
                success: function(res) {
                    var data = res.data;
                    var tableBody = "";

                    if (data.length === 0) {
                        tableBody = '<tr><td colspan="5">Belum ada data.</td></tr>';
                    } else {
                        data.forEach(function(row) {
                            tableBody += '<tr>';
                            tableBody += '<td>' + row.id + '</td>';
                            tableBody += '<td><b>' + row.judul + '</b><p><small>' + row.isi.substring(0, 50) + '</small></p></td>';
                            tableBody += '<td style="text-align:center;"><b>' + row.nama_kategori + '</b></td>';
                            tableBody += '<td>' + row.tanggal + '</td>';
                            tableBody += '<td>';
                            tableBody += '<a class="btn" href="<?= base_url('/admin/edit/') ?>' + row.id + '">Ubah</a> ';
                            tableBody += '<a class="btn btn-danger btn-delete" href="#" data-id="' + row.id + '">Hapus</a>';
                            tableBody += '</td></tr>';
                        });
                    }

                    $('#artikelTable tbody').html(tableBody);
                }
            });
        }

        loadData();

        $('#searchBtn').on('click', function() {
            const q = $('#searchInput').val();
            loadData(q);
        });

        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (confirm('Yakin menghapus data ini?')) {
                $.ajax({
                    url: "<?= base_url('admin/ajax/delete/') ?>" + id,
                    method: "DELETE",
                    success: function() {
                        loadData($('#searchInput').val());
                    },
                    error: function() {
                        alert('Gagal menghapus data.');
                    }
                });
            }
        });
    });
</script>

<?= $this->include('template/admin_footer.php'); ?>