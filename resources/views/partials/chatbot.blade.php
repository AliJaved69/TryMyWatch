<div id="chatbot-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; max-width: 350px;">
    <!-- Chat Button -->
    <button id="chatbot-btn" class="btn btn-primary rounded-circle shadow-lg p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; background-color: #c9a96e; border: none;">
        <i class="fas fa-comments fa-2x text-dark"></i>
    </button>

    <!-- Chat Window -->
    <div id="chatbot-window" class="card shadow-lg mt-3 d-none" style="border-radius: 15px; overflow: hidden; border: 1px solid #333;">
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center p-3" style="border-bottom: 1px solid #444;">
            <h5 class="mb-0 fs-6"><i class="fas fa-robot me-2 text-warning"></i>Watch Assistant</h5>
            <button id="chatbot-close" class="btn btn-sm btn-link text-white p-0"><i class="fas fa-times"></i></button>
        </div>
        <div id="chatbot-messages" class="card-body bg-light p-3" style="height: 300px; overflow-y: auto; background-color: #f8f9fa;">
            <!-- Messages go here -->
            <div class="d-flex mb-2">
                <div class="bg-warning text-dark p-2 rounded-3" style="max-width: 80%; font-size: 0.9rem;">
                    Hello! Ask me anything about our watches. ⌚
                </div>
            </div>
        </div>
        <div class="card-footer bg-white p-2">
            <form id="chatbot-form" class="d-flex gap-2">
                <input type="text" id="chatbot-input" class="form-control form-control-sm" placeholder="Type a message..." required>
                <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-paper-plane"></i></button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('chatbot-btn');
    const window = document.getElementById('chatbot-window');
    const close = document.getElementById('chatbot-close');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');

    // Toggle Window
    btn.addEventListener('click', () => {
        btn.classList.add('d-none');
        window.classList.remove('d-none');
    });

    close.addEventListener('click', () => {
        window.classList.add('d-none');
        btn.classList.remove('d-none');
    });

    // Send Message
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const msg = input.value.trim();
        if(!msg) return;

        // User Message
        appendMessage(msg, 'user');
        input.value = '';

        // Bot Typing...
        const typingId = appendMessage('Typing...', 'bot', true);

        // Send to Backend
        fetch('{{ route("chatbot.handle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ message: msg })
        })
        .then(res => res.json())
        .then(data => {
            removeMessage(typingId);
            appendMessage(data.response, 'bot');
        })
        .catch(err => {
            removeMessage(typingId);
            appendMessage("Sorry, I'm having trouble connecting.", 'bot');
        });
    });

    function appendMessage(text, sender, isTyping = false) {
        const div = document.createElement('div');
        div.className = `d-flex mb-2 ${sender === 'user' ? 'justify-content-end' : ''}`;
        
        const bubble = document.createElement('div');
        bubble.className = `p-2 rounded-3 ${sender === 'user' ? 'bg-dark text-white' : 'bg-warning text-dark'}`;
        bubble.style.maxWidth = '80%';
        bubble.style.fontSize = '0.9rem';
        bubble.textContent = text;
        
        if (isTyping) {
            div.id = 'typing-' + Date.now();
            bubble.style.fontStyle = 'italic';
            bubble.style.opacity = '0.7';
        }

        div.appendChild(bubble);
        messages.appendChild(div);
        messages.scrollTop = messages.scrollHeight;
        
        return div.id;
    }

    function removeMessage(id) {
        const el = document.getElementById(id);
        if(el) el.remove();
    }
});
</script>
