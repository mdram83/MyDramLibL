window.getArtistFromInputs = function(firstnameId, lastnameId) {
    const firstname = document.getElementById(firstnameId).value.trim();
    const lastname = document.getElementById(lastnameId).value.trim();

    if (!lastname) {
        alert('Lastname is required');
        document.getElementById(lastnameId).focus();
        return;
    }

    return lastname + (firstname ? ", " + firstname : "");
}

window.useSelectedArtist = function(input, firstnameInputId, lastnameInputId) {

    const selectedArtist = input.value;
    const options = document.getElementById(input.list.id).childNodes;

    for (let i = 0; i < options.length; i++) {
        if((selectedArtist === options[i].value) && (options[i].value !== options[i].label)) {
            for (let j = 0; j < window.allArtists.length; j++) {
                if (selectedArtist === window.allArtists[j]['name']) {
                    document.getElementById(firstnameInputId).value = window.allArtists[j]['firstname'];
                    document.getElementById(lastnameInputId).value = window.allArtists[j]['lastname'];
                    return;
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

document.getElementById("artistFirstname").addEventListener("input", (e) => {
    if (artistKeypress === false) {
        useSelectedArtist(
            document.getElementById("artistFirstname"),
            "artistFirstname",
            "artistLastname"
        );
    }
    artistKeypress = false;
});

document.getElementById("artistLastname").addEventListener("keydown", (e) => {
    if(e.key) {
        artistKeypress = true;
    }
});

document.getElementById("artistLastname").addEventListener("input", (e) => {
    if (artistKeypress === false) {
        useSelectedArtist(
            document.getElementById("artistLastname"),
            "artistFirstname",
            "artistLastname"
        );
    }
    artistKeypress = false;
});
