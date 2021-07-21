<header>
    <div class="btn-menu">
        <div class="btn-hamb" id="btn"></div>
    </div>
    <nav class="menu-hamburguesa" id="menu">
        <a href="#inicio">INICIO</a>
        <a href="#quienes-somos">QUIÉNES SOMOS</a>
        <a href="#productos">PRODUCTOS</a>
        <a href="#contacto">CONTACTO</a>
    </nav>
    <div class="logo">
        <a href="index.php"><img src="https://www.amictus.com.ar/images/logoo.png" height="60" width="60" alt="logo de la pagina web amictus"></a>
    </div>
    <nav class="menu-principal">
        <a href="#inicio">INICIO</a>
        <a href="#quienes-somos">QUIÉNES SOMOS</a>
        <a href="#productos">PRODUCTOS</a>
        <a href="#contacto">CONTACTO</a>
    </nav>
    <div class="carrito" id="carrito">
        <img src="https://www.amictus.com.ar/images/carrito.png" height="25" width="33" alt="logo de la pagina web amictus">
        <div class="cantidad-carrito">
            <p><?php echo $cant; ?></p>
        </div>
    </div>
</header>
<div class="usuario">
    <div class="sesion">
        <?php if (isset($_SESSION['usuario_amictus'][0]['email'])) { ?>
            <p class="sesion-on"><?php echo $_SESSION['usuario_amictus'][0]['email']; ?>
            </p>
            <div class="sesion-on">
                <i class="fas fa-sign-out-alt"></i>
                <a href="actions/desconectar.php">Salir</a>
            </div>
            <?php if ($_SESSION['usuario_amictus'][0]['email'] == 'ag171980@gmail.com' || $_SESSION['usuario_amictus'][0]['email'] == 'amictus12@gmail.com') { ?>
                <div class="sesion-on">
                    <i class="fas fa-user-cog"></i>
                    <a href="admin.php">admin</a>
                </div>
            <?php } else { ?>
            <?php } ?>
        <?php } else { ?>
            <div class="sesion-off">
                <i class="fas fa-user-plus"></i>
                <p id="crear">CREAR CUENTA</p>
            </div>
            <div class="sesion-off">
                <i class="fas fa-sign-in-alt"></i>
                <p id="iniciar">INICIAR SESIÓN</p>
            </div>
        <?php } ?>
    </div>
</div>
<div class="lista-carrito" id="menu-carrito">
    <?php for ($i = 0; $i < count($_SESSION['carrito_amictus']); $i++) { ?>
        <?php if ($_SESSION['carrito_amictus'][$i] != NULL) { ?>
            <div class="producto-carrito">
                <form action="actions/carrito.php" method="POST">
                    <input style="display: none;" name="id" type="text" value="<?php echo $_SESSION['carrito_amictus'][$i]['id_producto']; ?>" />
                    <button type="submit" name="carrito" value="eliminar">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
                <div class="datos-producto">
                    <img src="<?php echo 'data:image/jpg;base64,' . base64_encode($_SESSION['carrito_amictus'][$i]['imagen_producto']); ?>" class="carrito-imagen" height="60" width="50" alt="<?php echo $_SESSION['carrito_amictus'][$i]['descripcion_producto']; ?>">
                    <div class="carrito-descripcion">
                        <h3><?php echo $_SESSION['carrito_amictus'][$i]['nombre_producto']; ?></h3>
                        <p>Cantidad: <b><?php echo $_SESSION['carrito_amictus'][$i]['cantidad_producto']; ?></b></p>
                        <p>Color: <b><?php echo $_SESSION['carrito_amictus'][$i]['color_producto'] ?></b></p>
                    </div>
                </div>
                <p class="carrito-precio">$<?php echo $_SESSION['carrito_amictus'][$i]['precio_producto'] * $_SESSION['carrito_amictus'][$i]['cantidad_producto']; ?></p>
                <?php $total = $total + ($_SESSION['carrito_amictus'][$i]['precio_producto'] * $_SESSION['carrito_amictus'][$i]['cantidad_producto']); ?>
            </div>
        <?php } ?>
    <?php } ?>

    <div class="precio-final">
        <div class="subtotal">
            <p class="texto">Subtotal</p>
            <p>$<?php echo $total; ?></p>
        </div>
        <div class="precio">
            <p class="texto">Precio Final</p>
            <p id="total">$<?php echo $total; ?></p>
        </div>
    </div>
    <?php if ($_SESSION['carrito_amictus']) { ?>
        <div class="boton-checkout"></div>
    <?php } ?>

</div>
<div class="session crear-cuenta disabled">
    <div class="box-crear">
        <i class="cerrar fas fa-times"></i>
        <h3>Crear Cuenta</h3>
        <form id="form_registro">
            <label for="nombre_r">Nombre</label>
            <input type="text" id="nombre_r" name="nombre_r" placeholder="Ingrese su nombre..." required />
            <label for="email_r">Email</label>
            <input type="email" id="email_r" name="email_r" placeholder="Ingrese su email..." required />
            <label for="pwd_r">Contraseña</label>
            <input type="password" id="pwd_r" name="pwd_r" placeholder="Ingrese su contrasena..." required />
            <button type="submit" class="enviar">Enviar</button>
        </form>
    </div>
    <div class="mensaje">
        <p id="msg_r"></p>
    </div>
</div>
<div class="session iniciar-sesion disabled">
    <div class="box-iniciar">
        <i class="cerrar fas fa-times"></i>
        <h3>Iniciar Sesión</h3>
        <form id="form_validar">
            <label for="email_v">Email</label>
            <input type="email" id="email_v" name="email_v" placeholder="Ingrese su email..." required />
            <label for="pwd_v">Contraseña</label>
            <input type="password" id="pwd_v" name="pwd_v" placeholder="Ingrese su contrasena..." required />
            <button type="submit" class="enviar">Enviar</button>
        </form>
    </div>
    <div class="mensaje">
        <p id="msg_v"></p>
    </div>
</div>