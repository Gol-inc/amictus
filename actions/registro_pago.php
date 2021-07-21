<?php
session_start();
include 'conexion.php';
$date = getdate();
$seleccionar = $pdo->prepare("SELECT id_venta FROM ventas ORDER BY id_venta DESC");
$seleccionar->execute();
$lista_seleccionar = $seleccionar->fetchAll(PDO::FETCH_ASSOC);
$id_venta = $lista_seleccionar ? intval($lista_seleccionar[0]['id_venta']) + 1 : 1;
$id_usuario = $_SESSION['usuario_amictus'][0]['id_usuario'];
for ($i = 0; $i < count($_SESSION['carrito_amictus']); $i++) {
    if ($_SESSION['carrito_amictus'][$i] != NULL) {
        $id_producto = $_SESSION['carrito_amictus'][$i]['id_producto'];
        $cant = $_SESSION['carrito_amictus'][$i]['cantidad_producto'];
        $fecha = $date['mday'] . "-" . $date['mon'] . "-" . $date['year'] . " " . $date['hours'] . ":" . $date['minutes'] . ":" . $date['seconds'];
        $costo = $_SESSION['carrito_amictus'][$i]['precio_producto'] * $_SESSION['carrito_amictus'][$i]['cantidad_producto'];
        $insertar_venta = $pdo->prepare("INSERT INTO ventas (id_venta,id_usuario,id_producto,cant,total_prod,hora_venta) VALUES ('$id_venta','$id_usuario','$id_producto','$cant','$costo','$fecha')");
        $insertar_venta->execute();
        $editar_stock = $pdo->prepare("UPDATE productos SET stock_producto = (stock_producto - $cant) WHERE id_producto = $id_producto");
        $editar_stock->execute();
    }
}
unset($_SESSION['carrito_amictus']);
header("Location: ../index.php");
