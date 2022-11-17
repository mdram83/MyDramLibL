window.addTagToSelection = function(tag) {

    if (!tag) {
        return;
    }

    if (document.getElementById("tag-span-" + tag)) {
        return;
    }

    const span = createSpan(tag);
    span.appendChild(createA(tag));
    document.getElementById("selectedTags").appendChild(span);

    document.getElementById("create").appendChild(createHidden(tag));

    const input = document.getElementById("tag");
    input.value = "";
    input.focus();

    function createA(tag)
    {
        const a = document.createElement("a");
        a.setAttribute("id", "tag-a-" + tag);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.setAttribute("onclick", "removeTagFromSelection(\"" + tag + "\");")
        a.appendChild(document.createTextNode("\u2715"));
        return a;
    }

    function createSpan(tag)
    {
        const span = document.createElement("span");
        span.setAttribute("id", "tag-span-" + tag);
        span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(tag));
        return span;
    }

    function createHidden(tag)
    {
        const hidden = document.createElement("input");
        hidden.setAttribute("id", "tag-hidden-" + tag);
        hidden.setAttribute("name", "tags[]");
        hidden.setAttribute("type", "hidden");
        hidden.value = tag;
        return hidden;
    }
}

window.removeTagFromSelection = function(tag) {
    document.getElementById("tag-span-" + tag).remove();
    document.getElementById("tag-hidden-" + tag).remove();
}
