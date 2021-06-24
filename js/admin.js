let btn = document.getElementsByClassName("btn")
let cerrar = document.getElementsByClassName("cerrar")
let closed_e = document.getElementsByClassName("closed_e")
let closed_d = document.getElementsByClassName("closed_d")

let modals = document.getElementsByClassName("modals");
let state_modals = true;

let editar = document.getElementsByClassName("editar")
let edit = document.getElementsByClassName("edit")
let borrar = document.getElementsByClassName("eliminar")
let delet = document.getElementsByClassName("delete")

//Productos
let form_productos = document.getElementById("form_productos");
let form_edit_productos = document.getElementsByClassName("form_edit_productos");
let form_delete_productos = document.getElementsByClassName("form_delete_productos");

//Colores
let form_colores = document.getElementById("form_colores")
let form_edit_colores = document.getElementsByClassName("form_edit_colores");
let form_delete_colores = document.getElementsByClassName("form_delete_colores");

let mensaje = document.getElementsByClassName("msg")

function accion(accion, tipo, archivo) {
    for (let f = 0; f < accion.length; f++) {
        accion[f].addEventListener("submit", () => {
            var datos_validar = new FormData(accion[f]);
            fetch(`actions/${archivo}?msg=${tipo}`, {
                method: "POST",
                body: datos_validar
            })
                .then(res => res.json())
                .then(data => {
                    console.log(data)
                    window.location = "admin.php"
                })
                .catch(function (error) {
                    alert(error)
                })
        })
    }
}

function agregar(accion, archivo) {
    accion.addEventListener("submit", (e) => {
        e.preventDefault();
        var datos = new FormData(accion);

        fetch(`actions/${archivo}?msg=Agregar`, {
            method: "POST",
            body: datos,
        })
            .then(res => res.json())
            .then(data => {
                console.log(data)
                mensaje[0].textContent = data;
                $(".mensaje").show(500).fadeIn();
                setTimeout(() => {
                    $(".mensaje").fadeOut(500);
                    window.location = "admin.php"
                }, 3000);
            })
            .catch(function (error) {
                alert(error)
            })
    })
}

agregar(form_productos, "productos.php")
accion(form_edit_productos, "Editar", "producto.php")
accion(form_delete_productos, "Eliminar", "producto.php")

agregar(form_colores, "colores.php")
accion(form_edit_colores, "Editar", "colores.php")
accion(form_delete_colores, "Eliminar", "colores.php")


for (let i = 0; i < btn.length; i++) {
    btn[i].addEventListener("click", () => {
        console.log(btn[i])
        if (state_modals) {
            modals[i].classList.remove("disabled")
            state_modals = false
        }
    })

    cerrar[i].addEventListener("click", () => {
        if (!state_modals) {
            modals[i].classList.add("disabled");
            state_modals = true;
        }
    })
}

for (let s = 0; s < closed_e.length; s++) {
    editar[s].addEventListener("click", () => {
        if (state_modals) {
            edit[s].classList.remove("disabled")
            state_modals = false;
        }
    })
    closed_e[s].addEventListener("click", () => {
        if (!state_modals) {
            edit[s].classList.add("disabled")
            state_modals = true;
        }
    })
}

for (let d = 0; d < closed_d.length; d++) {
    borrar[d].addEventListener("click", () => {
        if (state_modals) {
            delet[d].classList.remove("disabled")
            state_modals = false;
        }
    })
    closed_d[d].addEventListener("click", () => {
        if (!state_modals) {
            delet[d].classList.add("disabled");
            state_modals = true;
        }
    })
}

