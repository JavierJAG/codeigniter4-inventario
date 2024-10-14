<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>

<div class="card">
    <div class="card-header">
        <button class="btn btn-sm btn-flat float-end" data-bs-toggle="collapse" data-bs-target="#filters">Filtros</button>
        <h4>Filtros</h4>
    </div>
    <div class="card-body">
        <a class="btn btn-primary mt-3" href="<?= base_url('/dashboard/product/new') ?>">Crear</a>
        <div class="card-body collapse" id="filters">

            <form action="" method="get">
                <label for="categoria_id">Categorías</label>
                <select class="form-control" name="category_id" id="categoria_id">
                    <?php foreach ($categories as $c) : ?>
                        <option <?= ($c->id == $category_id) ? 'selected' : '' ?> value="<?= $c->id ?>"><?= $c->name ?></option>
                    <?php endforeach ?>
                </select>
                <div class="overflow-auto" style="max-height:132px">
                    <ul class="list-group mt-2">
                        <?php foreach ($tags as $tag): ?>

                            <li class="list-group-item"><label for="t_id" <?= $tag->id ?>><?= $tag->name ?></label>

                                <input type="checkbox" name="tags_id[]" id="t_id" <?= in_array($tag->id, $productTags) ? 'checked' : '' ?> value="<?= $tag->id ?>">
                            </li>

                        <?php endforeach; ?>
                    </ul>
                </div>

                <button class="btn btn-success mb-1" type="submit">Enviar</button>
            </form>
            <a class="btn btn-secondary" href="<?= base_url('/dashboard/product/') ?>">Limpiar</a>
        </div>
        <?php if (!empty($products)): ?>

            <h2>Lista de Productos</h2>
            <div class="modal" tabindex="-1" id="blockSelectUser">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Gestión ventas</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <select class="form-control user">
                                <?php foreach ($users as $key => $user) : ?>
                                    <option value="<?= $user->id ?>"><?= $user->username ?></option>
                                <?php endforeach ?>
                            </select>
                            <textarea name="description" class="description form-control mt-2" placeholder="Descripción"></textarea>
                            <textarea name="direction" class="direction form-control mt-2" placeholder="Dirección"></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="sendUser">Enviar</button>
                        </div>
                    </div>
                </div>
            </div>



            <table class="table mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Entrada</th>
                        <th>Salida</th>
                        <th>Stock</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= $product->id ?></td>
                            <td><?= $product->name ?></td>
                            <td><?= $product->code ?></td>
                            <td><?= $product->description ?></td>
                            <td> <input type="number" data-id="<?= $product->id ?>" class="entry form-control"></td>
                            <td> <input type="number" data-id="<?= $product->id ?>" class="exit form-control"></td>
                            <td id="stock_<?= $product->id ?>"><?= $product->stock ?></td>
                            <td><?= $product->price ?></td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="<?= base_url('/dashboard/product/' . $product->id . '/edit') ?>">Editar</a>
                                <a class="btn btn-sm btn-secondary" href="<?= base_url('/dashboard/product/trace/' . $product->id) ?>">Traza</a>
                                <form action="<?= base_url('/dashboard/product/' . $product->id) ?>" method="post" style="display:inline;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button class="btn btn-sm btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay productos disponibles.</p>
        <?php endif; ?>
    </div>
</div>



<script>
    var modal = new bootstrap.Modal(document.getElementById('blockSelectUser'));
    var typeUser = "customer";
    var userExit = [];
    var userEntry = [];
    var blockSelectUser = document.querySelector("#blockSelectUser");
    var selectUser = document.querySelector("#blockSelectUser select.user");
    var buttonUser = document.querySelector("#sendUser");
    var description = document.querySelector("#blockSelectUser .description");
    var direction = document.querySelector("#blockSelectUser .direction");

    function getUsers() {
        fetch("/dashboard/user/get-by-type/" + typeUser)
            .then((res) => res.json())
            .then((res) => {
                if (typeUser === "provider") {
                    userEntry = res;
                } else {
                    userExit = res;
                }
                populateSelectUser();
            });
    }

    function populateSelectUser() {
        selectUser.options.length = 0;  // Limpiar las opciones del select

        var dataArray = (typeUser === "customer") ? userExit : userEntry;

        dataArray.forEach(function(user) {
            var option = new Option(user.username, user.id);
            selectUser.appendChild(option);
        });
    }

    var entries = document.querySelectorAll('.entry');
    entries.forEach(function(entry) {
        entry.addEventListener('keyup', function(event) {
            if (event.keyCode === 13) {
                id = entry.getAttribute('data-id');
                buttonUser.setAttribute('data-id', id);
                buttonUser.setAttribute('data-value', entry.value);
                buttonUser.setAttribute('data-type', 'entry');
                typeUser = "provider";  // Cambia el tipo de usuario

                if (userEntry.length === 0) {
                    getUsers();
                } else {
                    populateSelectUser();
                    modal.show();
                }
            }
        });
    });

    var exits = document.querySelectorAll('.exit');
    exits.forEach(function(exit) {
        exit.addEventListener('keyup', function(event) {
            if (event.keyCode === 13) {
                id = exit.getAttribute('data-id');
                buttonUser.setAttribute('data-id', id);
                buttonUser.setAttribute('data-value', exit.value);
                buttonUser.setAttribute('data-type', 'exit');
                typeUser = "customer";  // Cambia el tipo de usuario

                if (userExit.length === 0) {
                    getUsers();
                } else {
                    populateSelectUser();
                    modal.show();
                }
            }
        });
    });

    buttonUser.addEventListener("click", function() {
        var id = buttonUser.getAttribute('data-id');
        var value = buttonUser.getAttribute('data-value');
        var type = buttonUser.getAttribute('data-type');
        var userID = selectUser.value;
        var url = 'product/exit-stock/' + id + '/' + value;

        if (type === 'entry') {
            url = 'product/add-stock/' + id + '/' + value;
        }

        var formData = new FormData();
        formData.append('user_id', userID);
        formData.append('description', description.value);
        formData.append('direction', direction.value);

        fetch(url, {
            method: 'POST',
            body: formData
        })
        .then((res) => res.json())
        .then((res) => {
            document.getElementById("stock_" + res.id).innerText = res.stock;
            modal.hide();  // Cierra el modal después de enviar los datos
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Error al actualizar el stock.');
        });
    });
</script>
<?php $this->endSection() ?>