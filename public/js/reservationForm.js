const form = document.querySelector("#reservationForm")

document.onload = form.name.focus()

form.onsubmit = handleSubmit

function handleSubmit(ev) {
    ev.preventDefault()

    console.log("manejar el formulario de la reserva")
}