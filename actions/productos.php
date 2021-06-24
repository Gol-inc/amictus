<?php
$mensaje;
include 'conexion.php';
if ($_GET['msg'] == "Agregar") {
    // $mensaje = agregarProducto($_POST);
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $precio_producto = $_POST['precio_producto'];
    $agregar_producto = $pdo->prepare("INSERT INTO productos(nombre_producto,descripcion_producto,precio_producto) VALUES('$nombre_producto','$descripcion_producto','$precio_producto')");
    $agregar_producto->execute();

    for ($c = 0; $c < count($_POST['color']); $c++) {
        $id_color = $_POST['color'][$c];

        $relacionar_color = $pdo->prepare("INSERT INTO colores_productos(id_color,id_producto)VALUES ('$id_color',(SELECT id_producto FROM productos WHERE nombre_producto = '$nombre_producto'))");
        $relacionar_color->execute();
    }

    foreach ($_FILES['imagen']['tmp_name'] as $key => $value) {
        //Datos imagenes
        $nombre_imagen = $_FILES['imagen']['name'][$key];
        $tamano_imagen = addslashes(file_get_contents($_FILES['imagen']['tmp_name'][$key]));


        $insertarImagen = $pdo->prepare("INSERT INTO imagen(nombre_imagen, tamano_imagen) VALUES ('$nombre_imagen', '$tamano_imagen')");
        $insertarImagen->execute();

        $insertarImagenProducto = $pdo->prepare("INSERT INTO imagen_producto(id_producto,id_imagen) VALUES ((SELECT id_producto FROM productos WHERE nombre_producto ='$nombre_producto'),(SELECT id_imagen FROM imagen WHERE nombre_imagen ='$nombre_imagen'))");
        $insertarImagenProducto->execute();
    }

    $mensaje = "producto agregado correctamente";
    echo json_encode($mensaje);
} else if ($_GET['msg'] == "Editar") {
    // $mensaje = editarProducto();
    $id = $_POST['id'];
    $nombre_producto = $_POST['nombre_producto'];
    $descripcion_producto = $_POST['descripcion_producto'];
    $precio_producto = $_POST['precio_producto'];
    $editar_producto = $pdo->prepare("UPDATE productos SET nombre_producto ='$nombre_producto', descripcion_producto='$descripcion_producto', precio_producto='$precio_producto' WHERE id_producto ='$id' ");
    $editar_producto->execute();
    $files = $_FILES['imagen']['name'][0];

    if ($files != "") {
        //Borrar Relaciones entre producto e imagen
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
            $insertarNuevasImagenesProducto = $pdo->prepare("INSERT INTO imagen_producto(id_producto,id_imagen) VALUES ((SELECT id_producto FROM productos WHERE nombre_producto ='$nombre'),(SELECT id_imagen FROM imagen WHERE nombre_imagen ='$nombre_imagen'))");
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
    $mensaje = "producto editado correctamente";
    echo json_encode($mensaje);
} else if ($_GET['msg'] == "Eliminar") {
    // $mensaje = eliminarProducto();
    $id = $_POST['id'];

    $borrarImagenes = $pdo->prepare("DELETE FROM imagen WHERE id_imagen IN (SELECT imagen.id_imagen FROM imagen_producto INNER JOIN productos ON imagen_producto.id_producto ='$id' INNER JOIN imagen ON imagen_producto.id_imagen = imagen.id_imagen)");
    $borrarImagenes->execute();
    $borrarImagenesProductos = $pdo->prepare("DELETE FROM imagen_producto WHERE id_producto ='$id'");
    $borrarImagenesProductos->execute();

    $borrarColoresProductos = $pdo->prepare("DELETE FROM colores_productos WHERE id_producto ='$id' ");
    $borrarColoresProductos->execute();
    $borrarProductos = $pdo->prepare("DELETE FROM productos WHERE id_producto='$id'");
    $borrarProductos->execute();
    $mensaje = "Producto eliminado correctamente";
    echo json_encode($mensaje);
}
