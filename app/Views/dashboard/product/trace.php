<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>



<h1 class="text-center">Compras y ventas de <?= $trace['product']->name ?></h1>
<hr>
<div class="card mb-2" style="max-width:200px;">
    <div class="card-header">Características</div>

    <ul class="list-group list-group-flush">
        <li class="list-group-item">Precio: <?= $trace['product']->price ?></li>
        <li class="list-group-item">Última entrada: <?= $trace['product']->entry ?></li>
        <li class="list-group-item">Última salida <?= $trace['product']->exit ?></li>
    </ul>
</div>
<div class="card">
    <div class="card-body">
        <p>Filtro</p>
        <div class="row">
            <div class="col">

                <form action="" method="get" id="form-filter">
                    <select class="form-control" name="type">
                        <option value="">Tipos</option>
                        <option <?= ($trace['type'] == "entry" ? "selected" : "") ?> value="entry">Entrada</option>
                        <option <?= ($trace['type'] == "exit" ? "selected" : "") ?> value="exit">Salida</option>
                    </select>
            </div>
            <div class="col">

                <select class="form-control" name="user_id">
                    <option value="">Usuarios</option>
                    <?php foreach ($trace['users'] as $key => $user) : ?>
                        <option <?= ($user->id == $trace["user_id"]) ? "selected" : "" ?> value="<?= $user->id ?>"><?= $user->username ?></option>
                    <?php endforeach ?>
                </select>

            </div>
        </div>

    </div>

    <div class="card-body border-bottom">
        <h4>Búsqueda</h4>
        <input class="form-control" type="text" name="search" placeholder="Buscar" id="search" value="<?= $trace['search'] ?>">
    </div>
    <div class="card-body">
        <h3>Cantidades</h3>
        <label class="d-block" for="check_cant">Activar
            <input type="checkbox" name="check_cant" id="check_cant" checked ?>
        </label>
        <label class="d-block" for="min_cant">Mínimo: <span><?= $trace['min_cant'] ? $trace['min_cant'] : 0 ?></span>

            <input type="range" name="min_cant" id="min_cant" value="<?= $trace['min_cant'] ? $trace['min_cant'] : 0 ?>" min="0" max="90" step="1"></label>
        <label class="d-block" for="max_cant">Máximo: <span><?= $trace['max_cant'] ? $trace['max_cant'] : 1000 ?></span>

            <input type="range" name="max_cant" id="max_cant" value="<?= $trace['max_cant'] ? $trace['max_cant'] : 1000 ?>" min="10" max="1000" step="1"></label>
    </div>
    <div class="card-footer">
        <a class="float-end btn btn-secondary sm mt-1" href="<?= base_url('/dashboard/product/trace/' . $trace['product']->id) ?>">Limpiar</a>
        <button class="btn btn-success sm mt-1" type="submit">Filtrar</button>


        </form>
    </div>
    <div class="card-body">
        <table class="table mt-3">
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
                <td colspan="8"><span class="fw-bold">Total</span></td>
                <td><span class="fw-bold text-success"><?= $total ?></span></td>
            </tr>
        </table>
    </div>
</div>
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