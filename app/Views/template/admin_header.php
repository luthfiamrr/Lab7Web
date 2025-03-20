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
            <h1>Admin Controllers</h1>
        </header>
        <nav>
            <a href="<?= base_url('/admin'); ?>">Dashboard</a>
            <a href="<?= base_url('/admin/edit'); ?>">Edit Artikel</a>
            <a href="<?= base_url('/admin/add'); ?>">Tambah Artikel</a>
        </nav>
        <section id="wrapper">
            <section id="main">