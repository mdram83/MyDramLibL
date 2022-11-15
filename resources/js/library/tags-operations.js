window.addTagToSelection = function() {

    const input = document.getElementById("tag");
    const tag = input.value;

    if (!tag) {
        return;
    }

    if (document.getElementById("tag-" + tag)) {
        return;
    }

    const a = document.createElement("a");
    a.setAttribute("id", "tag-a-" + tag);
    a.setAttribute("class", "ml-2 font-bold cursor-pointer");
    a.setAttribute("onclick", "removeTagFromSelection(\"" + tag + "\");")
    a.appendChild(document.createTextNode("\u2715"));

    const span = document.createElement("span");
    span.setAttribute("id", "tag-" + tag);
    span.setAttribute("class", "my-1 mx-1 px-2 py-1 bg-gray-400 rounded-xl");
    span.appendChild(document.createTextNode(tag));
    span.appendChild(a);

    document.getElementById('selectedTags').appendChild(span);
    input.value = '';
    input.focus();
}

window.removeTagFromSelection = function(id) {
    document.getElementById("tag-" + id).remove();
}
