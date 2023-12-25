import axios from 'axios';

/*
This class explains with comments how to set up next specific filters and which methods are required
 */

class DefaultFilterInterface
{
    constructor({parent})
    {
        this.parent = parent;       // parent represents FilterView object that create instance of DefaultFilterInterface and holds it in its filters array
        this.loaded = false;        // set to true once external (ajax) data is loaded
        this.initialized = false;   // set to true after first appearance of filter (if required any initialization)

        // TO BE ADJUSTED; holds values that later may be adjusted before sending to parent and in URL (key names should be used directly)
        this.filters = {
            keyName1: null,
            keyName2: null,
        }

        // TO BE ADJUSTED; adjust to point out to this specific filter clear button
        this.clearFiltersButton = document.querySelector('[name="filter-filtername-clear"]');

        // TO BE ADJUSTED; add specific html elements that are used to set the filter values
        this.range = document.querySelector(".filter-filtername-specific-element");

        // fire up events (mainly adding EventListener to elements defined above)
        this.#events();
    }

    // TO BE ADJUSTED; here goes all necessary event listeners
    #events()
    {
        // add more here

        this.clearFiltersButton.addEventListener('click', () => this.#clearFilters());
    }

    // inform parent about filter change and adjust clear filters button state
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

        // adjustments goes here (e.g. check if filtered values isn't the same as default value without filter)

        return filters;
    }

    // TO BE ADJUSTED; initialization happens with first appearance of filter on screen; can be adjusted (e.g. #loadData() may go inside) if needed
    initialize()
    {
        if (this.initialized) {
            return;
        }

        // this.#loadData(); // use #loadData() here only if required with first appearance. Otherwise, deffer to first request for the data.

        this.initialized = true;
    }

    // TO BE ADJUTSTED; load all necessary data from ajax/external requests if required by specific instance of DefaultFilterInterface
    #loadData()
    {
        if (this.loaded) {
            return;
        }

        // TO BE ADJUSTED; provide specific path, request type etc.
        axios.get(window.location.origin + '/adjust-this-specific-path')
            .then(response => {

                /* here add your adjustments for
                 * filter specific values (e.g. min/max, lists content etc.)
                 */

                this.loaded = true;
                this.#setFilterValuesFromUrl();
            })
            .catch(error => {
                console.log('Sorry, could not provide min and max published dates from library');
                this.#setFilterValuesFromUrl();
            });

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

export default DefaultFilterInterface;
