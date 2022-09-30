const formsToDelete = document.querySelectorAll(".delete-form");

formsToDelete.forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const target = form.classList.contains("delete-all")
            ? "tutti i"
            : "questo";

        const confirmation = confirm(
            `Vuoi cancellare definitivamente ${target} Post? L'azione è irreversibile`
        );

        if (confirmation) form.submit();
    });
});
