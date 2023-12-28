import axios from "axios";

class ArtistsFilter
{
    constructor({parent, filterName})
    {
        this.parent = parent;
        this.filterName = filterName;
        this.initialized = false;
        this.loaded = false;

        this.filters = {
            artists: [],
        }

        this.options = [];

        this.clearFiltersButton = document.querySelector('[name="filter-' + this.filterName + '-clear"]');
        this.input = document.querySelector("#filter-" + this.filterName + "-input");
        this.datalist = document.querySelector("#filter-" + this.filterName + "-datalist");
        this.selected = document.querySelector("#filter-" + this.filterName + "-selected");

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

        if (this.filters.artists.includes(inputValue)) {
            return;
        }

        this.filters.artists.push(inputValue);
        const filterIndex = this.filters.artists.indexOf(inputValue);
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

        const filterIndex = this.filters.artists.indexOf(filterValue);
        this.filters.artists.splice(filterIndex, 1);
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
                if (key === 'artists') {
                    if (value.length !== 0) {
                        filters[this.filterName] = value.map((element) => encodeURIComponent(element)).join(',');
                    }
                } else {
                    filters[key] = value;
                }
            }
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

                Object.values(response.data.artists)
                    .sort((a, b) => a.name > b.name ? 1 : -1)
                    .forEach(function(element) {
                        this.datalist.append(new Option(element.name));
                        this.options.push(element.name);
                    }, this);

                this.loaded = true;
            })
            .catch(error => {
                console.log('Sorry');
            });
    }

    #setFilterValuesFromUrl()
    {
        for (const [key, value] of Object.entries(this.filters)) {
            const currentValue = this.parent.getCurrentQueryParam(key === 'artists' ? this.filterName : key);
            if (currentValue !== null) {
                this.filters[key] = currentValue.split(',').map((element) => decodeURIComponent(element));
            }
        }
        this.#updateFrontendForCurrentValues();
    }

    #clearFilters()
    {
        document.querySelectorAll('[id^="filter-' + this.filterName + '-a-"]').forEach(function(element) {
            element.remove();
        });

        document.querySelectorAll('[id^="filter-' + this.filterName + '-span-"]').forEach(function(element) {
            element.remove();
        });

        this.filters.artists = [];
        this.#registerFiltersChange();
    }

    #updateFrontendForCurrentValues()
    {
        this.filters.artists.forEach(function(value, index) {
            this.#addFilterToFrontend(value, index);
        }, this);

        this.#setClearFiltersButtonStatus();
    }

    #addFilterToFrontend(filterValue, filterIndex)
    {
        const span = document.createElement("span");
        span.setAttribute("id", "filter-" + this.filterName + "-span-" + filterIndex);
        span.setAttribute("class", "mb-2 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(filterValue));

        const a = document.createElement("a");
        a.setAttribute("id", "filter-" + this.filterName + "-a-" + filterIndex);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.appendChild(document.createTextNode("\u2715"));

        span.appendChild(a);
        this.selected.appendChild(span);

        a.addEventListener('click', (e) => this.#removeFilter(e));
    }
}

export default ArtistsFilter;
