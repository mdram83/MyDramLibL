window.addToSelection = function(value, prefix, divId, formId, hiddenInputName, focusId = null, reset = []) {

    if (!value) {
        return;
    }

    if (document.getElementById(prefix + "-span-" + value)) {
        return;
    }

    const span = createSpan(value, prefix);
    span.appendChild(createA(value, prefix));
    document.getElementById(divId).appendChild(span);
    document.getElementById(formId).appendChild(createHidden(value, prefix, hiddenInputName));

    if (focusId) {
        document.getElementById(focusId).focus();
    }

    reset.forEach(function(item) {
        document.getElementById(item).value = "";
    });

    function createSpan(value, prefix)
    {
        const span = document.createElement("span");
        span.setAttribute("id", prefix + "-span-" + value);
        span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(value));
        return span;
    }

    function createA(value, prefix)
    {
        const a = document.createElement("a");
        a.setAttribute("id", prefix + "-a-" + value);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.setAttribute("onclick", "removeFromSelection(\"" + value + "\", \"" + prefix + "\");")
        a.appendChild(document.createTextNode("\u2715"));
        return a;
    }

    function createHidden(value, prefix, hiddenInputName)
    {
        const hidden = document.createElement("input");
        hidden.setAttribute("id", prefix + "-hidden-" + value);
        hidden.setAttribute("name", hiddenInputName);
        hidden.setAttribute("type", "hidden");
        hidden.value = value;
        return hidden;
    }
}

window.removeFromSelection = function(value, prefix) {
    document.getElementById(prefix + "-span-" + value).remove();
    document.getElementById(prefix + "-hidden-" + value).remove();
}
