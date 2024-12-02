function toggleMenu() {
    const menu = document.getElementById("dropdown-menu");
    const isVisible = menu.classList.contains("opacity-100");

    if (isVisible) {
    // Masquer le menu
    menu.classList.remove("opacity-100", "scale-100");
    menu.classList.add("opacity-0", "scale-95");
    } else {
    // Afficher le menu
    menu.classList.remove("opacity-0", "scale-95");
    menu.classList.add("opacity-100", "scale-100");
    }
}

// Cacher le menu si l'utilisateur clique en dehors
window.addEventListener("click", (event) => {
    const menu = document.getElementById("dropdown-menu");
    const button = document.getElementById("menu-button");
    if (!menu.contains(event.target) && !button.contains(event.target)) {
    menu.classList.remove("opacity-100", "scale-100");
    menu.classList.add("opacity-0", "scale-95");
    }
});