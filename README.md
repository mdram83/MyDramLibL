MyDramLibL is remake of MyDramLibrary that is now based on Laravel.
As it is much easier and help me in learning the framework will continue project with Laravel.
Though there is a debt (in learning and SOLID) using Laravel, e.g. helper functions and eloquent with magic methods.

What next?
- Then functionalities (groups/friends, dashboard, more itemable types, filtering, buying recommendations etc.)
- Nicer confirm window for Delete (not raw browser "confirm")
- Consider more attributes for Music Album (Supporting Bands, Supporting Artists)
- Consider Form Request instance for itemable (with Book, Music Album child classes)
- Check sth like require_once on blade side to add artists and guilds datalist only once - @pushOnce
- Considering adding movies, games and boardgames and music scores (for family)
- Consider adding podcasts or other digital materials not really owned by user (but as a kind of favorite resources)


Some Tech improvements required
- Consider config() values in Navigator class
- Use Thumbnail navigator also in other views than Dashboard (for consistency)
- Create Repositories to easier read/write itemables and items info and use in different controller (incl. ajax calls)
- All views menu could read from Navigator instead of hard coded
- Unit tests in Laravel...
- Missing Interfaces
- Played_on should be stored on item not itemable so there is standard way to access it (or itemable interface...)
- Played_on could also use kind of class/configuration to store different methods with e.g. icon link and labels
