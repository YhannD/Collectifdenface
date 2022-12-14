window.onload = () => {
    function onChangeCat() {
        // Ici on intercepte les clics
        // On récupère les données du formulaire
        const Form = new FormData(FiltersForm);

        // On fabrique la "queryString"
        const Params = new URLSearchParams();

        Form.forEach((value, key) => {
            Params.append(key, value);
        });

        // On récupère l'url active
        const Url = new URL(window.location.href);

        // On lance la requête ajax
        fetch(Url.pathname + "?" + Params.toString() + "&ajax=1", {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        }).then(response =>
            response.json()
        ).then(data => {
            // On va chercher la zone de contenu
            const content = document.querySelector("#content");

            // On remplace le contenu
            content.innerHTML = data.content;

            // On met à jour l'url
            history.pushState({}, null, Url.pathname + "?" + Params.toString());
        }).catch(e => alert(e));

    }
    const FiltersForm = document.querySelector("#filters");

    // On boucle sur les inputs
    document.querySelectorAll("#filters input").forEach(input => {
        input.addEventListener("change", onChangeCat);
    });
   // document.getElementById("mots").addEventListener("input", onChangeCat);
}