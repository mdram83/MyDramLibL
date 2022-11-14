window.ajaxPopulatePublishersDatalist = function() {

    const datalist = document.getElementById('publishers');

    if (datalist.options.length === 0) {

        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                JSON.parse(this.responseText).forEach(function (item) {
                    const option = document.createElement('option');
                    option.value = item['name'];
                    datalist.appendChild(option);
                });
            }
        };

        xhttp.open("GET", "/ajax/publishers", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send();
    }
}
