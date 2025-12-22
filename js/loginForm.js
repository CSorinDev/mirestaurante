const form = document.querySelector("#loginForm")

document.onload = form.username.focus()

form.onsubmit = handleSubmit

function handleSubmit(ev) {
    ev.preventDefault()

    console.log("login form - handle submit")
}