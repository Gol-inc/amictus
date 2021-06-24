let sesion = document.getElementsByClassName("session");
let form_registro = document.getElementById("form_registro");
let form_validar = document.getElementById("form_validar");
let msg_r = document.getElementById("msg_r");
let msg_v = document.getElementById("msg_v");
let cerrar = document.getElementsByClassName("cerrar");
let opciones = document.getElementsByClassName("sesion-off")

let states = true;
for (let f = 0; f < cerrar.length; f++) {
    cerrar[f].addEventListener("click", () => {
        if (states) {
            sesion[f].classList.add("disabled");
            states = false;
        } else {
            sesion[f].classList.remove("disabled");
            states = true;
        }
    })
    opciones[f].addEventListener("click", () => {
        if (states) {
            sesion[f].classList.add("disabled");
            states = false;
        } else {
            sesion[f].classList.remove("disabled");
            states = true;
        }
    })
}
form_validar.addEventListener("submit", (e) => {
    e.preventDefault();
    var datos_validar = new FormData(form_validar);

    fetch("actions/validar.php", {
        method: "POST",
        body: datos_validar,
    })
        .then(res => res.json())
        .then(data => {
            msg_v.innerText = data;

            $(".mensaje").show(500).fadeIn();
            setTimeout(() => {
                $(".mensaje").fadeOut(500);
                window.location = "index.php"
            }, 3000);
        })
        .catch(function (error) {
            alert(error)
        })

})
form_registro.addEventListener("submit", (e) => {
    e.preventDefault();
    var datos_registro = new FormData(form_registro);

    fetch("actions/registrar.php", {
        method: "POST",
        body: datos_registro,
    })
        .then(res => res.json())
        .then(data => {
            msg_r.innerText = data;

            $(".mensaje").show(500).fadeIn();
            setTimeout(() => {
                $(".mensaje").fadeOut(500);
                window.location = "index.php"
            }, 3000);
        })
        .catch(function (error) {
            alert(error)
        })

})
