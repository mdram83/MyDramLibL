window.allArtists = [];

window.ajaxPopulateArtistsDatalist = function() {

    const firstnameDatalist = document.getElementById('artistFirstnames');
    const lastnameDatalist = document.getElementById('artistLastnames');

    if (firstnameDatalist.options.length === 0 && lastnameDatalist.options.length === 0) {

        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                const data = JSON.parse(this.responseText);

                Object.values(data['firstnames']).forEach(function(item) {
                    firstnameDatalist.append(new Option(item, item));
                });

                Object.values(data['lastnames']).forEach(function(item) {
                    lastnameDatalist.append(new Option(item, item));
                });

                const artists = window.allArtists = Object.values(data['artists']);
                // TODO check if required (in function assigning right first/last name based on selection)

                artists.map(item => Object.values(item)).sort().forEach(function(item) {
                    firstnameDatalist.append(new Option(item[1], item[0]));
                    lastnameDatalist.append(new Option(item[2], item[0]));
                });

            }
        };

        xhttp.open("GET", "/ajax/artists", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send();
    }
}
