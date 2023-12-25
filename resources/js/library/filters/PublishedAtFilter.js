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
            publishedAtEmpty: null,
        }

        this.range = document.querySelector(".filter-publishedAt-range-selected");
        this.rangeInput = document.querySelectorAll(".filter-publishedAt-range-input input");
        this.rangeValue = document.querySelectorAll(".filter-publishedAt-range-value p");
        this.includeEmptyCheckbox = document.querySelector("#filter-publishedAt-empty");

        this.#events();
    }

    #registerFiltersChange()
    {
        this.parent.registerFiltersChange();
    }

    getFilters()
    {
        const filters = {};

        for (const [key, value] of Object.entries(this.filters)) {
            if (value !== null) {
                filters[key] = value;
            }
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

        this.includeEmptyCheckbox.addEventListener('change', () => this.#toggleEmpty());
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

    #updateFrontendForCurrentValues()
    {
        this.includeEmptyCheckbox.checked = this.filters.publishedAtEmpty === 'true';

        if (this.filters.publishedAtMin !== null) {
            this.rangeInput[0].value = this.filters.publishedAtMin;
            this.rangeValue[0].innerHTML = this.filters.publishedAtMin.toString();
        }

        if (this.filters.publishedAtMax !== null) {
            this.rangeInput[1].value = this.filters.publishedAtMax;
            this.rangeValue[1].innerHTML = this.filters.publishedAtMax.toString();
        }

        this.#adjustSlider();
    }


    #toggleEmpty()
    {
        this.filters.publishedAtEmpty = this.includeEmptyCheckbox.checked;
        this.#registerFiltersChange();
    }
}

export default PublishedAtFilter;
