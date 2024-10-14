<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturacion</title>
    <link rel="stylesheet" href="<?= base_url("/bootstrap/css/bootstrap.min.css") ?>">
    <script src="<?= base_url("/bootstrap/js/bootstrap.min.js") ?>"></script>
</head>

<body>
    <div class="container">
        <nav class="navbar bg-light navbar-light navbar-expand-lg">
            <a href="/" class="navbar-brand">Inventario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav" aria-controls="nav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="nav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="/dashboard/product" class="nav-link">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a href="/dashboard/category" class="nav-link">Categorías</a>
                    </li>
                    <li class="nav-item">
                        <a href="/dashboard/tag" class="nav-link">Etiquetas</a>
                    </li>
                </ul>
            </div>
        </nav>
        <div>
            <?php $this->renderSection('body') ?>
        </div>
    </div>


   

</body>

</html>