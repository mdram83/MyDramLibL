window.ajaxGetPlayMusicLinks = function(musicAlbumId, triggerElement) {

    setTriggerElementToLoading(triggerElement);

    const xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {

        if (this.readyState === 4 && this.status === 200) {

            const links = JSON.parse(this.responseText);

            let linkSpotify = links['spotify_web_link'];
            let linkYoutube = links['youtube_link'];

            if (linkSpotify != null) {
                handleSpotifyLink(linkSpotify);
            }

            if (linkYoutube != null) {
                handleYoutubeLink(linkYoutube);
            }

            setTriggerElementToLoaded(triggerElement);
            return;
        }

        if (this.readyState === 4 && this.status !== 200) {
            setTriggerElementToFailed(triggerElement)
            alert('Can not find any links to play this music album');
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

    function setLinkElementToLoaded(linkElement, linkFunction)
    {
        linkElement.classList.remove('hidden');
        linkElement.setAttribute('onclick', linkFunction);
    }

    function handleSpotifyLink(link)
    {
        window.openSpotifyWebLink = function() {
            window.open(link, '_blank');
        }
        setLinkElementToLoaded(document.getElementById('spotify_link'), 'openSpotifyWebLink();');
    }

    function handleYoutubeLink(link)
    {
        window.openYouTubeLink = function() {
            window.open(link, '_blank');
        }
        setLinkElementToLoaded(document.getElementById('youtube_link'), 'openYouTubeLink();');
    }
}
