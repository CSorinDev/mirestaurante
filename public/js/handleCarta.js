window.onload = () => {
    const categoriaButtons = document.querySelectorAll("#categoria-header button")
    const cartaSection = document.querySelector("#carta-section")
    let carta = []

    cartaSection.innerHTML = "<p>Cargando la carta...</p>"
    fetch("/api/carta")
        .then(res => res.json())
        .then(data => {
            carta = data

            if (categoriaButtons.length > 0) {
                filterCarta(categoriaButtons[0].value)
                changeButtonsStyle(categoriaButtons[0])
            } else {
                cartaSection.innerHTML = "No elementos en la carta"
            }

            categoriaButtons.forEach(button => {
                button.onclick = function () { 
                    filterCarta(this.value) 
                    changeButtonsStyle(this)
                }
            })
        })
        .catch(e => {
            cartaSection.innerHTML = "<p>Ha ocurrido un error al intentar cargar la carta</p>"
        })

    function filterCarta(cat) {
        const cartaFiltrada = carta.filter(producto => producto.categoria == cat)
        showCategory(cartaFiltrada)
    }

    function showCategory(carta) {
        cartaSection.innerHTML = carta.map(({ nombre, descripcion, imagen, precio }) => `
        <article class="carta-item">
        ${imagen ? `<img src="uploads/productos/${imagen}" alt="Imagen del plato: ${nombre}">` : ''}
            <h3>${nombre}</h3>
            ${descripcion ? `<p class="descripcion">${descripcion}</p>` : ''}
            <p class="precio">${parseFloat(precio).toFixed(2).replace(".", ",")}€</p>
        </article>
    `).join('');
    }

    function changeButtonsStyle(button) {
        categoriaButtons.forEach(button => button.classList.remove('active'))
        button.classList.add('active')
    }
}