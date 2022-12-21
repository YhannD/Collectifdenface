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

        // window.addEventListener("beforeunload", () => this.resetValues());

        // Get a reference to the "clear" button and add an event listener
        const clearButton = document.getElementById("clearText");
        clearButton.addEventListener('click', () => this.clearInput('mots'));
        // Get a reference to the "reset" button and add an event listener
        const resetButton = document.getElementById("reset-filters");
        resetButton.addEventListener("click", async event => {
            // Prevent the default action (page reload)
            event.preventDefault();

            // Get the form element using the data-form-id attribute
            const formId = resetButton.dataset.formId;
            const formElement = document.getElementById(formId);

            // Get all checkbox inputs within the form element
            const checkboxes = formElement.querySelectorAll('input[type="checkbox"]');

            // Loop through the checkboxes and set their checked property to false
            checkboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            // Call the onChange method and await the result
            await this.onChange();
        });
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
        const form = new FormData(this.formElement);
        const params = new URLSearchParams();
        form.forEach((value, key) => {
            params.append(key, value);
        });
        params.delete('page')


        const Url = new URL(window.location.href);

        try {
            const fetchUrl = this.buildFetchUrl(Url.pathname, params, ["page"]);
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

    buildFetchUrl(pathname, params, paramsToRemove) {
        paramsToRemove.forEach((param) => {
            params.delete(param);
        });
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
