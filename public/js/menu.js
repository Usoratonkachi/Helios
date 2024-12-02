document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll("nav#nav ul li").forEach(item => {
        const submenu = item.querySelector("ul");
        if (submenu) {
            item.addEventListener("mouseenter", () => submenu.style.display = "block");
            item.addEventListener("mouseleave", () => submenu.style.display = "none");
        }
    });
});
