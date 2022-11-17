window.getAuthorFromInputs = function() {
    const firstname = document.getElementById('authorFirstname').value.trim();
    const lastname = document.getElementById('authorLastname').value.trim();

    if (!lastname) {
        alert('Lastname is required');
        document.getElementById("authorLastname").focus();
        return;
    }

    return lastname + (firstname ? ", " + firstname : "");
}

window.addAuthorToSelection = function(author) {

    if (!author) {
        return;
    }

    if (document.getElementById("author-span-" + author)) {
        return;
    }

    const span = createSpan(author);
    span.appendChild(createA(author));
    document.getElementById("selectedAuthors").appendChild(span);

    document.getElementById("create").appendChild(createHidden(author));

    document.getElementById("authorFirstname").focus();
    document.getElementById("authorFirstname").value = "";
    document.getElementById("authorLastname").value = "";

    function createA(author)
    {
        const a = document.createElement("a");
        a.setAttribute("id", "author-a-" + author);
        a.setAttribute("class", "ml-2 font-bold cursor-pointer");
        a.setAttribute("onclick", "removeAuthorFromSelection(\"" + author + "\");")
        a.appendChild(document.createTextNode("\u2715"));
        return a;
    }

    function createSpan(author)
    {
        const span = document.createElement("span");
        span.setAttribute("id", "author-span-" + author);
        span.setAttribute("class", "my-1 mx-1 px-2 py-0.5 bg-gray-400 rounded-xl");
        span.appendChild(document.createTextNode(author));
        return span;
    }

    function createHidden(author)
    {
        const hidden = document.createElement("input");
        hidden.setAttribute("id", "author-hidden-" + author);
        hidden.setAttribute("name", "authors[]");
        hidden.setAttribute("type", "hidden");
        hidden.value = author;
        return hidden;
    }
}

window.removeAuthorFromSelection = function(author) {
    document.getElementById("author-span-" + author).remove();
    document.getElementById("author-hidden-" + author).remove();
}
