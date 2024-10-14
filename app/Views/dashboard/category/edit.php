<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Editar Categoría</h2>

<form action="<?= base_url('/dashboard/category/'.$category->id) ?>" method="post">
    <input type="hidden" name="_method" value="PUT">
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" value="<?= $category->name ?>">
    <?php if(session()->getFlashdata('errors')): ?>
        <p><?= session()->getFlashdata('errors')['name'] ?></p>
    <?php endif; ?>
    <button type="submit">Actualizar</button>
</form>

<a href="<?= base_url('category') ?>">Volver a la lista</a>
<?php $this->endSection() ?>
