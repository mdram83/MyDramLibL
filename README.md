MyDramLibL is remake of MyDramLibrary that is now based on Laravel.
As it is much easier and help me in learning the framework will continue project with Laravel.

TODO:
+ Consolidate Music Album and Book Create and Edit forms common elements to blade components (e.g. do I need separate create and edit form ids)
* HOW TO HANDLE PROVIDE HIDDEN ELEMENTS FOR EXISTING ITEMABLES IN EDIT VS CREATE WITHOUT THEM?
* keep divs and only consolidate elements inside divs (otherwise for divs inside specific sections, they should go to components)
* form id = itemable?
* pass existing value as blade variable so it can be used in edit form (if exists) next to old()
* consolidate Thumbnail input (hidden, not url in case APIs return wrong value)
- EAN details for Music Albums through some API
- All saves - camel case user inputs (Guilds, Tags, Artist, Publishers)

- Move models (Books, Artists, etc.) to dedicated namespaces
- Cleanup view templates and components (incl. directory structure and js. files)
- Nicer confirm window for Delete (not raw browser "confirm")
- Home screens for guest and auth (and MVP is ready to deploy...)
- Then functionalities (groups/friends, more itemable types filtering, buying recommendations etc.)
