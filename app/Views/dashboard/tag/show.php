<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Detalles de Etiqueta</h2>

<p>ID: <?= $tag->id ?></p>
<p>Nombre: <?= $tag->name ?></p>

<a href="<?= base_url('/dashboard/tag') ?>">Volver a la lista</a>
<?php $this->endSection() ?>