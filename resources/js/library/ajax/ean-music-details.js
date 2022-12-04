window.ajaxGetDetailsWithEAN = function(formId) {

    const ean = document.getElementById('ean').value;
    if (ean !== '') {

        window.changeEanButtonStyle('loading');
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                const details = JSON.parse(this.responseText);

                [
                    'title',
                    'ean',
                    'thumbnail',
                    'publisher',
                    'published_at',
                    'duration',
                    'volumes',
                ].forEach(function (item) {
                    document.getElementById(item).value = details[item] ?? document.getElementById(item).value;
                });

                details['tags'].forEach(function (tag) {
                    window.addToSelection(
                        tag,
                        'tag',
                        'selectedTags',
                        formId,
                        'tags[]',
                        'tag',
                        []
                    );
                });

                details['mainArtists'].forEach(function (mainArtist) {
                    window.addToSelection(
                        mainArtist,
                        'mainArtist',
                        'selectedArtists',
                        formId,
                        'mainArtists[]',
                        'artistFirstname',
                        []
                    );
                });

                details['mainBands'].forEach(function (mainArtist) {
                    window.addToSelection(
                        mainArtist,
                        'mainBand',
                        'selectedGuilds',
                        formId,
                        'mainBands[]',
                        'guild',
                        []
                    );
                });

                document.getElementById('ean').focus();
                window.changeEanButtonStyle('success');
                return;
            }

            if (this.readyState === 4 && this.status !== 200) {
                window.changeEanButtonStyle('failed');
            }
        };

        xhttp.open("GET", "/ajax/ean/" + encodeURIComponent(ean), true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send();

    }
}

window.changeEanButtonStyle = function(state) {
    const button = document.getElementById('ean-button');
    switch (state) {
        case 'loading':
            button.disabled = true;
            button.textContent = "Loading...";
            button.style.opacity = 0.5;
            button.style.cursor = "progress";
            break;
        case 'success':
            button.disabled = true;
            button.textContent = "Loaded";
            button.style.opacity = 0.8;
            button.style.cursor = "default";
            break;
        case 'failed':
            button.disabled = true;
            button.textContent = "Not found";
            button.style.opacity = 0.8;
            button.style.cursor = "default";
            break;
        case 'enabled':
            button.disabled = false;
            button.textContent = "Get details";
            button.style.opacity = 1.0;
            button.style.cursor = "pointer";
            break;
    }
}
