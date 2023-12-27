class UsersFilter
{
    constructor({parent})
    {
        this.parent = parent;
        this.initialized = false;
        this.loaded = false;

        this.filters = {
            users: [],
            excludeMyItems: null,
        }

        this.options = [];

        this.clearFiltersButton = document.querySelector('[name="filter-users-clear"]');
        this.input = document.querySelector("#filter-users-input");
        this.datalist = document.querySelector("#filter-users-datalist");
        this.selected = document.querySelector("#filter-users-selected");
        this.excludeMyItems = document.querySelector("#filter-users-excludeMyItems");
        this.addAllFriends = document.querySelector("#filter-users-addAllFriends");

        this.#events();
    }

    #events()
    {
        this.input.addEventListener('input', () => this.#addFilter());
        this.excludeMyItems.addEventListener('change', () => this.#toggleMyItems());
        this.addAllFriends.addEventListener('click', () => this.#addAllFriends());
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

        if (this.filters.users.includes(inputValue)) {
            return;
        }

        this.filters.users.push(inputValue);
        const filterIndex = this.filters.users.indexOf(inputValue);
        this.#addFilterToFrontend(inputValue, filterIndex);
        this.input.value = '';

        this.#registerFiltersChange();
    }

    #addAllFriends()
    {
        this.#loadData();

        if(this.options.length === 0) {
            return;
        }

        this.options
            .filter((value) => !this.filters.users.includes(value))
            .forEach(function(value, index) {
                this.filters.users.push(value);
                this.#addFilterToFrontend(value, index);
            }, this);
        this.#registerFiltersChange();
    }

    #removeFilter(e)
    {
        const a = e.target;
        const span = e.target.parentElement;
        a.remove();

        const filterValue = span.innerText;
        span.remove();

        const filterIndex = this.filters.users.indexOf(filterValue);
        this.filters.users.splice(filterIndex, 1);
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

        if (filters.users.length === 0) {
            delete filters.users;
            filters.excludeMyItems = false;
        } else {
            filters.users = filters.users.map((element) => encodeURIComponent(element)).join(',');
        }

        if (!filters.excludeMyItems) {
            delete filters.excludeMyItems;
        }

        return filters;
    }

    initialize()
    {
        if (this.initialized) {
            return;
        }
        window.ajaxPopulateGenericDatalist('filter-users-datalist', 'username', '/ajax/friends');
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
        const currentUsersValue = this.parent.getCurrentQueryParam('users');
        if (currentUsersValue !== null) {
            this.filters['users'] = currentUsersValue.split(',').map((element) => decodeURIComponent(element));
        }

        this.filters.excludeMyItems = this.parent.getCurrentQueryParam('excludeMyItems') === 'true';

        this.#updateFrontendForCurrentValues();
    }

    #clearFilters()
    {
        document.querySelectorAll('[id^="filter-users-a-"]').forEach(function(element) {
            element.remove();
        });

        document.querySelectorAll('[id^="filter-users-span-"]').forEach(function(element) {
            element.remove();
        });

        this.filters.users = [];

        this.filters.excludeMyItems = null;
        this.excludeMyItems.checked = false;

        this.#registerFiltersChange();
    }

    #updateFrontendForCurrentValues()
    {
        this.filters.users.forEach(function(value, index) {
            this.#addFilterToFrontend(value, index);
        }, this);

        this.excludeMyItems.checked = this.filters.excludeMyItems === true;

        this.#setClearFiltersButtonStatus();
    }

    #addFilterToFrontend(filterValue, filterIndex)
    {
        const span = document.createElement("span");
        span.setAttribute("id", "filter-users-span-" + filterIndex);
        span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(filterValue));

        const a = document.createElement("a");
        a.setAttribute("id", "filter-users-a-" + filterIndex);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.appendChild(document.createTextNode("\u2715"));

        span.appendChild(a);
        this.selected.appendChild(span);

        a.addEventListener('click', (e) => this.#removeFilter(e));
    }

    #toggleMyItems()
    {
        this.filters.excludeMyItems = this.excludeMyItems.checked;
        this.#registerFiltersChange();
    }
}

export default UsersFilter;
