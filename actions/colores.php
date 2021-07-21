<?php
include 'conexion.php';
$mensaje;
if ($_GET['msg'] == "Agregar") {
    $nombre_color = $_POST['nombre_color'];
    $codigo_color = $_POST['codigo_color'];
    $agregar_color = $pdo->prepare("INSERT INTO colores(nombre_color,hex_color) VALUES ('$nombre_color','$codigo_color')");
    $agregar_color->execute();
    $mensaje = "Color agregado correctamente";
} else if ($_GET['msg'] == "Editar") {
    $id_color = $_POST['id_color'];
    $nombre_color = $_POST['nombre_color'];
    $codigo_color = $_POST['codigo_color'];
    $editar_color = $pdo->prepare("UPDATE colores SET nombre_color='$nombre_color', hex_color='$codigo_color' WHERE id_color='$id_color'");
    $editar_color->execute();
    $mensaje = "Color editado correctamente";
} else if ($_GET['msg'] == "Eliminar") {
    $id_color = $_POST['id_color'];
    $borrar_color = $pdo->prepare("DELETE FROM colores WHERE id_color ='$id_color'");
    $borrar_color->execute();
    $mensaje = "Color eliminado correctamente";
}
echo json_encode($mensaje);
