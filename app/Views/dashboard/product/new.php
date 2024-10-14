<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<div class="card">
    <div class="card-header">
        <h2>Crear Nuevo Producto</h2>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/dashboard/product') ?>" method="post">
            <!-- Campo Nombre -->
            <label class="mt-2" for="name">Nombre:</label>
            <input class="form-control" type="text" name="name" id="name" value="<?= old('name') ?>">

            <!-- Verifica que existan errores antes de intentar acceder a ellos -->
            <?php if ($errors = session()->getFlashdata('errors')): ?>
                <?php if (isset($errors['name'])): ?>
                    <p><?= $errors['name'] ?></p>
                <?php endif; ?>
            <?php endif; ?>

            <!-- Campo Código -->
            <label class="mt-2" for="code">Código:</label>
            <input class="form-control" type="text" name="code" id="code" value="<?= old('code') ?>">

            <?php if (isset($errors['code'])): ?>
                <p><?= $errors['code'] ?></p>
            <?php endif; ?>

            <!-- Campo Descripción -->
            <label class="mt-2" for="description">Descripción:</label>
            <textarea class="form-control" name="description" id="description"><?= old('description') ?></textarea>

            <?php if (isset($errors['description'])): ?>
                <p><?= $errors['description'] ?></p>
            <?php endif; ?>

            <!-- Campo Entrada -->
            <label class="mt-2" for="entry">Entrada:</label>
            <input class="form-control" type="number" name="entry" id="entry" value="<?= old('entry') ?>">

            <?php if (isset($errors['entry'])): ?>
                <p><?= $errors['entry'] ?></p>
            <?php endif; ?>

            <!-- Campo Salida -->
            <label class="mt-2" for="exit">Salida:</label>
            <input class="form-control" type="number" name="exit" id="exit" value="<?= old('exit') ?>">

            <?php if (isset($errors['exit'])): ?>
                <p><?= $errors['exit'] ?></p>
            <?php endif; ?>

            <!-- Campo Stock -->
            <label class="mt-2" for="stock">Stock:</label>
            <input class="form-control" type="number" name="stock" id="stock" value="<?= old('stock') ?>">

            <?php if (isset($errors['stock'])): ?>
                <p><?= $errors['stock'] ?></p>
            <?php endif; ?>

            <!-- Campo Precio -->
            <label class="mt-2" for="price">Precio:</label>
            <input class="form-control" type="text" name="price" id="price" value="<?= old('price') ?>">

            <?php if (isset($errors['price'])): ?>
                <p><?= $errors['price'] ?></p>
            <?php endif; ?>

            <label for="category_id">Categorias:</label>
            <select class="form-control" name="category_id" id="category_id">
                <?php foreach ($categories as $c) : ?>
                    <option value="<?= $c->id ?>"><?= $c->name ?></option>
                <?php endforeach ?>
            </select>

            <label for="tag_id">Tags:</label>
            <select class="form-control" multiple name="tag_id[]" id="tag_id">
                <?php foreach ($tags as $t) : ?>
                    <option value="<?= $t->id ?>"><?= $t->name ?></option>
                <?php endforeach ?>
            </select>


            <!-- Botón para enviar el formulario -->
            <button class="btn btn-sm btn-success mt-1" type="submit">Crear</button>
        </form>

        <!-- Enlace para volver a la lista -->
        <a href="<?= base_url('/dashboard/product') ?>">Volver a la lista</a>
    </div>
</div>
<?php $this->endSection() ?>