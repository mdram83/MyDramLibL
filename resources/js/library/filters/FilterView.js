class FilterView
{
    constructor()
    {
        this.filtersContainer = document.querySelector("#filters-container");
        this.toggleFiltersElement = document.querySelector("#toggle-filters");

        this.filtersContainerVisible = false;

        this.events();
    }

    events()
    {
        this.toggleFiltersElement.addEventListener("click", () => this.toggleFilters());
    }

    toggleFilters()
    {
        if (this.filtersContainerVisible) {
            this.filtersContainer.classList.add('hidden');
        } else {
            this.filtersContainer.classList.remove('hidden');
        }

        this.filtersContainerVisible = !this.filtersContainerVisible;
    }
}

const filterView = new FilterView();
