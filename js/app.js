let btn = document.getElementById("btn")
let menu = document.getElementById("menu")
let carrito = document.getElementById("carrito")
let btn_desc = document.getElementsByClassName("descripcion")
let desc_collapse = document.getElementsByClassName("descripcion-collapse")
let menu_carrito = document.getElementById("menu-carrito")
let state, st, collapse = true;
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
for (let i = 0; i < btn_desc.length; i++) {
    btn_desc[i].addEventListener("click", () => {
        if (collapse) {
            desc_collapse[i].classList.add("collapsed")
            collapse = false
        } else {
            desc_collapse[i].classList.remove("collapsed")
            collapse = true
        }
    })
}