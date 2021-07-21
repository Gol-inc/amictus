let btn = document.getElementsByClassName("btn")
let cerrar = document.getElementsByClassName("cerrar")

let modals = document.getElementsByClassName("modals");

let editar = document.getElementsByClassName("editar")
let edit = document.getElementsByClassName("edit")
let closed_e = document.getElementsByClassName("closed_e")
let borrar = document.getElementsByClassName("eliminar")
let delet = document.getElementsByClassName("delete")
let closed_d = document.getElementsByClassName("closed_d")
//Colores
let form_colores = document.getElementsByClassName("form_colores")
let form_edit_colores = document.getElementsByClassName("form_edit_colores");
let form_delete_colores = document.getElementsByClassName("form_delete_colores");
//Categorias
let form_categorias = document.getElementsByClassName("form_categorias")
let form_edit_categorias = document.getElementsByClassName("form_edit_categorias")
let form_delete_categorias = document.getElementsByClassName("form_delete_categorias")
//Usuarios
let form_delete_usuarios = document.getElementsByClassName("form_delete_usuarios")

let state_modals = true;
function accion(accion, tipo, archivo) {
    for (let f = 0; f < accion.length; f++) {
        accion[f].addEventListener("submit", () => {
            var datos_validar = new FormData(accion[f]);
            fetch(`actions/${archivo}?msg=${tipo}`, {
                method: "POST",
                headers: {
                    "Access-Control-Allow-Origin": "*"
                },
                body: datos_validar
            })
                .then(res => res.json())
                .then(data => {
                    console.log(data)
                    window.location = "admin.php"
                })
                .catch(function (error) {
                    alert(error)
                    console.log(error)
                })
        })
    }
}
function modal(accion, modal, close, state) {
    for (let d = 0; d < close.length; d++) {
        accion[d].addEventListener("click", () => {
            if (state) {
                modal[d].classList.remove("disabled")
                state = false;
            }
        })
        close[d].addEventListener("click", () => {
            if (!state) {
                modal[d].classList.add("disabled");
                state = true;
            }
        })
    }
}
//Colores
accion(form_colores, "Agregar", "colores.php")
accion(form_edit_colores, "Editar", "colores.php")
accion(form_delete_colores, "Eliminar", "colores.php")
//Categorias
accion(form_categorias, "Agregar", "categorias.php")
accion(form_edit_categorias, "Editar", "categorias.php")
accion(form_delete_categorias, "Eliminar", "categorias.php")
//Usuarios
accion(form_delete_usuarios, "Eliminar", "usuarios.php")

modal(btn, modals, cerrar, state_modals)
modal(borrar, delet, closed_d, state_modals)
modal(editar, edit, closed_e, state_modals)