import {onChangeAjax} from "./OnChangeAjax";

export function interfaceAjax() {

// On boucle sur les inputs
document.querySelectorAll("#filters input").forEach(input => {
    input.addEventListener("change", onChangeAjax);
});
document.getElementById("mots").addEventListener("input", onChangeAjax);

}