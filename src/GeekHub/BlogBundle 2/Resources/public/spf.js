function addPostForm()
{
    var postContainer = document.getElementById("postsContainer");
    var template = postContainer.getAttribute("data-prototype");
    var tempEl = document.createElement("div");
    var index = parseInt(postContainer.getAttribute("index"));
    tempEl.innerHTML = template.replace(/__name__/g, index);
    postContainer.setAttribute("index", ++index);
    postContainer.appendChild(tempEl.childNodes[0]);
}

function delPostForm(form){
    form.parentNode.removeChild(form);
}