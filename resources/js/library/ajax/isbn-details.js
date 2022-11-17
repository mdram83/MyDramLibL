window.ajaxGetDetailsWithISBN = function() {

    const isbn = document.getElementById('isbn').value;
    if (isbn !== '') {

        window.changeIsbnButtonStyle('loading');
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                const details = JSON.parse(this.responseText);

                [
                    'title',
                    'isbn',
                    'publisher',
                    'published_at',
                    'series',
                    'volume',
                    'pages'
                ].forEach(function (item) {
                    document.getElementById(item).value = details[item] ?? document.getElementById(item).value;
                });

                details['tags'].forEach(function (tag) {
                    window.addTagToSelection(tag);
                });

                document.getElementById('comment').focus();
                window.changeIsbnButtonStyle('success');
                return;
            }

            if (this.readyState === 4 && this.status !== 200) {
                window.changeIsbnButtonStyle('failed');
            }
        };

        xhttp.open("GET", "/ajax/isbn/" + encodeURIComponent(isbn), true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send();

    }
}

window.changeIsbnButtonStyle = function(state) {
    const button = document.getElementById('isbn-button');
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
