<?php $this->extend('Layouts/layout') ?>
<?php $this->section('body') ?>

<a href="<?= base_url('/dashboard/product/new') ?>">Crear Nuevo Producto</a>
<form action="" method="get">
    <label for="categoria_id">Categorías</label>
    <select name="category_id" id="categoria_id">
    <?php foreach($categories as $c) : ?>
        <option value="<?= $c->id?>"><?= $c->name?></option>
    <?php endforeach ?>
</select>
<label for="tags">Etiquetas:</label>
    <select name="tags_id[]" id="tags" multiple>
        <?php foreach ($tags as $tag): ?>
            <option value="<?= $tag->id ?>" <?= in_array($tag->id, $productTags) ? 'selected' : '' ?>>
                <?= $tag->name ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Enviar</button>
    </form>
    <a href="<?= base_url('/dashboard/product/') ?>">Limpiar</a>
<?php if (!empty($products)): ?>

    <h2>Lista de Productos</h2>

    <div id="blockSelectUser" style="display: none;">
        <select class="user">
            <?php foreach ($users as $key => $user) : ?>
                <option value="<?= $user->id ?>"><?= $user->username ?></option>
            <?php endforeach ?>
        </select>
        <textarea name="" id="" class="description" placeholder="Descripción"></textarea>
        <textarea name="" id="" class="direction" placeholder="Dirección"></textarea>
        <button class="user">Enviar</button>
    </div>
    <table border="1">
        <caption>Productos</caption>
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
                    <td> <input type="number" data-id="<?= $product->id ?>" class="entry"></td>
                    <td> <input type="number" data-id="<?= $product->id ?>" class="exit"></td>
                    <td id="stock_<?= $product->id ?>"><?= $product->stock ?></td>
                    <td><?= $product->price ?></td>
                    <td>
                        <a href="<?= base_url('/dashboard/product/' . $product->id . '/edit') ?>">Editar</a> |
                        <a href="<?= base_url('/dashboard/product/trace/' . $product->id ) ?>">Traza</a> 
                        <form action="<?= base_url('/dashboard/product/' . $product->id) ?>" method="post" style="display:inline;">
                            <input type="hidden" name="_method" value="DELETE">
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No hay productos disponibles.</p>
<?php endif; ?>


<script>
    typeUser = "customer"
    userExit = []
    userEntry = []

    function getUsers() {
        fetch("/dashboard/user/get-by-type/" + typeUser)
            .then((res) => res.json())
            .then((res) => {
                if (typeUser == "provider") {
                    userEntry = res
                } else {
                    userExit = res
                }
                populateSelectUser()
            })
    }

    function populateSelectUser() {
        selectUser.options.length = 0

        dataArray = typeUser == "customer" ? userExit : userEntry

        for (index in dataArray) {
            selectUser.options[selectUser.options.length] = new Option(dataArray[index].username, dataArray[index].id)
        }
    }


    entries = document.querySelectorAll('.entry')
    entries.forEach(function(entry) {

        entry.addEventListener('keyup', function(event) {
            id = entry.getAttribute('data-id');
            buttonUser.setAttribute('data-id', id)
            buttonUser.setAttribute('data-value', entry.value)
            buttonUser.setAttribute('data-type', 'entry')
            typeUser = "provider"

            if (event.keyCode === 13) {

                blockSelectUser.style.display = "block"
            }
            if (userEntry.length == 0) {
                getUsers()
            } else {
                populateSelectUser()
            }
        });
    })

    exits = document.querySelectorAll('.exit')
    blockSelectUser = document.querySelector("#blockSelectUser")
    selectUser = document.querySelector("#blockSelectUser select.user")
    buttonUser = document.querySelector("#blockSelectUser button.user")
    description = document.querySelector("#blockSelectUser .description")
    direction = document.querySelector("#blockSelectUser .direction")
    exits.forEach(function(exit) {
        exit.addEventListener('keyup', function(event) {
            id = exit.getAttribute('data-id');
            buttonUser.setAttribute('data-id', id)
            buttonUser.setAttribute('data-value', exit.value)
            buttonUser.setAttribute('data-type', 'exit')
            typeUser = "customer"
            if (event.keyCode === 13) {
                blockSelectUser.style.display = "block"
            }
            if (userExit.length == 0) {
                getUsers()
            } else {
                populateSelectUser()
            }

        });
    })
    buttonUser.addEventListener("click", function() {
        blockSelectUser.style.display = "none"
        id = buttonUser.getAttribute('data-id')
        value = buttonUser.getAttribute('data-value')
        type = buttonUser.getAttribute('data-type')
        userID = selectUser.value
        url = 'product/exit-stock/' + id + '/' + value
        if (type == 'entry') {
            url = 'product/add-stock/' + id + '/' + value
        }
        formData = new FormData()
        formData.append('user_id', userID)
        formData.append('description', description.value)
        formData.append('direction', direction.value)

        fetch(url, {
            method: 'POST',
            body: formData
        }).then((res) => {
            return res.json()
        }).then((res) => {
            document.getElementById("stock_" + res.id).innerText = res.stock;
        })
    })
</script>
<?php $this->endSection() ?>