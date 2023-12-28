import axios from "axios";

class AuthorsFilter
{
    constructor({parent})
    {
        this.parent = parent;
        this.initialized = false;
        this.loaded = false;

        this.filters = {
            authors: [],
        }

        this.options = [];

        this.clearFiltersButton = document.querySelector('[name="filter-authors-clear"]');
        this.input = document.querySelector("#filter-authors-input");
        this.datalist = document.querySelector("#filter-authors-datalist");
        this.selected = document.querySelector("#filter-authors-selected");

        this.#events();
    }

    #events()
    {
        this.input.addEventListener('focus', () => this.#loadData());
        this.input.addEventListener('input', () => this.#addFilter());
        this.clearFiltersButton.addEventListener('click', () => this.#clearFilters());
    }

    #addFilter()
    {
        this.#loadData();

        const inputValue = this.input.value;
        if (inputValue === '') {
            return;
        }

        const optionIndex = this.options.indexOf(inputValue);
        if (optionIndex < 0) {
            return;
        }

        if (this.filters.authors.includes(inputValue)) {
            return;
        }

        this.filters.authors.push(inputValue);
        const filterIndex = this.filters.authors.indexOf(inputValue);
        this.#addFilterToFrontend(inputValue, filterIndex);
        this.input.value = '';

        this.#registerFiltersChange();
    }

    #removeFilter(e)
    {
        const a = e.target;
        const span = e.target.parentElement;
        a.remove();

        const filterValue = span.innerText;
        span.remove();

        const filterIndex = this.filters.authors.indexOf(filterValue);
        this.filters.authors.splice(filterIndex, 1);
        this.#registerFiltersChange();
    }

    #registerFiltersChange()
    {
        this.parent.registerFiltersChange();
        this.#setClearFiltersButtonStatus();
    }

    #setClearFiltersButtonStatus()
    {
        this.clearFiltersButton.disabled = Object.keys(this.getFilters()).length === 0;
    }

    getFilters()
    {
        const filters = [];

        for (const [key, value] of Object.entries(this.filters)) {
            if (value !== null) {
                filters[key] = value;
            }
        }

        if (filters.authors.length === 0) {
            delete filters.authors;
        } else {
            filters.authors = filters.authors.map((element) => encodeURIComponent(element)).join(',');
        }

        return filters;
    }

    initialize()
    {
        if (this.initialized) {
            return;
        }
        this.#setFilterValuesFromUrl();
        this.initialized = true;
    }

    #loadData()
    {
        if (this.loaded) {
            return;
        }

        axios.get(window.location.origin + '/ajax/artists')
            .then(response => {
                for (const [key, value] of Object.entries(response.data.artists)) {
                    this.datalist.append(new Option(value.name));
                    this.options.push(value.name);
                }
                this.loaded = true;
            })
            .catch(error => {
                console.log('Sorry');
            });
    }

    #setFilterValuesFromUrl()
    {
        for (const [key, value] of Object.entries(this.filters)) {
            const currentValue = this.parent.getCurrentQueryParam(key);
            if (currentValue !== null) {
                this.filters[key] = currentValue.split(',').map((element) => decodeURIComponent(element));
            }
        }
        this.#updateFrontendForCurrentValues();
    }

    #clearFilters()
    {
        document.querySelectorAll('[id^="filter-authors-a-"]').forEach(function(element) {
            element.remove();
        });

        document.querySelectorAll('[id^="filter-authors-span-"]').forEach(function(element) {
            element.remove();
        });

        this.filters.authors = [];
        this.#registerFiltersChange();
    }

    #updateFrontendForCurrentValues()
    {
        this.filters.authors.forEach(function(value, index) {
            this.#addFilterToFrontend(value, index);
        }, this);

        this.#setClearFiltersButtonStatus();
    }

    #addFilterToFrontend(filterValue, filterIndex)
    {
        const span = document.createElement("span");
        span.setAttribute("id", "filter-authors-span-" + filterIndex);
        span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(filterValue));

        const a = document.createElement("a");
        a.setAttribute("id", "filter-authors-a-" + filterIndex);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.appendChild(document.createTextNode("\u2715"));

        span.appendChild(a);
        this.selected.appendChild(span);

        a.addEventListener('click', (e) => this.#removeFilter(e));
    }
}

export default AuthorsFilter;
