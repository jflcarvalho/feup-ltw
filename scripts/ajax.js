function encodeForAjax(data) {
    return Object.keys(data).map(function(k){
      return encodeURIComponent(k) + '=' + encodeURIComponent(data[k])
    }).join('&');
}

function requestListener() {
    if (this.status == 200) {
        document.getElementsByTagName('html')[0].innerHTML = this.responseText;
        // console.log(JSON.parse(this.responseText));
        // JSON.parse does not parse html
    }
}

function addItemToTask(form) {
    let task = form.id.match(/@(\d+)/)[1]; // regex FTW
    let itemText = form.firstChild.value.trim();
    if (itemText.length == 0) {
        return false;
    }
    
    let request = new XMLHttpRequest();
    request.onload = requestListener;
    request.open("post", "action_add_item.php", true);
    request.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    request.send(encodeForAjax({task_id: task, description: itemText}));

    console.log({itemText, task});
    return false; // preventing event from bubbling up
}

function showSearchResult(value) {
    console.log("Searching for: " + value);
}