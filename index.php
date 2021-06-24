<?php
include 'actions/funciones.php';
session_start();
$productos = get('productos');
$relacion_colores = relacionColorProducto();
$relacion_imagenes = relacionImagenProducto();
$cant_color = 0;
$cant_img = 0;
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="shortcut icon" href="images/logo.ico" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Kit Font Awesome-->
    <script src="https://kit.fontawesome.com/5b23b3e9e6.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!--Links CSS-->
    <link rel="stylesheet" href="css/index.css">
    <title>Amictus</title>
</head>

<body>
    <header>
        <div class="btn-menu">
            <div class="btn-hamb" id="btn"></div>
        </div>
        <nav class="menu-hamburguesa" id="menu">
            <a href="#inicio">INICIO</a>
            <a href="#quienes-somos">QUIENES SOMOS</a>
            <a href="#productos">PRODUCTOS</a>
            <a href="#contacto">CONTACTO</a>
        </nav>

        <div class="logo">
            <a href="index.php"><img src="./images/amictus.png" height="60" alt="logo de la pagina web amictus"></a>
        </div>
        <nav class="menu-principal">
            <a href="#inicio">INICIO</a>
            <a href="#quienes-somos">QUIÉNES SOMOS</a>
            <a href="#productos">PRODUCTOS</a>
            <a href="#contacto">CONTACTO</a>
        </nav>
        <div class="sesion">
            <?php if (isset($_SESSION['usuario_actual'][0]['email'])) { ?>
                <p class="sesion-on"><?php echo $_SESSION['usuario_actual'][0]['email']; ?>
                </p>
                <a class="sesion-on" href="actions/desconectar.php"><i class="fas fa-sign-out-alt"></i></a>
                <?php if ($_SESSION['usuario_actual'][0]['email'] == 'ag171980@gmail.com') { ?>
                    <a href="admin.php">admin</a>
                <?php } else { ?>
                <?php } ?>
            <?php } else { ?>
                <p class="sesion-off" id="crear">CREAR CUENTA</p>
                <p class="sesion-off" id="iniciar">INICIAR SESION</p>
            <?php } ?>
        </div>
        <div class="carrito" id="carrito">
            <img src="./images/carrito.png" height="25" alt="logo de la pagina web amictus">
            <div class="cantidad-carrito">
                <p>0</p>
            </div>
        </div>

    </header>

    <div class="lista-carrito" id="menu-carrito">
        <div class="producto-carrito">
            <div class="datos-producto">
                <img src="./images/producto.jpg" class="carrito-imagen" height="60" alt="Imagen de producto">
                <div class="carrito-descripcion">
                    <h3>Nombre Producto</h3>
                    <p>Cantidad:</p>
                    <p>Color:</p>
                </div>
            </div>
            <p class="carrito-precio">$2500</p>
        </div>
        <div class="producto-carrito">
            <div class="datos-producto">
                <img src="./images/producto.jpg" class="carrito-imagen" height="60" alt="Imagen de producto">
                <div class="carrito-descripcion">
                    <h3>Nombre Producto</h3>
                    <p>Cantidad:</p>
                    <p>Color:</p>
                </div>
            </div>
            <p class="carrito-precio">$2500</p>
        </div>

        <div class="precio-final">
            <div class="subtotal">
                <p class="texto">Subtotal</p>
                <p>$2500</p>
            </div>
            <div class="precio">
                <p class="texto">Precio Final</p>
                <p id="total">$2500</p>
            </div>
        </div>
        <div class="boton-checkout">
            <button>PAGAR</button>
        </div>
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
                <button type="submit" id="enviar">Enviar</button>
            </form>

        </div>
        <div class="mensaje">
            <p id="msg_r"></p>
        </div>
    </div>
    <div class="session iniciar-sesion disabled">
        <div class="box-iniciar">
            <i class="cerrar fas fa-times"></i>
            <h3>Iniciar Sesion</h3>
            <form id="form_validar">
                <label for="email_v">Email</label>
                <input type="email" id="email_v" name="email_v" placeholder="Ingrese su email..." required />
                <label for="pwd_v">Contraseña</label>
                <input type="password" id="pwd_v" name="pwd_v" placeholder="Ingrese su contrasena..." required />
                <button type="submit" id="enviar">Enviar</button>
            </form>
        </div>
        <div class="mensaje">
            <p id="msg_v"></p>
        </div>
    </div>
    <main>
        <div class="imagen" id="inicio">
            <div class="shadow-slider">
                <div class="contenido">
                    <div class="contenido-texto">
                        <h1>AMICTUS</h1>
                        <p>Llevando amor y calma a la vida.</p>
                    </div>
                    <div class="contenido-imagen">
                        <img src="./images/logo.png" height="140" alt="">
                    </div>
                </div>
            </div>
            <div class="slideshow-container">
                <div class="mySlides fade">
                    <img src="./images/slider/slider 1.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./images/slider/slider 2.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./images/slider/slider 3.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./images/slider/slider 4.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./images/slider/slider 5.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./images/slider/slider 6.jpg">
                </div>
                <div class="mySlides fade">
                    <img src="./images/slider/slider 7.jpg">
                </div>
            </div>
            <br>
            <a href="#quienes-somos"><i class="flecha fas fa-chevron-down"></i></a>
        </div>

        <article>
            <section class="quienes-somos" id="quienes-somos">
                <h2>QUIENES SOMOS</h2>
                <div class="contenidos">
                    <div class="contenido contenido-imagen">
                        <img src="./images/QuienesSomos.jpg" alt="">
                    </div>
                    <div class="contenido contenido-texto">
                        <h3>Sobre Amictus</h3>
                        <p>Amictus es un emprendimiento cuyo objetivo a través de sus productos, es ayudarte a conectar con tu ser interior, invitándote a tomarte un momento de calma para vos.
                            El yoga y la meditación son prácticas que con hábito y constancia cambian la vida de quienes las realizan. Por eso es maravilloso poder asistirte acercándote nuestros productos naturales y hechos con amor.
                            Creemos que el mundo necesita personas más felices y conectadas con su interior, es por eso que nos impulsa el desafío de hacer de tu práctica y de tu búsqueda, una experiencia maravillosa, acercándote productos de calidad y brindándote también de la mano de nuestras almohadillas, las bondades sanadoras de la aromaterapia. </p>
                    </div>
                </div>
            </section>
            <section id="productos">
                <h2>PRODUCTOS</h2>
                <div class="productos">
                    <?php foreach ($productos as $prod) { ?>
                        <div class="producto">
                            <?php foreach ($relacion_imagenes as $img) { ?>
                                <?php if ($img['id_producto'] == $prod['id_producto'] && $cant_img == 0) { ?>
                                    <img src="data:image/jpg;base64,<?php echo base64_encode($img['tamano_imagen']); ?>" alt="Imagen del producto <?php echo $prod['nombre_producto']; ?>" class="producto-imagen">
                                <?php $cant_img++;
                                } ?>
                            <?php
                            }
                            $cant_img = 0;
                            ?>
                            <div class="producto-descripcion">
                                <h3><?php echo $prod['nombre_producto']; ?></h3>
                                <p class="descripcion" id="btn-desc">DESCRIPCIÓN <i class="fas fa-chevron-down"></i></p>
                                <p class="descripcion-collapse"><?php echo $prod['descripcion_producto']; ?></p>
                                <h4>COLORES</h4>
                                <div class="caracteristicas">
                                    <div class="colores">
                                        <?php foreach ($relacion_colores as $rel) { ?>
                                            <?php if ($rel['id_producto'] == $prod['id_producto']) { ?>
                                                <div style="height:20px;width:20px;border-radius:50%;background:<?php echo $rel['hex_color'] ?>;margin-right:3px;"></div>
                                            <?php $cant_color++;
                                            } ?>
                                        <?php } ?>
                                    </div>
                                    <div class="precio">
                                        <p>$ <span><?php echo $prod['precio_producto']; ?></span></p>
                                    </div>
                                </div>
                            </div>
                            <button>AGREGAR AL CARRITO</button>
                        </div>
                    <?php } ?>
                </div>
            </section>
        </article>
    </main>
    <footer id="contacto">
        <div class="redes">
            <div class="red tel">
                <a href="tel:+5491123045032"><i class="fas fa-phone-alt"></i></a>
            </div>
            <div class="red email">
                <a href="mailto:aldanaoses@gmail.com" target="_blank"><i class="far fa-envelope"></i></a>
            </div>
            <div class="red wpp">
                <a href="https://api.whatsapp.com/send/?phone=5491123045032" target="_blank"><i class="fab fa-whatsapp"></i></a>
            </div>
            <div class="red ig">
                <a href="https://www.instagram.com/_amictus_/" target="_blank"><i class="fab fa-instagram"></i></a>
            </div>
            <div class="red fb">
                <a href="https://es-la.facebook.com/" target="_blank"><i class="fab fa-facebook-f"></i></a>
            </div>
        </div>
        <p>Desarrollado por <a href="https://golinc.com.ar" target="_blank">Golinc</a> - 2021</p>
    </footer>
    <script src="js/app.js"></script>
    <script src="js/slider.js"></script>
    <script src="js/registrar.js"></script>
</body>

</html>