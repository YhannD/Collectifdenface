import {onChangeAjax} from "./modules/OnChangeAjax";
// import {interfaceAjax} from "./modules/InterfaceAjax";


const FiltersForm = document.querySelector("#filters");

// On boucle sur les inputs
document.querySelectorAll("#filters input").forEach(input => {
    input.addEventListener("change", onChangeAjax);
});
document.getElementById("mots").addEventListener("input", onChangeAjax);

onChangeAjax()
// onChangeAjax(FiltersForm);

// interfaceAjax();