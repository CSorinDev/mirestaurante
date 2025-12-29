const hbBtn = document.querySelector("#hbBtn")

hbBtn.addEventListener("click", () => {
    toggleMenu()
})

function toggleMenu() {
    const navMenu = document.querySelector("#navMenu")

    navMenu.classList.contains("active") 
    ? navMenu.classList.remove("active") 
    : navMenu.classList.add("active")
}

