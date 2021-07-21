<?php
include 'conexion.php';
header("Access-Control-Allow-Origin:*");
if ($_POST['accion'] == "Agregar") {
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $precio_producto = $_POST['precio_producto'];
    $categoria_producto = $_POST['categoria_producto'];
    $stock_producto = $_POST['stock_producto'];
    $destacado;
    if ($_POST['destacado'] == 'on') {
        $destacado = 1;
    } else {
        $destacado = 0;
    }
    $agregar_producto = $pdo->prepare("INSERT INTO productos(nombre_producto,descripcion_producto,precio_producto, stock_producto,categoria_producto,destacado) VALUES('$nombre_producto','$descripcion_producto','$precio_producto','$stock_producto','$categoria_producto','$destacado')");
    $agregar_producto->execute();
    for ($c = 0; $c < count($_POST['color']); $c++) {
        $id_color = $_POST['color'][$c];
        $relacionar_color = $pdo->prepare("INSERT INTO colores_productos(id_color,id_producto)VALUES ('$id_color',(SELECT id_producto FROM productos WHERE nombre_producto = '$nombre_producto'))");
        $relacionar_color->execute();
    }
    foreach ($_FILES['imagen']['tmp_name'] as $key => $value) {
        $nombre_imagen = $_FILES['imagen']['name'][$key];
        $tamano_imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name'][$key]));
        $insertarImagen = $pdo->prepare("INSERT INTO imagen(nombre_imagen, tamano_imagen) VALUES ('$nombre_imagen', '$tamano_imagen')");
        $insertarImagen->execute();
        $insertarImagenProducto = $pdo->prepare("INSERT INTO imagen_producto(id_producto,id_imagen) VALUES ((SELECT id_producto FROM productos WHERE nombre_producto ='$nombre_producto'),(SELECT id_imagen FROM imagen WHERE nombre_imagen ='$nombre_imagen'))");
        $insertarImagenProducto->execute();
    }
} else if ($_POST['accion'] == "Eliminar") {
    $id = $_POST['id'];

    $borrarImagenes = $pdo->prepare("DELETE FROM imagen WHERE id_imagen IN (SELECT imagen.id_imagen FROM imagen_producto INNER JOIN productos ON imagen_producto.id_producto ='$id' INNER JOIN imagen ON imagen_producto.id_imagen = imagen.id_imagen)");
    $borrarImagenes->execute();

    $borrarImagenesProductos = $pdo->prepare("DELETE FROM imagen_producto WHERE id_producto ='$id'");
    $borrarImagenesProductos->execute();

    $borrarColoresProductos = $pdo->prepare("DELETE FROM colores_productos WHERE id_producto ='$id'");
    $borrarColoresProductos->execute();

    $borrarProductos = $pdo->prepare("DELETE FROM productos WHERE id_producto='$id'");
    $borrarProductos->execute();
} else if ($_POST['accion'] == "Editar") {
    $id = $_POST['id'];
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $precio_producto = $_POST['precio_producto'];
    $categoria_producto = $_POST['categoria_producto'];
    $stock_producto = $_POST['stock_producto'];
    $destacado;
    if ($_POST['destacado'] == 'on') {
        $destacado = 1;
    } else {
        $destacado = 0;
    }
    $editar_producto = $pdo->prepare("UPDATE productos SET nombre_producto ='$nombre_producto', descripcion_producto='$descripcion_producto', precio_producto='$precio_producto',stock_producto='$stock_producto' , categoria_producto='$categoria_producto', destacado='$destacado' WHERE id_producto ='$id' ");
    $editar_producto->execute();
    $files = $_FILES['imagen']['name'][0];
    if ($files == "") {
    } else {
        $borrarImagenes = $pdo->prepare("DELETE FROM imagen WHERE id_imagen IN (SELECT imagen.id_imagen
        FROM imagen_producto 
        INNER JOIN productos ON imagen_producto.id_producto ='$id' 
        INNER JOIN imagen ON imagen_producto.id_imagen = imagen.id_imagen)");
        $borrarImagenes->execute();
        $borrarRelacionesImagenes = $pdo->prepare("DELETE FROM imagen_producto WHERE id_producto = '$id'");
        $borrarRelacionesImagenes->execute();
        foreach ($_FILES['imagen']['tmp_name'] as $key => $value) {
            $nombre_imagen = $_FILES['imagen']['name'][$key];
            $tamano_imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name'][$key]));
            $insertarNuevasImagenes = $pdo->prepare("INSERT INTO imagen(nombre_imagen,tamano_imagen) VALUES ('$nombre_imagen','$tamano_imagen')");
            $insertarNuevasImagenes->execute();
            $insertarNuevasImagenesProducto = $pdo->prepare("INSERT INTO imagen_producto(id_producto,id_imagen) VALUES ((SELECT id_producto FROM productos WHERE nombre_producto ='$nombre_producto'),(SELECT id_imagen FROM imagen WHERE nombre_imagen ='$nombre_imagen'))");
            $insertarNuevasImagenesProducto->execute();
        }
    }
    $borrarRelacionesColores = $pdo->prepare("DELETE FROM colores_productos WHERE id_producto = '$id'");
    $borrarRelacionesColores->execute();
    if (isset($_POST['color'])) {
        for ($c = 0; $c < count($_POST['color']); $c++) {
            $id_color = $_POST['color'][$c];
            $relacionar_color = $pdo->prepare("INSERT INTO colores_productos(id_color,id_producto)VALUES ('$id_color',(SELECT id_producto FROM productos WHERE nombre_producto = '$nombre_producto'))");
            $relacionar_color->execute();
        }
    }
}
header("Location:../admin.php");
