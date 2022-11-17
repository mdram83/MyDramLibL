window.ajaxGetDetailsWithISBN = function() {

    const isbn = document.getElementById('isbn').value;
    if (isbn !== '') {

        // changeIsbnButtonStyle('loading');
        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                const details = JSON.parse(this.responseText);

                [
                    'title',
                    'isbn',
                    'publisher',
                    'series',
                    'volume',
                    'pages'
                ].forEach(function (item) {
                    document.getElementById(item).value = details[item] ?? document.getElementById(item).value;
                });

                details['tags'].forEach(function (tag) {
                    window.addTagToSelection(tag);
                });

                document.getElementById('isbn-button').focus();

                // changeIsbnButtonStyle('success');
                return;
            }

            if (this.readyState === 4 && (this.status === 404 || this.status === 500)) {
                // changeIsbnButtonStyle('failed');
            }
        };

        xhttp.open("GET", "/ajax/isbn/" + encodeURIComponent(isbn), true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send();

    }
}
