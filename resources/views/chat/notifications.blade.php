{{-- TODO: AJAX Code for implementing notifications
<span id="notificationBadge" class="badge badge-danger"></span>

<script>
    function getUnreadMessageCount() {
        $.ajax({
            url: "{{ route('get.unread.count') }}",
            type: "GET",
            success: function(response) {
                if (response.unread_count > 0) {
                    $("#notificationBadge").text(response.unread_count).show();
                } else {
                    $("#notificationBadge").hide();
                }
            }
        });
    }

    setInterval(getUnreadMessageCount, 5000); // Refresh every 5 sec
</script> --}}
{{--TODO: Message deletion
<button onclick="deleteMessage(1)">Delete</button>

<script>
function deleteMessage(messageId) {
    fetch(`/message/${messageId}`, {
        method: "DELETE",
        headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
    }).then(response => response.json())
      .then(data => alert(data.message));
}
</script>
--}}
{{--TODO: Query all chats
    <button onclick="getChatPartners()">Show Chat Partners</button>
<ul id="chat-partners"></ul>

<script>
function getChatPartners() {
    fetch("/chat/partners")
        .then(response => response.json())
        .then(data => {
            let list = document.getElementById("chat-partners");
            list.innerHTML = "";
            data.forEach(partner => {
                let item = document.createElement("li");
                item.textContent = `Chat with ${partner.Partner_Type} (ID: ${partner.Partner_ID})`;
                list.appendChild(item);
            });
        });
}
</script>
--}}
