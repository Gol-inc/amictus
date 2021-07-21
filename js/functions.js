function searchValue(value, arr) {
    if (arr.length == 0) {
        arr.push(value)
    } else {
        for (let i = 0; i < arr.length; i++) {
            if (arr[i] == value) {
            } else {
                arr.push(value)
                break;
            }
        }
    }
    return arr;
}
function deleteValue(value, arr) {
    var exists = arr.indexOf(value)
    if (exists !== -1) {
        arr.splice(exists, 1)
    }
}
function getProductos() {
    fetch("actions/cargar.php?accion=Cargar", {
        method: "GET",
    })
        .then(res => res.json())
        .then(data => {
            mostrarProducto(data, destacados, "1")
            mostrarProducto(data, productos, "0")
        })
        .catch(error => {
            alert(error)
        })
}
function postProductos(obj, item) {
    obj(item, checked)
    const formData = new FormData()
    const json = checked
    formData.append('categorias', json)
    fetch(`actions/cargar.php?accion=Categoria`, {
        method: "POST",
        body: formData
    })
        .then(res => res.json())
        .then(data => {
            console.log(data)
            mostrarProducto(data, productos, "0")
        })
        .catch(error => {
            alert(error)
        })
}
function mostrarProducto(array, clase, tipo) {
    clase.innerHTML = ""
    if (array.length == 0) {
        clase.innerHTML = "<p class='catalogo-vacio' style='color:#c0492c;'>No hay productos para esta categoria</p>"
    } else {
        for (let i = 0; i < array.length; i++) {
            let colores_p_n, n_col = ""
            for (let j = 0; j < array[i].colores.length; j++) {
                n_col += `<div class="col-prod">
                    <p style="background:${array[i].colores[j].codigo};height:20px;width:20px;border-radius:50%;margin:5px 0px;"></p>
                    <p class="nombre-color">${array[i].colores[j].nombre}</p>
                </div>`

                colores_p_n += `<option value="${array[i].colores[j].nombre}"></option>`

            }
            if (array[i].destacado == tipo) {
                clase.innerHTML += `
            <div class="producto">
                <img src="${array[i].imagen[0]}" alt="Imagen del producto ${array[i].nombre}" class="producto-imagen">
                <div class="producto-descripcion">
                    <h3 class='vermas'>${array[i].nombre}</h3>
                    <div class="precio">
                        <p>$ <span>${array[i].precio}</span></p>
                    </div>
                </div>
            </div>
            <div class="disabled modal-producto">
                <div class="info-producto">
                    <div class="head-producto">
                        <i class="quit-modal fas fa-times"></i>
                    </div>
                    <div class="modal-descripcion">
                        <div class="modal-descripcion-imagen">                    
                            <div class="imagen-principal">
                                <img src="${array[i].imagen[0]}" class="producto-imagen">
                            </div>
                            <div class="imagenes-secundarias">
                                <img src="${array[i].imagen[0]}" class="producto-imagen">
                            </div>
                        </div>
                        <div class="modal-descripcion-texto">
                            <div class="descripcion-texto">
                                <div class="descripcion-principal">
                                    <h1>${array[i].nombre}</h1>
                                    <p class="precio">$<span>${array[i].precio}</span></p>
                                </div>
                                <p>${array[i].descripcion}</p>
                            </div>
                            <div class="modal-boton">
                                <div class="colores">
                                    <h3>COLORES</h3>
                                    <div class="datos-color">`+ n_col + `
                                    </div>
                                </div>
                                <form method="POST" action="actions/carrito.php">
                                    <div class="cl">
                                        <label for="color">Color</label>
                                        <input list="colores${i}" name="lista_colores" />            
                                        <datalist id="colores${i}" class="col">` + colores_p_n + `</datalist>
                                    </div>
                                    <div class="cantidad">
                                        <label for="cant${i}">Cantidad</label>
                                        <input type="number" id="cant${i}" name="cantidad" min="0" max="${array[i].stock}" required />
                                    </div>
                                    <input style="display:none;" name="id_producto" type="text" value="${array[i].id_producto}" />
                                    <button type="submit" name="carrito" value="agregar">AGREGAR AL CARRITO</button>
                                </form>
                            </div>
                        </div> 
                    </div>  
                </div>
            </div>
            `;
            }
        }
    }
    let vermas = document.getElementsByClassName("vermas")
    let cer = document.getElementsByClassName("quit-modal")
    for (let i = 0; i < vermas.length; i++) {
        vermas[i].addEventListener("click", (e) => {
            if (!state) {
                modal_producto[i].classList.remove("disabled")
                state = true
            }
        })
        cer[i].addEventListener("click", () => {
            if (state) {
                modal_producto[i].classList.add("disabled")
                state = false
            }
        })
    }
}
function showSlides() {
    var i;
    var slides = document.getElementsByClassName("mySlides");
    for (i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"
    }
    slideIndex++;
    if (slideIndex > slides.length) { slideIndex = 1 }
    slides[slideIndex - 1].style.display = "block"
    setTimeout(showSlides, 4500)
}
function conectarUsuario(tipo, archivo, divMsg) {
    tipo.addEventListener("submit", (e) => {
        e.preventDefault()
        var datos_registro = new FormData(tipo)
        fetch(`actions/${archivo}`, {
            method: "POST",
            body: datos_registro,
        })
            .then(res => res.json())
            .then(data => {
                divMsg.innerText = data

                $(".mensaje").show(500).fadeIn()
                setTimeout(() => {
                    $(".mensaje").fadeOut(500);
                    window.location = "index.php"
                }, 3000);
            })
            .catch(function (error) {
                alert(error)
            })
    })
}
function modalUsuario(tipo) {
    for (let f = 0; f < tipo.length; f++) {
        tipo[f].addEventListener("click", () => {
            if (states) {
                sesion[f].classList.add("disabled")
                states = false
            } else {
                sesion[f].classList.remove("disabled")
                states = true
            }
        })
    }
}