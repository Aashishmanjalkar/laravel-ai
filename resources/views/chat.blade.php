<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Gemini Chatbot</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

<div class="bg-white rounded-2xl shadow-lg w-full max-w-xl p-6 flex flex-col gap-4">
    <h1 class="text-2xl font-bold text-center text-indigo-600">💬 Gemini Chatbot</h1>

    <div id="chat-box" class="h-80 overflow-y-auto flex flex-col gap-3 p-3 bg-gray-50 rounded-xl border">
        <p class="text-gray-400 text-sm text-center">Ask me anything...</p>
    </div>

    <div class="flex gap-2">
        <input id="user-input" type="text" placeholder="Type your message..."
            class="flex-1 border rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" />
        <button onclick="sendMessage()"
            class="bg-indigo-600 text-white px-5 py-2 rounded-xl hover:bg-indigo-700 transition">
            Send
        </button>
    </div>
</div>

<script>
    async function sendMessage() {
        const input = document.getElementById('user-input');
        const message = input.value.trim();
        if (!message) return;

        addMessage('You', message, 'text-right text-indigo-700');
        input.value = '';

        const res = await fetch('/chat/ask', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ message })
        });

        const data = await res.json();
        addMessage('Gemini', data.reply, 'text-left text-gray-700');
    }

    function addMessage(sender, text, classes) {
        const box = document.getElementById('chat-box');
        const div = document.createElement('div');
        div.className = `text-sm ${classes}`;
        div.innerHTML = `<strong>${sender}:</strong> ${text}`;
        box.appendChild(div);
        box.scrollTop = box.scrollHeight;
    }

    document.getElementById('user-input').addEventListener('keydown', e => {
        if (e.key === 'Enter') sendMessage();
    });
</script>

</body>
</html>
