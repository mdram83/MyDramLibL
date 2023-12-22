class FilterView
{
    constructor()
    {
        this.filtersContainer = document.querySelector('#filters-container');
        this.toggleFiltersElement = document.querySelector('#toggle-filters');
        this.applyFiltersButtons = document.querySelectorAll('[name="apply-filters"]');
        this.filters = []; // TODO add FilterXXX object as an element of this array (pass link to THIS mother object in specific filter constructor so that it is called on updates)

        this.filtersContainerVisible = false;
        this.filtersUpdated = false;

        this.#events();
    }

    #events()
    {
        this.toggleFiltersElement.addEventListener('click', () => this.#toggleFilters());
        this.applyFiltersButtons.forEach(el => {
            el.addEventListener('click', () => this.#applyFilters());
        });
    }

    #toggleFilters()
    {
        if (this.filtersContainerVisible) {
            this.filtersContainer.classList.add('hidden');
        } else {
            this.filtersContainer.classList.remove('hidden');
        }

        this.filtersContainerVisible = !this.filtersContainerVisible;
    }

    #applyFilters()
    {
        const targetHref = window.location.href; // TODO adjust function when applying specific filters
        window.location.replace(targetHref);
    }

    // TODO call THIS mother object method from each single Filter object after it is updated
    registerFiltersChange()
    {
        this.filtersUpdated = true;
        this.applyFiltersButtons.forEach(el => {
            el.disabled = false;
        });

        // TODO consider if I want to update target URL with each single filter change, or at the end (and do I want to read all filter objects then or just updated ones)
        // TODO consider kind of Interface for each Filter object
    }
}

const filterView = new FilterView();
