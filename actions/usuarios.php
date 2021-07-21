<?php
include 'conexion.php';
if ($_GET['msg'] == "Eliminar") {
    $id_usuario = $_POST['id_usuario'];
    $borrar_usuario = $pdo->prepare("DELETE FROM usuarios WHERE id_usuario ='$id_usuario'");
    $borrar_usuario->execute();
    $mensaje = "Color eliminado correctamente";
}
echo json_encode($mensaje);