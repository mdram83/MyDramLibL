window.getArtistFromInputs = function() {
    const firstname = document.getElementById('artistFirstname').value.trim();
    const lastname = document.getElementById('artistLastname').value.trim();

    if (!lastname) {
        alert('Lastname is required');
        document.getElementById("artistLastname").focus();
        return;
    }

    return lastname + (firstname ? ", " + firstname : "");
}

window.addArtistToSelection = function(artist) {

    if (!artist) {
        return;
    }

    if (document.getElementById("artist-span-" + artist)) {
        return;
    }

    const span = createSpan(artist);
    span.appendChild(createA(artist));
    document.getElementById("selectedArtists").appendChild(span);

    document.getElementById("create").appendChild(createHidden(artist));

    document.getElementById("artistFirstname").focus();
    document.getElementById("artistFirstname").value = "";
    document.getElementById("artistLastname").value = "";

    function createA(artist)
    {
        const a = document.createElement("a");
        a.setAttribute("id", "artist-a-" + artist);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.setAttribute("onclick", "removeArtistFromSelection(\"" + artist + "\");")
        a.appendChild(document.createTextNode("\u2715"));
        return a;
    }

    function createSpan(artist)
    {
        const span = document.createElement("span");
        span.setAttribute("id", "artist-span-" + artist);
        span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(artist));
        return span;
    }

    function createHidden(artist)
    {
        const hidden = document.createElement("input");
        hidden.setAttribute("id", "artist-hidden-" + artist);
        hidden.setAttribute("name", "authors[]");
        hidden.setAttribute("type", "hidden");
        hidden.value = artist;
        return hidden;
    }
}

window.removeArtistFromSelection = function(artist) {
    document.getElementById("artist-span-" + artist).remove();
    document.getElementById("artist-hidden-" + artist).remove();
}

window.useSelectedArtist = function(input) {

    const selectedArtist = input.value;
    const options = document.getElementById(input.list.id).childNodes;
    for (let i = 0; i < options.length; i++) {
        if(selectedArtist === options[i].value) {
            if (options[i].value !== options[i].label) {
                for (let j = 0; j < window.allArtists.length; j++) {
                    if (selectedArtist === window.allArtists[j]['name']) {
                        document.getElementById('artistFirstname').value = window.allArtists[j]['firstname'];
                        document.getElementById('artistLastname').value = window.allArtists[j]['lastname'];
                        return;
                    }
                }
            }
        }
    }

}


let artistKeypress = false;

document.getElementById("artistFirstname").addEventListener("keydown", (e) => {
    if(e.key) {
        artistKeypress = true;
    }
});

document.getElementById("artistFirstname").addEventListener('input', (e) => {
    if (artistKeypress === false) {
        useSelectedArtist(document.getElementById('artistFirstname'));
    }
    artistKeypress = false;
});

document.getElementById("artistLastname").addEventListener("keydown", (e) => {
    if(e.key) {
        artistKeypress = true;
    }
});

document.getElementById("artistLastname").addEventListener('input', (e) => {
    if (artistKeypress === false) {
        useSelectedArtist(document.getElementById('artistLastname'));
    }
    artistKeypress = false;
});
