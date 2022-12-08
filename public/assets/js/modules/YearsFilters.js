export class YearsFilters {
    constructor(formId) {
        this.formElement = document.querySelector(`#${formId}`);
        this.inputElements = document.querySelectorAll(`#${formId} input`);

        this.defaultValues = {};

        this.inputElements.forEach(input => {
            this.defaultValues[input.name] = input.value;
            input.addEventListener("change", () => this.onChange());
        });

        window.addEventListener("beforeunload", () => this.resetValues());
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
