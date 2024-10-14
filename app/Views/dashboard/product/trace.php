<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>
<p>Compras y ventas de <?= $trace['product']->name ?></p>
<p>Precio: <?= $trace['product']->price ?></p>
<p>Última entrada: <?= $trace['product']->entry ?></p>
<p>Última salida <?= $trace['product']->exit ?></p>
<p>Filtro</p>
<form action="" method="get" id="form-filter">
    <select name="type">
        <option value="">Tipos</option>
        <option <?= ($trace['type'] == "entry" ? "selected" : "") ?> value="entry">Entrada</option>
        <option <?= ($trace['type'] == "exit" ? "selected" : "") ?> value="exit">Salida</option>
    </select>

    <select name="user_id">
        <option value="">Usuarios</option>
        <?php foreach ($trace['users'] as $key => $user) : ?>
            <option <?= ($user->id == $trace["user_id"]) ? "selected" : "" ?> value="<?= $user->id ?>"><?= $user->username ?></option>
        <?php endforeach ?>
    </select>
    <br>
    <h4>Búsqueda</h4>
    <input type="text" name="search" placeholder="Buscar" id="search" value="<?= $trace['search'] ?>">
    <a href="<?= base_url('/dashboard/product/trace/' . $trace['product']->id ) ?>">Limpiar</a>

    <h3>Cantidades</h3>
    <label for="check_cant">Activar
        <input type="checkbox" name="check_cant" id="check_cant" checked ?>>
    </label>
    <br>
    <label for="min_cant">Mínimo: <span><?= $trace['min_cant'] ? $trace['min_cant'] : 0 ?></span>
        <br>
        <input type="range" name="min_cant" id="min_cant" value="<?= $trace['min_cant'] ? $trace['min_cant'] : 0 ?>" min="0" max="90" step="1"></label>
    <br>
    <label for="max_cant">Máximo: <span><?= $trace['max_cant'] ? $trace['max_cant'] : 1000 ?></span>
        <br>
        <input type="range" name="max_cant" id="max_cant" value="<?= $trace['max_cant'] ? $trace['max_cant'] : 1000 ?>" min="10" max="1000" step="1"></label>
    <br>
    <button type="submit">Filtrar</button>
</form>

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