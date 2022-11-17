window.addTagToSelection = function(tag) {

    if (!tag) {
        return;
    }

    if (document.getElementById("tag-span-" + tag)) {
        return;
    }

    const a = document.createElement("a");
    a.setAttribute("id", "tag-a-" + tag);
    a.setAttribute("class", "ml-2 font-bold cursor-pointer");
    a.setAttribute("onclick", "removeTagFromSelection(\"" + tag + "\");")
    a.appendChild(document.createTextNode("\u2715"));

    const span = document.createElement("span");
    span.setAttribute("id", "tag-span-" + tag);
    span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
    span.appendChild(document.createTextNode(tag));
    span.appendChild(a);
    document.getElementById("selectedTags").appendChild(span);

    const hidden = document.createElement("input");
    hidden.setAttribute("id", "tag-hidden-" + tag);
    hidden.setAttribute("name", "tags[]");
    hidden.setAttribute("type", "hidden");
    hidden.value = tag;
    document.getElementById("create").appendChild(hidden);

    const input = document.getElementById("tag");
    input.value = "";
    input.focus();
}

window.removeTagFromSelection = function(tag) {
    document.getElementById("tag-span-" + tag).remove();
    document.getElementById("tag-hidden-" + tag).remove();
}
