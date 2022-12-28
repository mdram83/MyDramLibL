MyDramLibL is remake of MyDramLibrary that is now based on Laravel.
As it is much easier and help me in learning the framework will continue project with Laravel.
Though there is a debt (in learning and SOLID) using Laravel, e.g. helper functions and eloquent with magic methods.

MVP
- Turn on https
- Change (after https is defined) emails with Gmail smtp (do I really need/want this?)
- Set APP_DEBUG to false (ENV in prod, do it after last checks)

Bugs:

Later:
- Dashboard page for logged user
- Then functionalities (groups/friends, more itemable types, filtering, buying recommendations etc.)
- Nicer confirm window for Delete (not raw browser "confirm")
- Consider more attributes for Music Album (Supporting Bands, Supporting Artists)
- Consider Form Request instance for itemable (with Book, Music Album child classes)
- Check sth like require_once on blade side to add artists and guilds datalist only once - @pushOnce
- Considering adding movies, games and boardgames and music scores (for family)
