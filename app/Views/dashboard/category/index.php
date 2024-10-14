<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Lista de Categorías</h2>

<a href="<?= base_url('/dashboard/category/new') ?>">Crear Nueva Categoría</a>

<?php if(session()->getFlashdata('success')): ?>
    <p><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?php if(!empty($categories)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($categories as $category): ?>
                <tr>
                    <td><?= $category->id ?></td>
                    <td><?= $category->name ?></td>
                    <td>
                        <a href="<?= base_url('/dashboard/category/'.$category->id .'/edit') ?>">Editar</a> |
                        <form action="<?= base_url('/dashboard/category/'.$category->id) ?>" method="post" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay categorías disponibles.</p>
<?php endif; ?>

<?php $this->endSection() ?>