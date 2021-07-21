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
        $_SESSION['usuario_amictus'][0]['id_usuario'] = $id_user;
        $_SESSION['usuario_amictus'][0]['nombre'] = $nombre_user;
        $_SESSION['usuario_amictus'][0]['email'] = $email_user;
        $msg = 'Inicio de sesión correcto.';
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
function loadArray($arr, $arr_imgs, $arr_colors)
{
    $array_productos = [];
    $cant_img = 0;
    $i = 0;
    $j = 0;
    foreach ($arr as $productos) {
        $array_productos[$i]['id'] = $productos['id_producto'];
        foreach ($arr_imgs as $img) {
            if ($img['id_producto'] == $productos['id_producto']) {
                $array_productos[$i]['imagen'][$cant_img] = "data:image/jpg;base64," . base64_encode($img['tamano_imagen']);
                $cant_img++;
            }
        }
        $cant_img = 0;
        $array_productos[$i]['id_producto'] = $productos['id_producto'];
        $array_productos[$i]['nombre'] = $productos['nombre_producto'];
        $array_productos[$i]['descripcion'] = $productos['descripcion_producto'];
        $array_productos[$i]['categoria'] = $productos['categoria_producto'];
        $array_productos[$i]['precio'] = $productos['precio_producto'];
        $array_productos[$i]['stock'] = $productos['stock_producto'];
        foreach ($arr_colors as $col) {
            if ($col['id_producto'] == $productos['id_producto']) {
                $array_productos[$i]['colores'][$j]['nombre'] = $col['nombre_color'];
                $array_productos[$i]['colores'][$j]['codigo'] = $col['hex_color'];
                $j++;
            }
        }
        $j = 0;
        $array_productos[$i]['destacado'] = $productos['destacado'];
        $i++;
    }
    return $array_productos;
}
function getTable($id, $table, $data, $query)
{
    include 'conexion.php';
    $user_for_id = $pdo->prepare("SELECT $data FROM $table WHERE $query='$id'");
    $user_for_id->execute();
    $nombre_usuario = $user_for_id->fetchAll(PDO::FETCH_ASSOC);
    return $nombre_usuario[0][$data];
}
function cantVentas()
{
    include 'conexion.php';
    $ventas = $pdo->prepare("SELECT id_venta FROM ventas");
    $ventas->execute();
    $arr = [];
    $lista_ventas = $ventas->fetchAll(PDO::FETCH_ASSOC);
    for ($i = 0; $i < count($lista_ventas); $i++) {
        if ($lista_ventas[$i]['id_venta'] != $lista_ventas[$i - 1]['id_venta']) {
            $arr[$i]['id_venta'] = $lista_ventas[$i]['id_venta'];
        }
    }
    return $arr;
}
function montoTotal()
{
    include 'conexion.php';
    $arr_monto = get('ventas');
    $total = 0;
    foreach ($arr_monto as $monto) {
        $total += $monto['total_prod'];
    }
    return $total;
}
