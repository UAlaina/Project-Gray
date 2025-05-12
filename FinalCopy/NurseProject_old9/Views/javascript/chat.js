document.addEventListener('DOMContentLoaded', function() {
    const chatContainer = document.getElementById('chat-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const chatRoomId = document.getElementById('chatRoomId').value;
    const userId = document.getElementById('userId').value;
    let lastMessageId = document.getElementById('lastMessageId').value;
    
    function scrollToBottom() {
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }
    
    scrollToBottom();
    
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const message = messageInput.value.trim();
        if (!message) return;
        
        const formData = new FormData();
        formData.append('chatRoomId', chatRoomId);
        formData.append('message', message);
        
        fetch('index.php?controller=chat&action=sendMessage', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                messageInput.value = '';
            }
        })
        .catch(error => console.error('Error sending message:', error));
    });
    
    function fetchMessages() {
        fetch(`index.php?controller=chat&action=getMessages&chatRoomId=${chatRoomId}&lastId=${lastMessageId}`)
        .then(response => response.json())
        .then(messages => {
            if (messages && messages.length > 0) {
                let shouldScroll = chatContainer.scrollHeight - chatContainer.clientHeight - chatContainer.scrollTop < 100;
                
                messages.forEach(msg => {
                    const messageWrapper = document.createElement('div');
                    messageWrapper.className = `message-wrapper ${msg.sender_id == userId ? 'text-end' : 'text-start'} mb-2`;
                    
                    messageWrapper.innerHTML = `
                        <div class="message ${msg.sender_id == userId ? 'sent' : 'received'}"
                             style="display: inline-block; max-width: 70%; padding: 10px; border-radius: 10px; 
                                    background-color: ${msg.sender_id == userId ? '#dcf8c6' : '#f1f0f0'}">
                            <div class="message-content">
                                ${msg.message}
                            </div>
                            <div class="message-timestamp" style="font-size: 0.7rem; color: #999; text-align: right;">
                                ${new Date(msg.timestamp).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}
                            </div>
                        </div>
                    `;
                    
                    chatContainer.appendChild(messageWrapper);
                    
                    lastMessageId = msg.msg_id;
                });
                
                document.getElementById('lastMessageId').value = lastMessageId;
                
                if (shouldScroll) {
                    scrollToBottom();
                }
            }
        })
        .catch(error => console.error('Error fetching messages:', error));
    }
    
    setInterval(fetchMessages, 3000);
});