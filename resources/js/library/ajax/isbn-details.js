window.ajaxGetDetailsWithISBN = function() {

    let isbn = document.getElementById('isbn').value;
    if (isbn !== '') {

        // changeIsbnButtonStyle('loading');
        let xhttp = new XMLHttpRequest();

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

                // var categories = details['category'] ?? null;
                // if (categories !== null) {
                //     for (i = 0; i < categories.length; i++) {
                //         var element = document.getElementById('category0' + i);
                //         if (element.style.display == 'none') addCategoryField();
                //         element.value = details['category'][i];
                //         if (i == 9) break;
                //     }
                // }

                // changeIsbnButtonStyle('success');
                return;
            }

            if (this.readyState === 4 && (this.status === 404 || this.status === 500)) {
                // changeIsbnButtonStyle('failed');
            }

            console.log(this.responseText);

        };

        xhttp.open("GET", "/ajax/isbn/" + encodeURIComponent(isbn), true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send(/*params*/);

    }
}
