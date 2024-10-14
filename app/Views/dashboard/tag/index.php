<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<h2>Lista de Etiquetas</h2>

<a href="<?= base_url('/dashboard/tag/new') ?>">Crear Nueva Etiqueta</a>

<?php if(session()->getFlashdata('success')): ?>
    <p><?= session()->getFlashdata('success') ?></p>
<?php endif; ?>

<?php if(!empty($tags)): ?>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($tags as $tag): ?>
                <tr>
                    <td><?= $tag->id ?></td>
                    <td><?= $tag->name ?></td>
                    <td>
                        <a href="<?= base_url('/dashboard/tag/'.$tag->id .'/edit') ?>">Editar</a> |
                        <form action="<?= base_url('/dashboard/tag/'.$tag->id) ?>" method="post" style="display:inline;">
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