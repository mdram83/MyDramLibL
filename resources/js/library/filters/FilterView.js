import PublishedAtFilter from "@/library/filters/PublishedAtFilter";

class FilterView
{
    constructor()
    {
        this.filtersContainer = document.querySelector('#filters-container');
        this.toggleFiltersElement = document.querySelector('#toggle-filters');
        this.applyFiltersButtons = document.querySelectorAll('[name="apply-filters"]');

        this.filtersContainerVisible = false;
        this.initialized = false;

        this.filters = [];
        this.filters.push(new PublishedAtFilter({parent: this}));

        this.#events();
    }

    #events()
    {
        this.toggleFiltersElement.addEventListener('click', () => this.#toggleFilters());
        this.applyFiltersButtons.forEach(el => {
            el.addEventListener('click', () => this.#applyFilters());
        });
    }

    #initialize()
    {
        if (this.initialized) {
            return;
        }

        this.filters.forEach(function(filter) {
            filter.initialize();
        });

        this.initialized = true;
    }

    #toggleFilters()
    {
        if (this.filtersContainerVisible) {
            this.filtersContainer.classList.add('hidden');
        } else {
            this.filtersContainer.classList.remove('hidden');
            this.#initialize();
        }
        this.filtersContainerVisible = !this.filtersContainerVisible;
    }

    #applyFilters() // TODO adjust function when applying updated filters
    {
        const queryParams = this.#getQueryParamsFromFilters(this.filters);
        const baseUrl = window.location.origin + window.location.pathname;

        if (Object.keys(queryParams).length === 0) {
            window.location.replace(baseUrl);
            return;
        }

        const targetUrl = this.#addQueryParamsToBaseUrl(baseUrl, queryParams);
        window.location.replace(targetUrl);
    }

    registerFiltersChange()
    {
        this.applyFiltersButtons.forEach(el => {
            el.disabled = false;
        });
    }

    #getQueryParamsFromFilters(filters)
    {
        const queryParams = {};
        filters.forEach(function(filter) {
            for (const [key, value] of Object.entries(filter.getFilters())) {
                queryParams[key] = value;
            }
        });
        return queryParams;
    }

    #addQueryParamsToBaseUrl(baseUrl, queryParams)
    {
        let targetUrl = baseUrl + '?';
        for (const [key, value] of Object.entries(queryParams)) {
            targetUrl += key + '=' + value + '&';
        }
        return targetUrl.slice(0, -1);
    }
}

const filterView = new FilterView();
