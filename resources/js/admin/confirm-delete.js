const formsToDelete = document.querySelectorAll(".delete-form");

formsToDelete.forEach((form) => {
    form.addEventListener("submit", (e) => {
        e.preventDefault();

        let target = form.classList.contains("delete-all") ? "tutti i" : "questo";
        let element = "l'elemento";
        const cls = form.classList;
        
        switch (true) {
            case cls.contains("delete-tag"):
                element = "Tag";
                break;
            case cls.contains("delete-post"):
                element = "Post";
                break;
            case cls.contains("delete-category"):
                element = "Categoria";
                target = form.classList.contains("delete-all") ? "tutte le" : "questa";
                if(target == "tutte le") element = "Categorie";
                break;
        }

        const confirmation = confirm(`Vuoi cancellare definitivamente ${target} ${element}? L'azione è irreversibile`);
        if (confirmation) form.submit();
    });
});
