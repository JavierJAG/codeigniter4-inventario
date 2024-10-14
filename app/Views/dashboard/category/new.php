<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Crear Nueva Categoría</h2>

<form action="<?= base_url('/dashboard/category') ?>" method="post">
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" value="<?= old('name') ?>">
    <?php if(session()->getFlashdata('errors')): ?>
        <p><?= session()->getFlashdata('errors')['name'] ?></p>
    <?php endif; ?>
    <button type="submit">Crear</button>
</form>


<a href="<?= base_url('/dashboard/category') ?>">Volver a la lista</a>
<?php $this->endSection() ?>