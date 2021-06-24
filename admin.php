<?php
session_start();
include 'actions/funciones.php';
$cant_usuarios = count(get('usuarios'));
$productos = get('productos');
$colores = get('colores');
$relacion_colores = relacionColorProducto();
$cant_color = 0;
$relacion_imagenes = relacionImagenProducto();
$cant_imgs = 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5b23b3e9e6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <title>Administrador</title>
    <link rel="stylesheet" href="css/admin.css">

</head>

<body>
    <div class="titulo">
        <h1>Dashboard</h1>
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
            <p>-</p>
        </div>
        <div class="card ventas">
            <i class="fas fa-shopping-cart"></i>
            <h2>Ventas</h2>
            <p>-</p>
        </div>
    </div>
    <div class="p productos">
        <div class="titulo">
            <h2>Productos</h2>
            <button class="btn">Agregar Productos</button>
        </div>
        <div id="modal-productos" class="modals modal-productos disabled">
            <form enctype="multipart/form-data" id="form_productos">
                <i class="cerrar fas fa-times"></i>
                <h3>AGREGAR PRODUCTO</h3>
                <label for="nombre_producto">Nombre del producto</label>
                <input type="text" id="nombre_producto" name="nombre_producto" placeholder="Ingrese el nombre del producto..." required>
                <label for="descripcion_producto">Descripcion del producto</label>
                <input type="text" id="descripcion_producto" name="descripcion_producto" placeholder="Ingrese la descripcion de su producto..." required>
                <label for="precio_producto">Precio del producto</label>
                <input type="text" id="precio_producto" name="precio_producto" placeholder="Ingrese el precio de su producto..." required>
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
                <input type="submit" name="agregar_producto" value="Agregar Producto">
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
                                <form enctype="multipart/form-data" class="form_delete_productos">
                                    <i class="closed_d fas fa-times"></i>
                                    <p>¿Esta seguro de eliminar <b><?php echo $prod['nombre_producto']; ?></b> de su listado de productos?</p>
                                    <input style="display: none;" value="<?php echo $prod['id_producto']; ?>" type="text" name="id">
                                    <button type="submit">SI</button>
                                    <div class="mensaje">
                                        <p id="msg" class="msg"></p>
                                    </div>
                                </form>
                            </div>
                            <div class="edit disabled">
                                <form enctype="multipart/form-data" class="form_edit_productos">
                                    <i class="closed_e fas fa-times"></i>
                                    <h3>EDITAR PRODUCTO</h3>
                                    <input style="display: none;" type="text" name="id" value="<?php echo $prod['id_producto']; ?>">
                                    <label for="nombre_producto">Nombre del producto</label>
                                    <input type="text" id="nombre_producto" name="nombre_producto" placeholder="Ingrese el nombre del producto..." value="<?php echo $prod['nombre_producto']; ?>" required>
                                    <label for="descripcion_producto">Descripcion del producto</label>
                                    <input type="text" id="descripcion_producto" name="descripcion_producto" placeholder="Ingrese la descripcion de su producto..." value="<?php echo $prod['descripcion_producto']; ?>" required>
                                    <label for="precio_producto">Precio del producto</label>
                                    <input type="text" id="precio_producto" name="precio_producto" placeholder="Ingrese el precio de su producto..." value="<?php echo $prod['precio_producto']; ?>" required>
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
    <div class="p colores">
        <div class="titulo">
            <h2>Colores</h2>
            <button class="btn">Agregar Color</button>
        </div>
        <div id="modal-colores" class="modals modal-colores disabled">
            <form id="form_colores">
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
                                    <p>¿Esta seguro de eliminar <b><?php echo $col['nombre_color']; ?></b> de su listado de productos?</p>
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
                    <th>Costo</th>
                    <th>Hora de transacción</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Verde</td>
                    <td>#042435</td>
                    <td>Lorem ipsum</td>
                    <td>Lorem ipsum</td>
                </tr>

            </tbody>
        </table>
    </div>
    <script src="js/admin.js"></script>
</body>

</html>