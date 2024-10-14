<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<p>Compras y ventas de <?= $trace['product']->name ?></p>
<p>Precio: <?= $trace['product']->price ?></p>
<p>Última entrada: <?= $trace['product']->entry ?></p>
<p>Última salida <?= $trace['product']->exit ?></p>


<table>
    <tr>
        <th>Id</th>
        <th>Creación</th>
        <th>Tipo</th>
        <th>Cantidad</th>
        <th>Precio</th>
        <th>Usuario</th>
        <th>Descripción</th>
        <th>Dirección</th>

    </tr>
    <?php $total = 0 ?>
    <?php foreach ($trace['trace'] as $key => $t) : ?>
        <tr>

            <td><?= $t->id ?></td>
            <td><?= $t->created_at ?></td>
            <td><?= $t->type ?></td>
            <td><?= $t->count ?></td>
            <td><?= $trace['product']->price ?></td>
            <td><?= $t->email ?></td>
            <td><?= $t->description ?></td>
            <td><?= $t->direction ?></td>

        </tr>
        <?php $total += $trace['product']->price ?>
    <?php endforeach ?>
    <tr>
        <td colspan="8">Total</td>
        <td><?= $total ?></td>
    </tr>
</table>

<script>
    formFilter = document.querySelector("#form-filter")
    min_cant = document.querySelector("[name=min_cant]")
    max_cant = document.querySelector("[name=max_cant]")
    for_min_cant = document.querySelector("[for=min_cant]")
    for_max_cant = document.querySelector("[for=max_cant]")
    check_cant = document.querySelector("[name=check_cant]")
    check_cant.addEventListener('change', function() {
        if (check_cant.checked) {
            for_min_cant.style.display = "inline-block"
            for_max_cant.style.display = "inline-block"
        } else {
            for_min_cant.style.display = "none"
            for_max_cant.style.display = "none"
        }
    })
    min_cant.addEventListener('change', function() {
        for_min_cant.querySelector("span").innerText = min_cant.value
    })
    max_cant.addEventListener('change', function() {
        for_max_cant.querySelector("span").innerText = max_cant.value
    })
    formFilter.addEventListener('submit', (event) => {
        event.preventDefault()
        if (parseInt(min_cant.value) > parseInt(max_cant.value)) {
            return alert("La cantidad máxima debe ser mayor o igual a la mínima")
        }
        formFilter.submit()
    })
</script>
<?php $this->endSection() ?>