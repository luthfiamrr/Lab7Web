<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('style.css'); ?>">
</head>

<body>
    <div id="container">
        <header>
            <h1>Resume</h1>
        </header>
        <nav>
            <a href="<?= base_url('/page/home'); ?>">Home</a>
            <a href="<?= base_url('/page/artikel'); ?>">Artikel</a>
            <a href="<?= base_url('/page/about'); ?>">About</a>
            <a href="<?= base_url('/page/contact'); ?>">Contact</a>
        </nav>
        <section id="wrapper">
            <section id="main">
                <?= $this->renderSection('content') ?>
            </section>
            <aside id="sidebar">
                <?= view_cell('App\\Cells\\ArtikelTerkini::render') ?>
                <div class="widget-box">
                    <h3 class="title">Artikel Terkini</h3>
                    <?= $this->renderSection('content-sidebar') ?>
                </div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2021 - Universitas Pelita Bangsa</p>
        </footer>
    </div>
</body>

</html>