<?= $this->include('template/admin_header.php'); ?>

<form method="get" class="form-search">
    <input type="text" id="searchInput" name="q" placeholder="Cari data">
    <button type="button" id="searchBtn" class="btn btn-primary">Cari</button>
</form>

<!-- Indikator loading -->
<div id="loadingIndicator" class="text-muted mt-2" style="display: none;">Memuat data...</div>

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

<!-- Pagination -->
<nav>
    <ul id="pagination" class="pagination mt-3"></ul>
</nav>

<script src="<?= base_url('assets/js/jquery-3.7.1.min.js') ?>"></script>
<script>
    $(document).ready(function() {
        function showLoadingMessage() {
            $('#artikelTable tbody').html('<tr><td colspan="5">Memuat data...</td></tr>');
        }

        function loadData(q = '', page = 1) {
            showLoadingMessage();

            $.ajax({
                url: "<?= base_url('admin/ajax') ?>",
                method: "GET",
                data: {
                    q: q,
                    page: page
                },
                dataType: "json",
                beforeSend: function() {
                    $('#loadingIndicator').show();
                },
                complete: function() {
                    $('#loadingIndicator').hide();
                },
                success: function(res) {
                    const data = res.data;
                    const currentPage = parseInt(res.page);
                    const totalPages = parseInt(res.totalPages);
                    let tableBody = '';

                    if (!data || data.length === 0) {
                        tableBody = '<tr><td colspan="5">Belum ada data.</td></tr>';
                    } else {
                        data.forEach(function(row) {
                            tableBody += `<tr>
                                <td>${row.id}</td>
                                <td><b>${row.judul}</b><p><small>${row.isi.substring(0, 50)}</small></p></td>
                                <td style="text-align:center;"><b>${row.nama_kategori}</b></td>
                                <td>${row.tanggal}</td>
                                <td>
                                    <a class="btn" href="<?= base_url('/admin/edit/') ?>${row.id}">Ubah</a>
                                    <a class="btn btn-danger btn-delete" href="#" data-id="${row.id}">Hapus</a>
                                </td>
                            </tr>`;
                        });
                    }

                    $('#artikelTable tbody').html(tableBody);

                    // Generate pagination
                    let paginationHTML = '';

                    if (currentPage > 1) {
                        paginationHTML += `
                            <li class="page-item">
                                <a href="#" class="page-link page-btn" data-page="${currentPage - 1}">«</a>
                            </li>`;
                    }

                    for (let i = 1; i <= totalPages; i++) {
                        paginationHTML += `
                            <li class="page-item ${i === currentPage ? 'active' : ''}">
                                <a href="#" class="page-link page-btn" data-page="${i}">${i}</a>
                            </li>`;
                    }

                    if (currentPage < totalPages) {
                        paginationHTML += `
                            <li class="page-item">
                                <a href="#" class="page-link page-btn" data-page="${currentPage + 1}">»</a>
                            </li>`;
                    }

                    $('#pagination').html(paginationHTML);
                }
            });
        }

        // Load awal
        loadData();

        // Tombol pencarian
        $('#searchBtn').on('click', function() {
            const q = $('#searchInput').val();
            loadData(q, 1);
        });

        // Klik pagination
        $(document).on('click', '.page-btn', function(e) {
            e.preventDefault();
            const page = $(this).data('page');
            const q = $('#searchInput').val();
            loadData(q, page);
        });

        // Hapus data
        $(document).on('click', '.btn-delete', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (confirm('Yakin menghapus data ini?')) {
                $.ajax({
                    url: "<?= base_url('admin/ajax/delete/') ?>" + id,
                    method: "DELETE",
                    success: function() {
                        const q = $('#searchInput').val();
                        loadData(q);
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