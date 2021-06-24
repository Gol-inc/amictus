<?php
include "funciones.php";
$msg = validarUsuario();
echo json_encode($msg);
