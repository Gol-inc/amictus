let state, st, collapse = true
let states = false
var slideIndex = 0
showSlides()
let btn = document.getElementById("btn")
let menu = document.getElementById("menu")
btn.addEventListener('click', () => {
    if (!state) {
        btn.classList.add("x")
        menu.classList.add("show")
        state = true
    } else {
        btn.classList.remove("x")
        menu.classList.remove("show")
        state = false
    }
})
let carrito = document.getElementById("carrito")
let menu_carrito = document.getElementById("menu-carrito")
carrito.addEventListener('click', () => {
    if (!state) {
        menu_carrito.classList.add("show-menu")
        state = true
    } else {
        menu_carrito.classList.remove("show-menu")
        state = false
    }
})
let cerrar = document.getElementsByClassName("cerrar")
let opciones = document.getElementsByClassName("sesion-off")
let sesion = document.getElementsByClassName("session")
modalUsuario(opciones)
modalUsuario(cerrar)
let form_registro = document.getElementById("form_registro")
let msg_r = document.getElementById("msg_r")
conectarUsuario(form_registro, "registrar.php", msg_r)
let form_validar = document.getElementById("form_validar")
let msg_v = document.getElementById("msg_v")
conectarUsuario(form_validar, "validar.php", msg_v)
let productos = document.getElementById("contenido-productos")
let destacados = document.getElementById("productos-destacados")
let modal_producto = document.getElementsByClassName("modal-producto")
let div_checkbox = document.getElementsByClassName("checkbox")
let label_categoria = document.getElementsByClassName("categoria")
let check = document.getElementsByClassName("check")
let checked = []
getProductos()
for (let c = 0; c < div_checkbox.length; c++) {
    div_checkbox[c].addEventListener("change", () => {
        if (check[c].checked) {
            postProductos(searchValue, label_categoria[c].innerHTML)
        } else {
            postProductos(deleteValue, label_categoria[c].innerHTML)
            if (checked.length == 0) {
                getProductos()
            }
        }
    })
}
