window.ajaxGetPlayMusicLinks = function(musicAlbumId, triggerElement) {

    setTriggerElementToLoading(triggerElement);

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {

        if (this.readyState === 4 && this.status === 200) {

            const links = JSON.parse(this.responseText);

            window.openSpotifyWebLink = function() {
                window.open(links['spotify_web_link'], '_blank');
            }

            setTriggerElementToLoaded(triggerElement);
            setLinkElementToLoaded(document.getElementById('spotify_link'));

            return;
        }

        if (this.readyState === 4 && this.status !== 200) {
            setTriggerElementToFailed(triggerElement)
            alert('Can not find any link to play this music album');
        }
    };

    xhttp.open("GET", "/ajax/play-music-links/" + musicAlbumId, true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send();



    function setTriggerElementToLoading(triggerElement)
    {
        triggerElement.removeAttribute('onclick');
        triggerElement.classList.remove('hover:cursor-pointer');
        triggerElement.classList.add('animate-pulse');
    }

    function setTriggerElementToLoaded(triggerElement)
    {
        triggerElement.classList.remove('animate-pulse');
        triggerElement.classList.add('hidden');
    }

    function setTriggerElementToFailed(triggerElement)
    {
        triggerElement.classList.remove('animate-pulse');
        triggerElement.setAttribute('stroke', '#9ca3af');
    }

    function setLinkElementToLoaded(linkElement)
    {
        linkElement.classList.remove('hidden');
        linkElement.setAttribute('onclick','window.openSpotifyWebLink();');
    }
}
