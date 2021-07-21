<?php
session_start();
if ($_SESSION['usuario_amictus'][0]['email'] == 'ag171980@gmail.com' || $_SESSION['usuario_amictus'][0]['email'] == 'amictus12@gmail.com') {
} else {
    header("Location:index.php");
}
include 'actions/funciones.php';
$cant_usuarios = count(get('usuarios'));
$productos = get('productos');
$colores = get('colores');
$usuarios = get('usuarios');
$categorias = get('categorias');
$ventas = get('ventas');
$relacion_colores = relacionColorProducto();
$cant_color = 0;
$relacion_imagenes = relacionImagenProducto();
$cant_imgs = 0;
$cant_ventas = count(cantVentas());
$monto_total = montoTotal();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="https://www.amictus.com.ar/images/logo.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5b23b3e9e6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Administrador</title>
    <link rel="stylesheet" href="https://www.amictus.com.ar/css/admin.css">
</head>

<body>
    <div class="titulo header">
        <h1>Dashboard</h1>
        <a href="./index.php">Regresar a la página</a>
    </div>
    <div class="estadisticas">
        <div class="card usuarios">
            <i class="fas fa-user"></i>
            <h2>Usuarios </h2>
            <p><?php echo $cant_usuarios; ?></p>
        </div>
        <div class="card productos">
            <i class="fas fa-box"></i>
            <h2>Productos</h2>
            <p><?php echo count($productos); ?></p>
        </div>
        <div class="card monto">
            <i class="far fa-money-bill-alt"></i>
            <h2>Monto de Ventas</h2>
            <p>$<?php echo $monto_total; ?></p>
        </div>
        <div class="card ventas">
            <i class="fas fa-shopping-cart"></i>
            <h2>Ventas</h2>
            <p><?php echo $cant_ventas; ?></p>
        </div>
    </div>
    <div class="p productos">
        <div class="titulo">
            <h2>Productos</h2>
            <button class="btn">Agregar Productos</button>
        </div>
        <div id="modal-productos" class="modals modal-productos disabled">
            <form action="actions/productos.php" enctype="multipart/form-data" method="POST">
                <i class="cerrar fas fa-times"></i>
                <h3>AGREGAR PRODUCTO</h3>
                <input type="text" style="display: none;" value="Agregar" name="accion">
                <label for="nombre_producto">Nombre del producto</label>
                <input type="text" id="nombre_producto" name="nombre_producto" placeholder="Ingrese el nombre del producto..." required>
                <label for="descripcion_producto">Descripcion del producto</label>
                <input type="text" id="descripcion_producto" name="descripcion_producto" placeholder="Ingrese la descripcion de su producto..." required>
                <label for="precio_producto">Precio del producto</label>
                <input type="text" id="precio_producto" name="precio_producto" placeholder="Ingrese el precio de su producto..." required>
                <label for="categoria_producto">Categoría del producto</label>
                <input list="categorias" id="categoria_producto" name="categoria_producto" required>
                <datalist id="categorias">
                    <?php foreach ($categorias as $cat) { ?>
                        <option value="<?php echo $cat['nombre_categoria']; ?>"></option>
                    <?php } ?>
                </datalist>
                <label for="stock_producto">Stock del producto</label>
                <input type="text" id="stock_producto" name="stock_producto" placeholder="Ingrese el stock de su producto..." required>
                <label for="destacado_producto">¿Destacado?</label>
                <input type="checkbox" name="destacado" id="destacado_producto">
                <label for="imagen_producto">Imagen del producto</label>
                <input type="file" name="imagen[]" multiple id="imagen[]">
                <label for="colores_productos">Colores</label>
                <div class="colores">
                    <?php foreach ($colores as $col) { ?>
                        <div class="color">
                            <input type="checkbox" name="color[]" value="<?php echo $col['id_color']; ?>">
                            <label for=""><?php echo $col['nombre_color'] ?></label>
                        </div>
                    <?php } ?>
                </div>
                <input type="submit" name="accion_producto" value="Agregar Producto">
                <div class="mensaje">
                    <p id="msg" class="msg"></p>
                </div>
            </form>
        </div>
        <table border="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Categoria</th>
                    <th>¿Destacado?</th>
                    <th>Colores</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $prod) { ?>
                    <tr>
                        <td><?php echo $prod['id_producto']; ?></td>
                        <td><?php echo $prod['nombre_producto']; ?></td>
                        <td><?php echo $prod['descripcion_producto']; ?></td>
                        <td style="vertical-align: middle;">
                            <?php foreach ($relacion_imagenes as $img) {
                                if ($img['id_producto'] == $prod['id_producto']) {
                            ?>
                                    <img src="data:image/jpg;base64,<?php echo base64_encode($img['tamano_imagen']); ?>" height="35" width="35" alt="">
                            <?php

                                }
                                $cant_imgs++;
                            } ?>
                        </td>
                        <td>$<?php echo $prod['precio_producto']; ?></td>
                        <td><?php echo $prod['stock_producto']; ?></td>
                        <td><?php echo $prod['categoria_producto']; ?></td>
                        <td><?php if ($prod['destacado'] == 0) {
                                echo "No";
                            } else {
                                echo "Si";
                            } ?></td>
                        <td>
                            <?php foreach ($relacion_colores as $rel) { ?>
                                <?php if ($rel['id_producto'] == $prod['id_producto']) { ?>
                                    <?php echo $rel['nombre_color'] ?>
                                <?php $cant_color++;
                                } ?>
                            <?php } ?>
                        </td>
                        <td>
                            <button class="editar"><i class="far fa-edit"></i></button>
                            <button class="eliminar"><i class="far fa-trash-alt"></i></button>
                            <div class="delete disabled">
                                <form enctype="multipart/form-data" action="actions/productos.php" method="POST" class="form_delete_productos">
                                    <i class="closed_d fas fa-times"></i>
                                    <p>¿Esta seguro de eliminar <b><?php echo $prod['nombre_producto']; ?></b> de su listado de productos?</p>
                                    <input style="display: none;" value="<?php echo $prod['id_producto']; ?>" type="text" name="id">
                                    <input type="text" style="display: none;" value="Eliminar" name="accion">
                                    <input type="submit" value="Eliminar">
                                    <div class="mensaje">
                                        <p id="msg" class="msg"></p>
                                    </div>
                                </form>
                            </div>
                            <div class="edit disabled">
                                <form enctype="multipart/form-data" action="actions/productos.php" class="form_edit_productos" method="POST">
                                    <i class="closed_e fas fa-times"></i>
                                    <h3>EDITAR PRODUCTO</h3>
                                    <input style="display: none;" type="text" name="id" value="<?php echo $prod['id_producto']; ?>">
                                    <input type="text" style="display: none;" value="Editar" name="accion">
                                    <label for="nombre_producto">Nombre del producto</label>
                                    <input type="text" id="nombre_producto" name="nombre_producto" placeholder="Ingrese el nombre del producto..." value="<?php echo $prod['nombre_producto']; ?>" required>
                                    <label for="descripcion_producto">Descripcion del producto</label>
                                    <input type="text" id="descripcion_producto" name="descripcion_producto" placeholder="Ingrese la descripcion de su producto..." value="<?php echo $prod['descripcion_producto']; ?>" required>
                                    <label for="precio_producto">Precio del producto</label>
                                    <input type="text" id="precio_producto" name="precio_producto" placeholder="Ingrese el precio de su producto..." value="<?php echo $prod['precio_producto']; ?>" required>

                                    <label for="categoria_producto">Categoría del producto</label>
                                    <input list="categorias" id="categoria_producto" name="categoria_producto" value="<?php echo $prod['categoria_producto']; ?>" required>
                                    <datalist id="categorias">
                                        <?php foreach ($categorias as $cat) { ?>
                                            <option value="<?php echo $cat['nombre_categoria']; ?>"></option>
                                        <?php } ?>
                                    </datalist>
                                    <label for="stock_producto">Stock del producto</label>
                                    <input type="text" id="stock_producto" name="stock_producto" placeholder="Ingrese el stock de su producto..." value="<?php echo $prod['stock_producto']; ?>" required>
                                    <label for="destacado_producto">¿Destacado?</label>
                                    <?php if ($prod['destacado'] == 0) { ?>
                                        <input type="checkbox" name="destacado" id="destacado_producto">
                                    <?php } else { ?>
                                        <input type="checkbox" name="destacado" id="destacado_producto" checked>
                                    <?php } ?>

                                    <label for="imagen">Imagen del producto</label>
                                    <input type="file" name="imagen[]" multiple="" id="imagen[]">
                                    <label for="colores_productos">Colores</label>
                                    <div class="colores">
                                        <?php foreach ($colores as $col) { ?>
                                            <div class="color">
                                                <input type="checkbox" name="color[]" value="<?php echo $col['id_color']; ?>">
                                                <label for=""><?php echo $col['nombre_color']; ?></label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <input type="submit" name="accion_producto" value="Editar Producto" />
                                    <div class="mensaje">
                                        <p id="msg" class="msg"></p>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>

                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="tablas">
        <div class="p colores">
            <div class="titulo">
                <h2>Colores</h2>
                <button class="btn">Agregar Color</button>
            </div>
            <div id="modal-colores" class="modals modal-colores disabled">
                <form id="form_colores" class="form_colores">
                    <i class="cerrar fas fa-times"></i>
                    <h3>AGREGAR COLOR</h3>
                    <label for="nombre_color">Nombre del color</label>
                    <input type="text" id="nombre_color" name="nombre_color" placeholder="Ingrese el nombre del color..." required>
                    <label for="codigo_color">Codigo del color</label>
                    <input type="text" id="codigo_color" name="codigo_color" placeholder="Ingrese el codigo del color..." required>
                    <button type="submit">Enviar</button>
                    <div class="mensaje">
                        <p id="msg"></p>
                    </div>
                </form>
            </div>
            <table border="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>HEX</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($colores  as $col) { ?>
                        <tr>
                            <td><?php echo $col['id_color']; ?></td>
                            <td><?php echo $col['nombre_color']; ?></td>
                            <td><?php echo $col['hex_color']; ?></td>
                            <td>
                                <button class="editar"><i class="far fa-edit"></i></button>
                                <button class="eliminar"><i class="far fa-trash-alt"></i></button>
                                <div class="delete disabled">
                                    <form class="form_delete_colores">
                                        <i class="closed_d fas fa-times"></i>
                                        <p>¿Esta seguro de eliminar <b><?php echo $col['nombre_color']; ?></b> de su listado de colores?</p>
                                        <input style="display: none;" value="<?php echo $col['id_color']; ?>" type="text" name="id_color">
                                        <button type="submit">SI</button>
                                        <div class="mensaje">
                                            <p id="msg" class="msg"></p>
                                        </div>
                                    </form>
                                </div>
                                <div class="edit disabled">
                                    <form class="form_edit_colores">
                                        <i class="closed_e fas fa-times"></i>
                                        <h3>EDITAR COLOR</h3>
                                        <input style="display: none;" type="text" name="id_color" value="<?php echo $col['id_color']; ?>">
                                        <label for="nombre_color">Nombre del color</label>
                                        <input type="text" id="nombre_color" name="nombre_color" placeholder="Ingrese el nombre del color..." value="<?php echo $col['nombre_color']; ?>" required>
                                        <label for="codigo_color">Descripcion del producto</label>
                                        <input type="text" id="codigo_color" name="codigo_color" placeholder="Ingrese el código de su color..." value="<?php echo $col['hex_color']; ?>" required>
                                        <input type="submit" name="editar_producto" value="Editar Producto" />
                                        <div class="mensaje">
                                            <p id="msg" class="msg"></p>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
        <div class="p categorias">
            <div class="titulo">
                <h2>Categorías</h2>
                <button class="btn">Agregar Categoría</button>
            </div>
            <div id="modal-categoria" class="modals modal-categoria disabled">
                <form id="form_categorias" class="form_categorias">
                    <i class="cerrar fas fa-times"></i>
                    <h3>AGREGAR CATEGORÍA</h3>
                    <label for="nombre_categoria">Nombre de la categoría</label>
                    <input type="text" id="nombre_categoria" name="nombre_categoria" placeholder="Ingrese el nombre de su categoría..." required>
                    <button type="submit">Enviar</button>
                    <div class="mensaje">
                        <p id="msg"></p>
                    </div>
                </form>
            </div>
            <table border="0">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categorias  as $cat) { ?>
                        <tr>
                            <td><?php echo $cat['nombre_categoria']; ?></td>
                            <td>
                                <button class="editar"><i class="far fa-edit"></i></button>
                                <button class="eliminar"><i class="far fa-trash-alt"></i></button>
                                <div class="delete disabled">
                                    <form class="form_delete_categorias">
                                        <i class="closed_d fas fa-times"></i>
                                        <p>¿Esta seguro de eliminar <b><?php echo $cat['nombre_categoria']; ?></b> de su listado de categorias?</p>
                                        <input style="display: none;" value="<?php echo $cat['id_categoria']; ?>" type="text" name="id_categoria">
                                        <button type="submit">SI</button>
                                        <div class="mensaje">
                                            <p id="msg" class="msg"></p>
                                        </div>
                                    </form>
                                </div>
                                <div class="edit disabled">
                                    <form class="form_edit_categorias">
                                        <i class="closed_e fas fa-times"></i>
                                        <h3>EDITAR CATEGORÍA</h3>
                                        <input style="display: none;" type="text" name="id_categoria" value="<?php echo $cat['id_categoria']; ?>">
                                        <label for="nombre_categoria">Nombre de la categoría</label>
                                        <input type="text" id="nombre_categoria" name="nombre_categoria" placeholder="Ingrese el nombre de su categoria..." value="<?php echo $cat['nombre_categoria']; ?>" required>
                                        <input type="submit" name="editar_categoria" value="Editar Categoria" />
                                        <div class="mensaje">
                                            <p id="msg" class="msg"></p>
                                        </div>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>

    <div class="p usuarios">
        <div class="titulo">
            <h2>Usuarios</h2>
        </div>
        <table border="0">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios  as $usu) { ?>
                    <tr>
                        <td><?php echo $usu['id_usuario']; ?></td>
                        <td><?php echo $usu['nombre_usuario']; ?></td>
                        <td><?php echo $usu['email_usuario']; ?></td>
                        <td>
                            <button class="eliminar"><i class="far fa-trash-alt"></i></button>
                            <div class="delete disabled">
                                <form class="form_delete_usuarios">
                                    <i class="closed_d fas fa-times"></i>
                                    <p>¿Esta seguro de eliminar <b><?php echo $usu['nombre_usuario']; ?></b> de su listado de usuarios?</p>
                                    <input style="display: none;" value="<?php echo $usu['id_usuario']; ?>" type="text" name="id_usuario">
                                    <button type="submit">SI</button>
                                    <div class="mensaje">
                                        <p id="msg" class="msg"></p>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <div class="p ventas">
        <div class="titulo">
            <h2>Ventas</h2>
        </div>
        <table border="0">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Nombre Comprador</th>
                    <th>Productos comprados</th>
                    <th>Cantidad</th>
                    <th>Costo Total</th>
                    <th>Hora de transacción</th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($ventas); $i++) { ?>
                    <tr>
                        <?php if ($ventas[$i]['id_venta'] == $ventas[$i - 1]['id_venta']) { ?>
                            <td></td>
                        <?php } else { ?>
                            <td><?php echo $ventas[$i]['id_venta']; ?> </td>
                        <?php } ?>
                        <td><?php echo getTable($ventas[$i]['id_usuario'], 'usuarios', 'nombre_usuario', 'id_usuario');  ?></td>
                        <td><?php echo getTable($ventas[$i]['id_producto'], 'productos', 'nombre_producto', 'id_producto'); ?></td>
                        <td><?php echo $ventas[$i]['cant']; ?></td>
                        <td>$<?php echo $ventas[$i]['total_prod']; ?></td>
                        <td><?php echo $ventas[$i]['hora_venta']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <script src="https://www.amictus.com.ar/js/admin.js"></script>
</body>

</html>