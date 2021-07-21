<?php
include 'conexion.php';
$mensaje;
if ($_GET['msg'] == "Agregar") {
    $nombre_cat = $_POST['nombre_categoria'];
    $agregar_categoria = $pdo->prepare("INSERT INTO categorias(nombre_categoria) VALUES ('$nombre_cat')");
    $agregar_categoria->execute();
    $mensaje = "Color agregado correctamente";
} else if ($_GET['msg'] == "Editar") {
    $id_cat = $_POST['id_categoria'];
    $nombre_cat = $_POST['nombre_categoria'];
    $editar_categoria = $pdo->prepare("UPDATE categorias SET nombre_categoria='$nombre_cat' WHERE id_categoria='$id_cat'");
    $editar_categoria->execute();
    $mensaje = "Color editado correctamente";
} else if ($_GET['msg'] == "Eliminar") {
    $id_cat = $_POST['id_categoria'];
    $borrar_categoria = $pdo->prepare("DELETE FROM categorias WHERE id_categoria ='$id_cat'");
    $borrar_categoria->execute();
    $mensaje = "Color eliminado correctamente";
}
echo json_encode($mensaje);
