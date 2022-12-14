import {FiltersForm} from "./FiltersForm.js";
export class FiltersFormWithPagination extends FiltersForm {
    constructor(formId) {
        super(formId);

        // Get the pagination links
        const paginationLinks = document.querySelectorAll('.pagination a');

        // Add a click event listener to each pagination link
        paginationLinks.forEach(link => {
            link.addEventListener('click', async event => {
                // Prevent the default link behavior
                event.preventDefault();

                // Get the URL of the pagination link
                const url = new URL(event.target.href);

                // Use the URL to get the next or previous page of media items
                const response = await fetch(url.pathname, {
                    headers: {
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });
                const data = await response.json();

                // Update the page with the new media items
                const content = document.querySelector("#content");
                content.innerHTML = data.content;
            });
        });
    }
    
}
