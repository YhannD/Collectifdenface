export class FiltersForm {
    constructor(formId) {
        this.formElement = document.querySelector(`#${formId}`);
        this.inputElements = document.querySelectorAll(`#${formId} input`);

        this.defaultValues = {};

        this.inputElements.forEach(input => {
            this.defaultValues[input.name] = input.value;
            input.addEventListener("change", () => this.onChange());
        });

        document.getElementById("mots").addEventListener("input", () => this.onChange());

        window.addEventListener("beforeunload", () => this.resetValues());

        // Get a reference to the "clear" button and add an event listener
        const clearButton = document.getElementById("clearText");
        clearButton.addEventListener('click', () => this.clearInput('mots'));
    }

    // Add a clearInput method to clear the value of the input to the formId
    clearInput(inputId) {
        // Get a reference to the input element
        const input = document.getElementById(inputId);

        // Set the value of the input to an empty string
        input.value = '';
        //la fonction natif .dispatchEvent permet de simuler le change
        input.dispatchEvent(new Event('change'));
    }

    async onChange() {
        const Form = new FormData(this.formElement);
        const Params = new URLSearchParams();
        Form.forEach((value, key) => {
            Params.append(key, value);
        });

        const Url = new URL(window.location.href);

        try {
            const fetchUrl = this.buildFetchUrl(Url.pathname, Params);
            const response = await fetch(fetchUrl, {
                headers: {
                    "X-Requested-With": "XMLHttpRequest"
                }
            });
            const data = await response.json();
            const content = document.querySelector("#content");
            content.innerHTML = data.content;
        } catch (e) {
            alert(e);
        }
    }

    buildFetchUrl(pathname, params) {
        return `${pathname}?${params.toString()}&ajax=1`;
    }

    resetValues() {
        // Loop through each input element
        this.inputElements.forEach(input => {
            // Set the value of the input to the default value stored in the defaultValues object
            input.value = this.defaultValues[input.name];
        });
    }
}

// export class FiltersForm {
//     constructor(formId) {
//         this.formElement = document.querySelector(`#${formId}`);
//         this.inputElements = document.querySelectorAll(`#${formId} input`);
//
//         this.defaultValues = {};
//
//         this.inputElements.forEach(input => {
//             this.defaultValues[input.name] = input.value;
//             input.addEventListener("change", () => this.onChange());
//         });
//
//         document.getElementById("mots").addEventListener("input", () => this.onChange());
//
//         window.addEventListener("beforeunload", () => this.resetValues());
//     }
//
//     async onChange() {
//         const Form = new FormData(this.formElement);
//         const Params = new URLSearchParams();
//         Form.forEach((value, key) => {
//             Params.append(key, value);
//         });
//
//         const Url = new URL(window.location.href);
//
//         try {
//             const fetchUrl = this.buildFetchUrl(Url.pathname, Params);
//             const response = await fetch(fetchUrl, {
//                 headers: {
//                     "X-Requested-With": "XMLHttpRequest"
//                 }
//             });
//             const data = await response.json();
//             const content = document.querySelector("#content");
//             content.innerHTML = data.content;
//         } catch (e) {
//             alert(e);
//         }
//     }
//
//     buildFetchUrl(pathname, params) {
//         return `${pathname}?${params.toString()}&ajax=1`;
//     }
//
//     resetValues() {
//         this.inputElements.forEach(input => {
//             input.value = this.defaultValues[input.name];
//         });
//     }
// }

// export class FiltersForm {
//     constructor(formId) {
//         this.formElement = document.querySelector(`#${formId}`);
//         this.inputElements = document.querySelectorAll(`#${formId} input`);
//
//         this.inputElements.forEach(input => {
//             input.addEventListener("change", () => this.onChange());
//         });
//
//         document.getElementById("mots").addEventListener("input", () => this.onChange());
//     }
//
//     async onChange() {
//         const Form = new FormData(this.formElement);
//         const Params = new URLSearchParams();
//         Form.forEach((value, key) => {
//             Params.append(key, value);
//         });
//
//         const Url = new URL(window.location.href);
//
//         try {
//             const fetchUrl = this.buildFetchUrl(Url.pathname, Params);
//             const response = await fetch(fetchUrl, {
//                 headers: {
//                     "X-Requested-With": "XMLHttpRequest"
//                 }
//             });
//             const data = await response.json();
//             const content = document.querySelector("#content");
//             content.innerHTML = data.content;
//             history.pushState({}, null, fetchUrl);
//         } catch (e) {
//             alert(e);
//         }
//     }
//
//     buildFetchUrl(pathname, params) {
//         return `${pathname}?${params.toString()}&ajax=1`;
//     }
//
// }
// export class FormHandler {
//     constructor(formId, inputId) {
//         this.form = document.querySelector(formId);
//         this.input = document.querySelector(inputId);
//         this.input.addEventListener("input", () => this.onChange());
//         this.input.addEventListener("change", () => this.onChange());
//     }
//
//     async onChange() {
//         const Form = new FormData(this.form);
//         const Params = new URLSearchParams();
//         Form.forEach((value, key) => {
//             Params.append(key, value);
//         });
//
//         const Url = new URL(window.location.href);
//
//         try {
//             const fetchUrl = this.buildFetchUrl(Url.pathname, Params);
//             const response = await fetch(fetchUrl, {
//                 headers: {
//                     "X-Requested-With": "XMLHttpRequest"
//                 }
//             });
//             const data = await response.json();
//             const content = document.querySelector("#content");
//             content.innerHTML = data.content;
//             history.pushState({}, null, fetchUrl);
//         } catch (e) {
//             alert(e);
//         }
//     }
//
//     buildFetchUrl(pathname, params) {
//         return `${pathname}?${params.toString()}&ajax=1`;
//     }
// }

// const formHandler = new FormHandler("#filters", "#mots");

// export class FiltersForm {
//     constructor(formId) {
//         this.formElement = document.querySelector(`#${formId}`);
//         this.inputElements = document.querySelectorAll(`#${formId} input`);
//
//         this.inputElements.forEach(input => {
//             input.addEventListener("change", () => this.onChange());
//         });
//
//         document.getElementById("mots").addEventListener("input", () => this.onChange());
//         window.addEventListener("beforeunload", () => this.resetForm());
//     }
//
//     async onChange() {
//         const Form = new FormData(this.formElement);
//         const Params = new URLSearchParams();
//         Form.forEach((value, key) => {
//             Params.append(key, value);
//         });
//
//         const Url = new URL(window.location.href);
//
//         try {
//             const fetchUrl = this.buildFetchUrl(Url.pathname, Params);
//             const response = await fetch(fetchUrl, {
//                 headers: {
//                     "X-Requested-With": "XMLHttpRequest"
//                 }
//             });
//             const data = await response.json();
//             const content = document.querySelector("#content");
//             content.innerHTML = data.content;
//             history.pushState({}, null, fetchUrl);
//         } catch (e) {
//             alert(e);
//         }
//     }
//     buildFetchUrl(pathname, params) {
//         return `${pathname}?${params.toString()}&ajax=1`;
//     }
// }




