<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>

<h2>Editar Producto</h2>

<!-- Formulario para editar el producto -->
<form action="<?= base_url('/dashboard/product/' . $product->id) ?>" method="post">
    <input type="hidden" name="_method" value="PUT"> <!-- Para indicar que es una actualización -->

    <!-- Campo Nombre -->
    <label for="name">Nombre:</label>
    <input type="text" name="name" id="name" value="<?= old('name', $product->name) ?>">
    <?php
    $errors = session()->getFlashdata('errors'); // Guardar errores en una variable
    if (isset($errors['name'])): ?> <!-- Verificar si 'name' existe en el array de errores -->
        <p><?= $errors['name'] ?></p>
    <?php endif; ?>

    <!-- Campo Código -->
    <label for="code">Código:</label>
    <input type="text" name="code" id="code" value="<?= old('code', $product->code) ?>">
    <?php if (isset($errors['code'])): ?> <!-- Verificar si 'code' existe en el array de errores -->
        <p><?= $errors['code'] ?></p>
    <?php endif; ?>

    <!-- Campo Descripción -->
    <label for="description">Descripción:</label>
    <textarea name="description" id="description"><?= old('description', $product->description) ?></textarea>
    <?php if (isset($errors['description'])): ?> <!-- Verificar si 'description' existe en el array de errores -->
        <p><?= $errors['description'] ?></p>
    <?php endif; ?>

    <!-- Campo Entrada -->
    <label for="entry">Entrada:</label>
    <input type="number" name="entry" id="entry" value="<?= old('entry', $product->entry) ?>">
    <?php if (isset($errors['entry'])): ?> <!-- Verificar si 'entry' existe en el array de errores -->
        <p><?= $errors['entry'] ?></p>
    <?php endif; ?>

    <!-- Campo Salida -->
    <label for="exit">Salida:</label>
    <input type="number" name="exit" id="exit" value="<?= old('exit', $product->exit) ?>">
    <?php if (isset($errors['exit'])): ?> <!-- Verificar si 'exit' existe en el array de errores -->
        <p><?= $errors['exit'] ?></p>
    <?php endif; ?>

    <!-- Campo Stock -->
    <label for="stock">Stock:</label>
    <input type="number" name="stock" id="stock" value="<?= old('stock', $product->stock) ?>">
    <?php if (isset($errors['stock'])): ?> <!-- Verificar si 'stock' existe en el array de errores -->
        <p><?= $errors['stock'] ?></p>
    <?php endif; ?>

    <!-- Campo Precio -->
    <label for="price">Precio:</label>
    <input type="text" name="price" id="price" value="<?= old('price', $product->price) ?>">
    <?php if (isset($errors['price'])): ?> <!-- Verificar si 'price' existe en el array de errores -->
        <p><?= $errors['price'] ?></p>
    <?php endif; ?>

    <label for="category_id">Categorias:</label>
    <select name="category_id" id="category_id">
        <?php foreach ($categories as $c) : ?>
            <option <?= $product->category_id == $c->id ? 'selected' : '' ?> value="<?= $c->id ?>"><?= $c->name ?></option>
        <?php endforeach ?>
    </select>

    <label for="tag_id">Tags:</label>
    <select multiple name="tag_id[]" id="tag_id">
        <?php foreach ($tags as $t) : ?>
            <option <?= in_array($t->id, old('tag_id',$productTags)) ? 'selected' : '' ?> value="<?= $t->id ?>"><?= $t->name ?></option>
        <?php endforeach ?>
    </select>

    <button type="submit">Actualizar</button>
</form>

<!-- Enlace para volver a la lista -->
<a href="<?= base_url('/dashboard/product') ?>">Volver a la lista</a>
<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>

<?php $this->endSection() ?>