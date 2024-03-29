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

        const filterIndex = this.filters.tags.indexOf(filterValue);
        this.filters.tags.splice(filterIndex, 1);
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

        if (filters.tags.length === 0) {
            delete filters.tags;
        } else {
            filters.tags = filters.tags.map((element) => encodeURIComponent(element)).join(',');
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
        document.querySelectorAll('[id^="filter-tags-a-"]').forEach(function(element) {
            element.remove();
        });

        document.querySelectorAll('[id^="filter-tags-span-"]').forEach(function(element) {
            element.remove();
        });

        this.filters.tags = [];
        this.#registerFiltersChange();
    }

    #updateFrontendForCurrentValues()
    {
        this.filters.tags.forEach(function(value, index) {
            this.#addFilterToFrontend(value, index);
        }, this);

        this.#setClearFiltersButtonStatus();
    }

    #addFilterToFrontend(filterValue, filterIndex)
    {
        const span = document.createElement("span");
        span.setAttribute("id", "filter-tags-span-" + filterIndex);
        span.setAttribute("class", "mb-2 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(filterValue));

        const a = document.createElement("a");
        a.setAttribute("id", "filter-tags-a-" + filterIndex);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.appendChild(document.createTextNode("\u2715"));

        span.appendChild(a);
        this.selected.appendChild(span);

        a.addEventListener('click', (e) => this.#removeFilter(e));
    }
}

export default TagsFilter;
