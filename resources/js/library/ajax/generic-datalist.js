window.ajaxPopulateGenericDatalist = function(datalistId, attributeName, url) {

    const datalist = document.getElementById(datalistId);

    if (datalist.options.length === 0) {

        const xhttp = new XMLHttpRequest();

        xhttp.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {

                JSON.parse(this.responseText).forEach(function (item) {
                    datalist.append(new Option(item[attributeName]));
                });
            }
        };

        xhttp.open("GET", url, true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
        xhttp.send();
    }
}
