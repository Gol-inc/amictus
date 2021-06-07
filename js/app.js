let btn = document.getElementById("btn")
let menu = document.getElementById("menu")
let carrito = document.getElementById("carrito")
let menu_carrito = document.getElementById("menu-carrito")
let state, st = true;
btn.addEventListener('click', () => {
    if (state) {
        btn.classList.add("x")
        menu.classList.add("show")
        console.log(btn)
        state = false
    } else {
        btn.classList.remove("x")
        menu.classList.remove("show")
        console.log(btn)
        state = true
    }
})
carrito.addEventListener('click', () => {
    if (st) {
        menu_carrito.classList.add("show-menu")
        console.log(menu_carrito)
        st = false;
    } else {
        menu_carrito.classList.remove("show-menu")
        st = true;
    }
})