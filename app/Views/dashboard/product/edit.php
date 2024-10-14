<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<div class="card">
    <div class="card-header">
        <h2>Editar Producto</h2>
    </div>
    <div class="card-body">
        <!-- Formulario para editar el producto -->
        <form action="<?= base_url('/dashboard/product/' . $product->id) ?>" method="post">
            <input type="hidden" name="_method" value="PUT"> <!-- Para indicar que es una actualización -->

            <!-- Campo Nombre -->
            <label class="mt-2" for="name">Nombre:</label>
            <input type="text" class="form-control" name="name" id="name" value="<?= old('name', $product->name) ?>">
            <?php
            $errors = session()->getFlashdata('errors'); // Guardar errores en una variable
            if (isset($errors['name'])): ?> <!-- Verificar si 'name' existe en el array de errores -->
                <p><?= $errors['name'] ?></p>
            <?php endif; ?>

            <!-- Campo Código -->
            <label class="mt-2" for="code">Código:</label>
            <input type="text" class="form-control" name="code" id="code" value="<?= old('code', $product->code) ?>">
            <?php if (isset($errors['code'])): ?> <!-- Verificar si 'code' existe en el array de errores -->
                <p><?= $errors['code'] ?></p>
            <?php endif; ?>

            <!-- Campo Descripción -->
            <label class="mt-2" for="description">Descripción:</label>
            <textarea class="form-control" name="description" id="description"><?= old('description', $product->description) ?></textarea>
            <?php if (isset($errors['description'])): ?> <!-- Verificar si 'description' existe en el array de errores -->
                <p><?= $errors['description'] ?></p>
            <?php endif; ?>

            <!-- Campo Entrada -->
            <label class="mt-2" for="entry">Entrada:</label>
            <input class="form-control" type="number" name="entry" id="entry" value="<?= old('entry', $product->entry) ?>">
            <?php if (isset($errors['entry'])): ?> <!-- Verificar si 'entry' existe en el array de errores -->
                <p><?= $errors['entry'] ?></p>
            <?php endif; ?>

            <!-- Campo Salida -->
            <label class="mt-2" for="exit">Salida:</label>
            <input class="form-control" type="number" name="exit" id="exit" value="<?= old('exit', $product->exit) ?>">
            <?php if (isset($errors['exit'])): ?> <!-- Verificar si 'exit' existe en el array de errores -->
                <p><?= $errors['exit'] ?></p>
            <?php endif; ?>

            <!-- Campo Stock -->
            <label class="mt-2" for="stock">Stock:</label>
            <input class="form-control" type="number" name="stock" id="stock" value="<?= old('stock', $product->stock) ?>">
            <?php if (isset($errors['stock'])): ?> <!-- Verificar si 'stock' existe en el array de errores -->
                <p><?= $errors['stock'] ?></p>
            <?php endif; ?>

            <!-- Campo Precio -->
            <label class="mt-2" or="price">Precio:</label>
            <input type="text" class="form-control" name="price" id="price" value="<?= old('price', $product->price) ?>">
            <?php if (isset($errors['price'])): ?> <!-- Verificar si 'price' existe en el array de errores -->
                <p><?= $errors['price'] ?></p>
            <?php endif; ?>

            <label class="mt-2" for="category_id">Categorias:</label>
            <select class="form-control" name="category_id" id="category_id">
                <?php foreach ($categories as $c) : ?>
                    <option <?= $product->category_id == $c->id ? 'selected' : '' ?> value="<?= $c->id ?>"><?= $c->name ?></option>
                <?php endforeach ?>
            </select>

            <label class="mt-2" for="tag_id">Tags:</label>
            <select class="form-control" multiple name="tag_id[]" id="tag_id">
                <?php foreach ($tags as $t) : ?>
                    <option <?= in_array($t->id, old('tag_id', $productTags)) ? 'selected' : '' ?> value="<?= $t->id ?>"><?= $t->name ?></option>
                <?php endforeach ?>
            </select>

            <button class="btn btn-sm btn-success mt-1" type="submit">Actualizar</button>
        </form>

        <!-- Enlace para volver a la lista -->
        <a href="<?= base_url('/dashboard/product') ?>">Volver a la lista</a>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#description'))
        .catch(error => {
            console.error(error);
        });
</script>

<?php $this->endSection() ?>