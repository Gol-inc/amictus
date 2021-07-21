<?php
error_reporting(0);
session_start();
include 'conexion.php';
$id = $_POST['id_producto'];
$color = $_POST['lista_colores'];
$cantidad = $_POST['cantidad'];
if ($_POST['carrito'] == 'agregar') {
    if (isset($_SESSION['carrito_amictus'])) {
        $arreglo = $_SESSION['carrito_amictus'];
        $encontro = false;
        $numero = 0;
        for ($i = 0; $i < count($arreglo); $i++) {
            if ($arreglo[$i]['id_producto'] == $id) {
                $encontro = true;
                $numero = $i;
            }
        }
        if ($encontro) {
            $arreglo[$numero]['cantidad_producto'] = $arreglo[$numero]['cantidad_producto'] + $cantidad;
            $arreglo[$numero]['color_producto'] = $arreglo[$numero]['color_producto'] . ", " . $color;
            $_SESSION['carrito_amictus'] = $arreglo;
            echo "<script>alert('Producto agregado correctamente')</script>";
        } else {
            $consulta = $pdo->prepare("SELECT * FROM productos WHERE id_producto = '$id'");
            $consulta->execute();
            $lista_productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $traerImagenesdeProductos = $pdo->prepare("SELECT imagen.id_imagen, productos.id_producto,imagen.tamano_imagen 
            FROM imagen_producto 
            INNER JOIN productos ON imagen_producto.id_producto = '$id'
            INNER JOIN imagen ON imagen_producto.id_imagen = imagen.id_imagen");
            $traerImagenesdeProductos->execute();
            $listImages = $traerImagenesdeProductos->fetchAll(PDO::FETCH_ASSOC);
            foreach ($lista_productos as $prod) {
                $nombre = $prod['nombre_producto'];
                $descripcion = $prod['descripcion_producto'];
                $precio = $prod['precio_producto'];
                $imagen = $listImages[0]['tamano_imagen'];
            }
            $datosNuevos = array(
                'id_producto' => $id,
                'imagen_producto' => $imagen,
                'nombre_producto' => $nombre,
                'descripcion_producto' => $descripcion,
                'cantidad_producto' => $cantidad,
                'precio_producto' => $precio,
                'color_producto' => $color,
            );
            array_push($arreglo, $datosNuevos);
            $_SESSION['carrito_amictus'] = $arreglo;
            echo "<script>alert('Producto agregado correctamente')</script>";
        }
    } else {
        if (isset($id)) {
            $consulta = $pdo->prepare("SELECT * FROM productos WHERE id_producto = '$id'");
            $consulta->execute();
            $lista_productos = $consulta->fetchAll(PDO::FETCH_ASSOC);
            $traerImagenesdeProductos = $pdo->prepare("SELECT imagen.id_imagen, productos.id_producto,imagen.tamano_imagen 
            FROM imagen_producto 
            INNER JOIN productos ON imagen_producto.id_producto = '$id'
            INNER JOIN imagen ON imagen_producto.id_imagen = imagen.id_imagen");
            $traerImagenesdeProductos->execute();
            $listImages = $traerImagenesdeProductos->fetchAll(PDO::FETCH_ASSOC);
            foreach ($lista_productos as $prod) {
                $nombre = $prod['nombre_producto'];
                $descripcion = $prod['descripcion_producto'];
                $precio = $prod['precio_producto'];
                $imagen = $listImages[0]['tamano_imagen'];
            }
            $array[] = array(
                'id_producto' => $id,
                'imagen_producto' => $imagen,
                'nombre_producto' => $nombre,
                'precio_producto' => $precio,
                'cantidad_producto' => $cantidad,
                'color_producto' => $color,
            );
            $_SESSION['carrito_amictus'] = $array;
            echo "<script>alert('Producto agregado correctamente')</script>";
        }
    }
} else if ($_POST['carrito'] == 'eliminar') {
    $producto_a_borrar = $_POST['id'];
    foreach ($_SESSION['carrito_amictus'] as $indice => $producto) {
        if ($producto['id_producto'] == $producto_a_borrar) {
            unset($_SESSION['carrito_amictus'][$indice]);
            if ($_SESSION['carrito_amictus'][$indice]) {
                $_SESSION['carrito_amictus'][$indice] = '';
            }
            array_splice($_SESSION['carrito_amictus'][$indice], 1);
            echo "<script> alert('Producto eliminado')</script>";
        }
    }
}
// header("Location: https://www.amictus.com.ar/index.php");
echo "<script> window.location.replace('https://www.amictus.com.ar/');</script>";
