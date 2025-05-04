const form = document.querySelector(".typing-area"),
    chatRoomId = form ? form.querySelector(".chat_room_id").value : null,
    inputField = form ? form.querySelector(".input-field") : null,
    sendBtn = form ? form.querySelector("button") : null,
    chatBox = document.querySelector(".chat-box");

if (form) {
    form.onsubmit = (e) => {
        e.preventDefault();
    };

    inputField.focus();
    inputField.onkeyup = () => {
        if (inputField.value != "") {
            sendBtn.classList.add("active");
        } else {
            sendBtn.classList.remove("active");
        }
    };

    sendBtn.onclick = () => {
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/NurseProject/index.php?controller=Chat&action=insertChat", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    inputField.value = "";
                    scrollToBottom();
                }
            }
        };
        let formData = new FormData(form);
        formData.append("user_id", user_id);
        xhr.send(formData);
    };
}

if (chatBox) {
    chatBox.onmouseenter = () => {
        chatBox.classList.add("active");
    };

    chatBox.onmouseleave = () => {
        chatBox.classList.remove("active");
    };

    setInterval(() => {
        if (!chatRoomId) return;
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "/NurseProject/index.php?controller=Chat&action=getChat", true);
        xhr.onload = () => {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    chatBox.innerHTML = xhr.response;
                    if (!chatBox.classList.contains("active")) {
                        scrollToBottom();
                    }
                }
            }
        };
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send("chat_room_id=" + chatRoomId + "&user_id=" + user_id);
    }, 500);

    function scrollToBottom() {
        chatBox.scrollTop = chatBox.scrollHeight;
    }
}