<?php
error_reporting(0);
include 'actions/funciones.php';
session_start();
$categorias = get('categorias');
$total = 0;
$cant = 0;
$carrito = [];
require __DIR__ .  '/vendor/autoload.php';
$public_key = "APP_USR-5e2621b6-a7a1-44b7-b28e-0346d89f03d2";
//Pk prod: APP_USR-5e2621b6-a7a1-44b7-b28e-0346d89f03d2
//Pk pruebas: TEST-4be8c50a-1d4d-45a5-994d-9cd6be02a6ac
$access_token = "APP_USR-1065558483328361-071223-8ea1dbe049725ae14004429feba2cca1-24781796";
//At prod: APP_USR-1065558483328361-071223-8ea1dbe049725ae14004429feba2cca1-24781796
//At pruebas: TEST-1065558483328361-071223-a628885f6a9a26106926eeeda57c08e8-24781796
MercadoPago\SDK::setAccessToken($access_token);
$preference = new MercadoPago\Preference();
$preference->back_urls = array(
    "success" => "https://www.amictus.com.ar/actions/registro_pago.php",
    "failure" => "https://www.amictus.com.ar/error.php",
    "pending" => "https://www.amictus.com.ar/pendiente.php"
);
$preference->auto_return = "approved";
for ($i = 0; $i < count($_SESSION['carrito_amictus']); $i++) {
    if ($_SESSION['carrito_amictus'][$i]['precio_producto'] != 0) {
        $item = new MercadoPago\Item();
        $item->title = $_SESSION['carrito_amictus'][$i]['nombre_producto'];
        $item->quantity = $_SESSION['carrito_amictus'][$i]['cantidad_producto'];
        $item->unit_price = $_SESSION['carrito_amictus'][$i]['precio_producto'];
        $cant++;
        $carrito[] = $item;
    }
}
$preference->items = $carrito;
$preference->save();

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Amictus</title>
    <meta http-equiv="X-UA-Compaatible" charset="text/html; UTF-8">
    <meta property="og:site_name" content="website" />
    <meta property="og:title" content="Amictus" />
    <meta property="og:url" content="https://www.amictus.com.ar" />
    <meta property="og:image" content="https://www.amictus.com.ar/images/logo.png" />
    <meta property="og:image:secure_url" content="https://www.amictus.com.ar/images/logo.png" />
    <meta property="og:description" content="Es una tienda online de un emprendimiento cuyo objetivo a través de sus productos, es ayudarte a conectar con tu ser interior, invitándote a tomarte un momento de calma para vos." />
    <meta name="author" content="Aldana" />
    <meta name="copyright" content="Golinc" />
    <meta name="robots" content="index,follow" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="canonical" href="https://www.amictus.com.ar/" />
    <link rel="shortcut icon" href="https://www.amictus.com.ar/images/logo.ico" />
    <link rel="stylesheet" href="./css/index.css">
    <script src="https://www.amictus.com.ar/js/functions.js"></script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-7Y660HLBCD"></script>
    <script async>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-7Y660HLBCD');
    </script>
    <script async src="https://kit.fontawesome.com/5b23b3e9e6.js" crossorigin="anonymous"></script>
    <script async src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <?php include './components/header.php'; ?>
    <main>
        <div class="imagen" id="inicio">
            <div class="shadow-slider">
                <div class="contenido">
                    <div class="contenido-texto">
                        <h1>AMICTUS</h1>
                        <p>Llevando amor y calma a la vida.</p>
                    </div>
                    <div class="contenido-imagen">
                        <img src="https://www.amictus.com.ar/images/logo.png" height="200" width="200" alt="">
                    </div>
                </div>
            </div>
            <div class="slideshow-container">
                <div class="mySlides fade">
                    <img height="100" width="100" src="https://www.amictus.com.ar/images/slider/1.jpg">
                </div>
                <div class="mySlides fade">
                    <img height="100" width="100" src="https://www.amictus.com.ar/images/slider/2.jpg">
                </div>
            </div>
            <br>
            <a href="#quienes-somos"><i class="flecha fas fa-chevron-down"></i></a>
        </div>
        <article>
            <section class="quienes-somos" id="quienes-somos">
                <h2>QUIÉNES SOMOS</h2>
                <div class="contenidos">
                    <div class="contenido contenido-imagen">
                        <img height="100" width="100" src="https://www.amictus.com.ar/images/QuienesSomos.jpg" alt="imagen referida a que es amatista y que vende">
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
                <h2>DESTACADOS</h2>
                <div class="productos">
                    <div class="destacados">
                        <div class="productos-destacados" id="productos-destacados"></div>
                    </div>
                    <div class="separador"></div>
                    <div class="mas-productos">
                        <div class="categorias">
                            <h3>CATEGORÍAS</h3>
                            <div class="menu-categorias">
                                <?php foreach ($categorias as $cat) { ?>
                                    <div class="checkbox">
                                        <input type="checkbox" id="categoria<?php echo $cat['id_categoria']; ?>" class="check" name="categoria">
                                        <label class="categoria" for="categoria<?php echo $cat['id_categoria']; ?>"><?php echo $cat['nombre_categoria']; ?></label>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="productos" id="contenido-productos"></div>
                    </div>
                </div>
            </section>
        </article>
    </main>
    <?php include './components/footer.php'; ?>
    <script src="https://www.amictus.com.ar/js/app.js"></script>
    <script src="https://sdk.mercadopago.com/js/v2"></script>
    <script>
        const mp = new MercadoPago('<?php echo $public_key; ?>', {
            locale: 'es-AR'
        });
        mp.checkout({
            preference: {
                id: '<?php echo $preference->id; ?>'
            },
            render: {
                container: '.boton-checkout',
                label: 'PAGAR',
            }
        });
    </script>
</body>

</html>