document.addEventListener("DOMContentLoaded", () => {
    // open modal
    document.querySelectorAll("[data-modal-target]").forEach((btn) => {
        btn.addEventListener("click", () => {
            const id = btn.getAttribute("data-modal-target");
            const modal = document.getElementById(id);
            if (modal) modal.classList.add("is-open");
        });
    });

    // close modal
    document.querySelectorAll("[data-modal-close]").forEach((el) => {
        el.addEventListener("click", () => {
            const modal = el.closest(".admin__modal");
            if (modal) modal.classList.remove("is-open");
        });
    });
});
