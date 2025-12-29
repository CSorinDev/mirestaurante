window.onload = getCarta;

const cartaList = document.querySelector("#cartaList");

let carta = [];

function getCarta() {
    fetch("../lib/carta.json")
        .then(res => res.json())
        .then(data => {
            carta = data
            renderCarta(data)
        })
}

function renderCarta(carta, category = "entrantes") {
    toggleCategoryButtonBackground(category)
    
    cartaList.innerHTML = ""
    carta
        .filter(plato => plato.category === category)
        .forEach(({ name, price, description, image }) => {
            const li = document.createElement("li")
            
            if (image) {
                const imageEl = document.createElement("img")
                imageEl.src = image
                imageEl.alt = "imagen plato"
                li.appendChild(imageEl)
            }

            const nameEl = document.createElement("h2")
            nameEl.textContent = name
            li.appendChild(nameEl)

            if (description) {
                const descriptionEl = document.createElement("small")
                descriptionEl.textContent = description
                li.appendChild(descriptionEl)
            }
            
            const priceEl = document.createElement("p")
            priceEl.textContent = price.toFixed(2).replace(".", ",") + "€"
            li.appendChild(priceEl)
            
            cartaList.appendChild(li)
        })
}

const categoryButtons = document.querySelectorAll("#cartaHeader li")

categoryButtons.forEach(button => {
    button.addEventListener("click", () => {
        changeCategory(button.textContent.toLowerCase())
    })
})

function changeCategory(category) {
    renderCarta(carta, category)
}

function toggleCategoryButtonBackground(category) {
    categoryButtons.forEach(button => {
        if (button.textContent.toLowerCase() === category) {
            button.classList.add("active")
        } else {
            button.classList.remove("active")
        }
    })
}