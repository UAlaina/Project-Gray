const searchBar = document.querySelector(".search input");
const searchBtn = document.querySelector(".search button");
const usersList = document.querySelector(".users-list");

searchBtn.onclick = () => {
    searchBar.classList.toggle("active");
    searchBtn.classList.toggle("active");
    searchBar.focus();
    searchBar.value = "";
};

searchBar.onkeyup = () => {
    let searchTerm = searchBar.value;
    if (searchTerm != "") {
        searchBar.classList.add("active");
    } else {
        searchBar.classList.remove("active");
    }
    
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/NurseProject/index.php?controller=Chat&action=search", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                usersList.innerHTML = xhr.response;
            }
        }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("searchTerm=" + encodeURIComponent(searchTerm) + "&user_id=" + user_id);
};

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "/NurseProject/index.php?controller=Chat&action=getChatRooms", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                if (!searchBar.classList.contains("active")) {
                    usersList.innerHTML = xhr.response;
                }
            }
        }
    };
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("user_id=" + user_id);
}, 500);