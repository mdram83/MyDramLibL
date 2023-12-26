class TagsFilter
{
    constructor({parent})
    {
        this.parent = parent;
        this.initialized = false;
        this.loaded = false;

        this.filters = {
            tags: [],
        }

        this.options = [];

        this.clearFiltersButton = document.querySelector('[name="filter-tags-clear"]');
        this.input = document.querySelector("#filter-tags-input");
        this.datalist = document.querySelector("#filter-tags-datalist");
        this.selected = document.querySelector("#filter-tags-selected");

        this.#events();
    }

    #events()
    {
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

        if (this.filters.tags.includes(inputValue)) {
            return;
        }

        this.filters.tags.push(inputValue);
        const filterIndex = this.filters.tags.indexOf(inputValue);

        const span = document.createElement("span");
        span.setAttribute("id", "filter-tags-span-" + filterIndex);
        span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(inputValue));

        const a = document.createElement("a");
        a.setAttribute("id", "filter-tags-a-" + filterIndex);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.appendChild(document.createTextNode("\u2715"));

        span.appendChild(a);
        this.selected.appendChild(span);

        a.addEventListener('click', (e) => this.#removeFilterByEvent(e));

        this.#registerFiltersChange();
    }

    #removeFilterByEvent(e)
    {
        const a = e.target;
        const span = e.target.parentElement;
        a.remove();

        const filterValue = span.innerText;
        const filterIndex = this.filters.tags.indexOf(filterValue);
        span.remove();

        this.filters.tags.splice(filterIndex, 1);
        this.#registerFiltersChange();
    }

    #registerFiltersChange()
    {
        this.parent.registerFiltersChange();
        this.#setClearFiltersButtonStatus();
    }

    // disable filters button if no specific filters are defined (nothing to clear)
    #setClearFiltersButtonStatus()
    {
        this.clearFiltersButton.disabled = Object.keys(this.getFilters()).length === 0;
    }

    // TO BE ADJUSTED; this function read and transform this.filters object params before passing to parent (and to URL in parent)
    getFilters()
    {
        const filters = {};

        for (const [key, value] of Object.entries(this.filters)) {
            if (value !== null) {
                filters[key] = value;
            }
        }

        if (filters.tags.length === 0) {
            delete filters.tags;
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

        const options = this.datalist.children;
        for (let i = 0; i < options.length; i++) {
            this.options.push(options[i].value);
        }

        this.loaded = true;
    }

    // read url from parent FilterView and update as necessary
    #setFilterValuesFromUrl()
    {
        for (const [key, value] of Object.entries(this.filters)) {
            const currentValue = this.parent.getCurrentQueryParam(key);
            if (currentValue !== null) {
                this.filters[key] = currentValue;
            }
        }
        this.#updateFrontendForCurrentValues();
    }

    // TO BE ADJUSTED; clear all filter values as set by user
    #clearFilters()
    {
        /* here add your adjustments for
         * this.filter elements
         * html elements
         */
        this.#registerFiltersChange();
    }

    // TO BE ADJUSTED; update frontend elements based on current (from URL) filter values
    #updateFrontendForCurrentValues()
    {
        /* here add your adjustments for
         * html elements
         */

        this.#setClearFiltersButtonStatus();
    }
}

export default TagsFilter;
