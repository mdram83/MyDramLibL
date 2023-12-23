class PublishedAtFilter
{
    constructor({parent})
    {
        this.parent = parent;

        this.filters = {
            publishedAtMin: 1900,
            publishedAtMax: 2024,
            publishedAtEmpty: true,
        }

        this.rangeMin = 0;

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
        return this.filters;
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

                    this.range.style.left = (1 - ((this.rangeInput[0].max - minRange) / (this.rangeInput[0].max - this.rangeInput[0].min))) * 100 + "%";
                    this.range.style.right = ((this.rangeInput[1].max - maxRange) / (this.rangeInput[1].max - this.rangeInput[1].min)) * 100 + "%";

                    this.#registerFiltersChange();
                }
            });
        });

        this.includeEmptyCheckbox.addEventListener('change', () => this.#toggleEmpty());
    }

    #toggleEmpty()
    {
        this.filters.publishedAtEmpty = !this.filters.publishedAtEmpty;
        this.#registerFiltersChange();
    }
}

export default PublishedAtFilter;
