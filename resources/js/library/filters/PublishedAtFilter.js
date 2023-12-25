import axios from 'axios';

class PublishedAtFilter
{
    constructor({parent})
    {
        this.parent = parent;
        this.loaded = false;
        this.initialized = false;

        this.rangeMin = 0;
        this.min = null;
        this.max = null;

        this.filters = {
            publishedAtMin: null,
            publishedAtMax: null,
            publishedAtRequired: null,
        }

        this.clearFiltersButton = document.querySelector('[name="filter-publishedAt-clear"]');
        this.range = document.querySelector(".filter-publishedAt-range-selected");
        this.rangeInput = document.querySelectorAll(".filter-publishedAt-range-input input");
        this.rangeValue = document.querySelectorAll(".filter-publishedAt-range-value p");
        this.requiredCheckbox = document.querySelector("#filter-publishedAt-required");

        this.#events();
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
        const filters = {};

        for (const [key, value] of Object.entries(this.filters)) {
            if (value !== null) {
                filters[key] = value;
            }
        }

        if (filters.publishedAtMin === this.min) {
            delete filters.publishedAtMin;
        }

        if (filters.publishedAtMax === this.max) {
            delete filters.publishedAtMax;
        }

        if (filters.publishedAtRequired !== true && filters.publishedAtRequired !== 'true') {
            delete filters.publishedAtRequired;
        }

        return filters;
    }

    #events()
    {
        this.rangeInput.forEach((input) => {
            input.addEventListener("input", (e) => {
                let minRange = parseInt(this.rangeInput[0].value);
                let maxRange = parseInt(this.rangeInput[1].value);

                if (maxRange - minRange < this.rangeMin) {

                    if (e.target.classList.contains('min')) {
                        this.rangeInput[0].value = maxRange - this.rangeMin;
                    }
                    else {
                        this.rangeInput[1].value = minRange + this.rangeMin;
                    }

                } else {
                    this.rangeValue[0].innerHTML = minRange.toString();
                    this.filters.publishedAtMin = minRange;

                    this.rangeValue[1].innerHTML = maxRange.toString();
                    this.filters.publishedAtMax = maxRange;

                    this.#adjustSlider();
                    this.#registerFiltersChange();
                }
            });
        });

        this.requiredCheckbox.addEventListener('change', () => this.#toggleRequired());
        this.clearFiltersButton.addEventListener('click', () => this.#clearFilters());
    }

    #adjustSlider()
    {
        this.range.style.left = (1 - ((this.rangeInput[0].max - parseInt(this.rangeInput[0].value)) / (this.rangeInput[0].max - this.rangeInput[0].min))) * 100 + "%";
        this.range.style.right = ((this.rangeInput[1].max - parseInt(this.rangeInput[1].value)) / (this.rangeInput[1].max - this.rangeInput[1].min)) * 100 + "%";
    }

    initialize()
    {
        if (this.initialized) {
            return;
        }
        this.#loadData();
        this.initialized = true;
    }

    #loadData()
    {
        if (this.loaded) {
            return;
        }

        axios.get(window.location.origin + '/ajax/item/published-at-min-max')
            .then(response => {

                this.min = response.data.publishedAtMin;
                this.max = response.data.publishedAtMax;

                this.rangeInput[0].min = this.min;
                this.rangeInput[0].max = this.max;
                this.rangeInput[0].value = this.min;

                this.rangeInput[1].min = this.min;
                this.rangeInput[1].max = this.max;
                this.rangeInput[1].value = this.max;

                this.rangeValue[0].innerHTML = this.min.toString();
                this.rangeValue[1].innerHTML = this.max.toString();

                this.loaded = true;
                this.#setFilterValuesFromUrl();
            })
            .catch(error => {
                console.log('Sorry, could not provide min and max published dates from library');
                this.#setFilterValuesFromUrl();
            });

    }

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

    #clearFilters()
    {
        this.rangeInput[0].value = this.min;
        this.rangeValue[0].innerHTML = this.min;
        this.filters.publishedAtMin = null;

        this.rangeInput[1].value = this.max;
        this.rangeValue[1].innerHTML = this.max;
        this.filters.publishedAtMax = null;

        this.requiredCheckbox.checked = false;
        this.filters.publishedAtRequired = null;

        this.#adjustSlider();
        this.#registerFiltersChange();
    }

    #updateFrontendForCurrentValues()
    {
        this.requiredCheckbox.checked = this.filters.publishedAtRequired === 'true';

        if (this.filters.publishedAtMin !== null) {
            this.rangeInput[0].value = this.filters.publishedAtMin;
            this.rangeValue[0].innerHTML = this.filters.publishedAtMin.toString();
        }

        if (this.filters.publishedAtMax !== null) {
            this.rangeInput[1].value = this.filters.publishedAtMax;
            this.rangeValue[1].innerHTML = this.filters.publishedAtMax.toString();
        }

        this.#setClearFiltersButtonStatus();
        this.#adjustSlider();
    }

    #toggleRequired()
    {
        this.filters.publishedAtRequired = this.requiredCheckbox.checked;
        this.#registerFiltersChange();
    }
}

export default PublishedAtFilter;
