<div id="chatbot-widget" style="position: fixed; bottom: 20px; right: 20px; z-index: 9999; max-width: 350px;">
    <!-- Chat Engagement Bubble -->
    <div id="chatbot-bubble" class="glass-card p-3 mb-3 d-none animate-fade-in" style="position: absolute; bottom: 70px; right: 0; width: 220px; border-radius: 15px; border: 1px solid rgba(241, 229, 172, 0.2); box-shadow: 0 10px 25px rgba(0,0,0,0.5);">
        <button id="close-bubble" class="btn-close btn-close-white position-absolute" style="top: 8px; right: 10px; font-size: 0.6rem;" aria-label="Close"></button>
        <p class="text-silver-dim mb-0 small" style="line-height: 1.4; padding-right: 15px;">
            Want to know more about our <span class="text-accent fw-bold">AR features</span>?
        </p>
    </div>

    <!-- Chat Button -->
    <button id="chatbot-btn" class="btn btn-primary rounded-circle shadow-lg p-3 d-flex align-items-center justify-content-center shadow-accent-glow" style="width: 60px; height: 60px; background-color: var(--accent); border: none;">
        <i class="fas fa-comments fa-2x text-primary"></i>
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
    const chatWindow = document.getElementById('chatbot-window');
    const close = document.getElementById('chatbot-close');
    const form = document.getElementById('chatbot-form');
    const input = document.getElementById('chatbot-input');
    const messages = document.getElementById('chatbot-messages');
    const bubble = document.getElementById('chatbot-bubble');
    const closeBubble = document.getElementById('close-bubble');

    // Show bubble after delay
    setTimeout(() => {
        if (chatWindow.classList.contains('d-none')) {
            bubble.classList.remove('d-none');
        }
    }, 3000);

    closeBubble.addEventListener('click', (e) => {
        e.stopPropagation();
        bubble.classList.add('d-none');
    });

    // Toggle Window
    btn.addEventListener('click', () => {
        btn.classList.add('d-none');
        bubble.classList.add('d-none');
        chatWindow.classList.remove('d-none');
    });

    close.addEventListener('click', () => {
        chatWindow.classList.add('d-none');
        btn.classList.remove('d-none');
        // Don't reshown the bubble once they close it or open the chat
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
