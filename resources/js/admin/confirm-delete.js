const formsToDelete = document.querySelectorAll(".delete-form");

formsToDelete.forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        const confirmation = confirm(
            "Vuoi cancellare definitivamente questo Post? L'azione è irreversibile"
        );
        if (confirmation) form.submit();
    });
});
