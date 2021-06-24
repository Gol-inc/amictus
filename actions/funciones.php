<?php
function registrarUsuario()
{
    include "conexion.php";
    $nombre = $_POST['nombre_r'];
    $email = $_POST['email_r'];
    $pwd = $_POST['pwd_r'];
    $msg;

    $pwd_sec = password_hash($pwd, PASSWORD_DEFAULT);
    $user_existe = $pdo->prepare("SELECT * FROM usuarios WHERE email_usuario = '$email'");
    $user_existe->execute();
    $contador = $user_existe->rowCount();
    if ($contador) {
        $msg = 'El email ya se encuentra registrado, por favor ingrese otro.';
        return $msg;
        exit;
    }
    $registrar_usuario = $pdo->prepare("INSERT INTO usuarios(nombre_usuario,email_usuario,pass_usuario) VALUES ('$nombre','$email','$pwd_sec')");
    $registrar_usuario->execute();
    if ($registrar_usuario) {
        $msg = 'Cuenta registrada correctamente.';
        return $msg;
    } else {
        $msg = 'Error al registrarte.';
        return $msg;
    }
}
function validarUsuario()
{
    include "conexion.php";
    $email = $_POST['email_v'];
    $pwd = $_POST['pwd_v'];
    $msg;
    $cont = 0;

    $validacion = $pdo->prepare("SELECT id_usuario, nombre_usuario, email_usuario, pass_usuario FROM usuarios WHERE email_usuario = '$email'");
    $validacion->execute();
    $listadoEmails = $validacion->fetchAll(PDO::FETCH_ASSOC);

    foreach ($listadoEmails as $user) {

        if (password_verify($pwd, $user['pass_usuario'])) {
            $cont++;
            $id_user = $user['id_usuario'];
            $nombre_user = $user['nombre_usuario'];
            $email_user = $user['email_usuario'];
        } else {
            $msg = 'No hay registros';
            return $msg;
        }
    }

    if ($cont) {
        session_start();
        $_SESSION['usuario_actual'][0]['id_usuario'] = $id_user;
        $_SESSION['usuario_actual'][0]['nombre'] = $nombre_user;
        $_SESSION['usuario_actual'][0]['email'] = $email_user;
        $msg = 'Inicio de sesion correcto.';
        return $msg;
    } else {
        $msg = 'Error al ingresar.';
        return $msg;
    }
}
function get($item)
{
    include "conexion.php";
    $traer_item = $pdo->prepare("SELECT * FROM $item");
    $traer_item->execute();
    $array_item = $traer_item->fetchAll(PDO::FETCH_ASSOC);
    return $array_item;
}
// function agregarProducto(){}

// function editarProducto(){}

function relacionColorProducto()
{
    include "conexion.php";
    $editColores = $pdo->prepare("SELECT colores.id_color,colores.nombre_color,colores.hex_color,productos.id_producto
FROM colores_productos
INNER JOIN productos ON colores_productos.id_producto = productos.id_producto
INNER JOIN colores ON colores_productos.id_color = colores.id_color");
    $editColores->execute();
    $listEditColores = $editColores->fetchAll(PDO::FETCH_ASSOC);
    return $listEditColores;
}

function relacionImagenProducto()
{
    include "conexion.php";
    $consultaImagenes = $pdo->prepare("SELECT imagen.id_imagen, productos.id_producto,imagen.tamano_imagen 
FROM imagen_producto 
INNER JOIN productos ON imagen_producto.id_producto = productos.id_producto
INNER JOIN imagen ON imagen_producto.id_imagen = imagen.id_imagen");
    $consultaImagenes->execute();
    $lista_imagenes = $consultaImagenes->fetchAll(PDO::FETCH_ASSOC);
    return $lista_imagenes;
}
