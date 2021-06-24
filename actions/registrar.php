<?php

include "funciones.php";
$msg = registrarUsuario();
echo json_encode($msg);
