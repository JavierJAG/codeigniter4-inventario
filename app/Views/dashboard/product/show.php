<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Detalles de Producto</h2>

<p>ID: <?= $product->id ?></p>
<p>Nombre: <?= $product->name ?></p>

<a href="<?= base_url('/dashboard/product') ?>">Volver a la lista</a>
<?php $this->endSection() ?>