<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Detalles de Categoría</h2>

<p>ID: <?= $category->id ?></p>
<p>Nombre: <?= $category->name ?></p>

<a href="<?= base_url('/dashboard/category') ?>">Volver a la lista</a>
<?php $this->endSection() ?>