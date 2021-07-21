<?php
include 'conexion.php';
include 'funciones.php';
$relaciones_imagenes = relacionImagenProducto();
$relaciones_colores = relacionColorProducto();
if ($_GET['accion'] == "Categoria") {
    $arr_check = strval($_POST['categorias']);
    $array = explode(",", $arr_check);
    $cant = count($array);
    $query = "SELECT * FROM productos WHERE destacado = 0 AND (";
    for ($i = 0; $i < $cant; $i++) {
        if ($array[$cant - 1] == $array[$i]) {
            $query = $query . "categoria_producto = '$array[$i]' )";
        } else {
            $query = $query . "categoria_producto = '$array[$i]' OR ";
        }
    }
    $filtro = $pdo->prepare("$query");
    $filtro->execute();
    $lista_productos = $filtro->fetchAll(PDO::FETCH_ASSOC);
    $arr = loadArray($lista_productos, $relaciones_imagenes, $relaciones_colores);
} else if ($_GET['accion'] == "Cargar") {
    $arr = loadArray(get('productos'), $relaciones_imagenes, $relaciones_colores);
}
echo json_encode($arr);
