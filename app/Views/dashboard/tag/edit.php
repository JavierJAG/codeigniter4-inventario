<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Editar Etiqueta</h2>

<form action="<?= base_url('/dashboard/tag/'.$tag->id) ?>" method="post">
    <input type="hidden" name="_method" value="PUT">
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" value="<?= $tag->name ?>">
    <?php if(session()->getFlashdata('errors')): ?>
        <p><?= session()->getFlashdata('errors')['name'] ?></p>
    <?php endif; ?>
    <button type="submit">Actualizar</button>
</form>

<a href="<?= base_url('/dashboard/tag') ?>">Volver a la lista</a>
<?php $this->endSection() ?>
