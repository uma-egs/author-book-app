<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authors & Books</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white p-4 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">Authors & Books</a>
            <div class="space-x-4">
                <a href="{{ route('authors.index') }}" class="hover:underline">Authors</a>
                <a href="{{ route('books.index') }}" class="hover:underline">Books</a>
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-4">
        @yield('content')
    </main>

    <!-- Chatbot Widget -->
    <div x-data="chatbot" class="fixed bottom-4 right-4 w-80 bg-white rounded-lg shadow-lg border border-gray-300 overflow-hidden">
        <div class="bg-blue-600 text-white p-3 flex justify-between items-center">
            <h3 class="font-bold">Library Assistant</h3>
            <button @click="toggleChat" class="focus:outline-none">
                <span x-text="isOpen ? '×' : '↑'" class="text-xl"></span>
            </button>
        </div>
        
        <div x-show="isOpen" x-transition class="h-64 flex flex-col">
            <div class="flex-1 p-3 overflow-y-auto space-y-2" id="chat-messages">
                <template x-for="(message, index) in messages" :key="index">
                    <div :class="{'text-right': message.sender === 'user', 'text-left': message.sender === 'bot'}" class="mb-2">
                        <div :class="{'bg-blue-100 text-blue-800': message.sender === 'bot', 'bg-blue-600 text-white': message.sender === 'user'}" 
                             class="inline-block rounded-lg px-3 py-2 max-w-xs">
                            <span x-text="message.text"></span>
                        </div>
                    </div>
                </template>
            </div>
            
            <div class="p-3 border-t border-gray-300">
                <form @submit.prevent="sendMessage" class="flex">
                    <input x-model="userInput" type="text" placeholder="Ask me about authors or books..." 
                           class="flex-1 border border-gray-300 rounded-l-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700 focus:outline-none">
                        Send
                    </button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('chatbot', () => ({
                isOpen: false,
                userInput: '',
                messages: [
                    { sender: 'bot', text: 'Hello! I can help you with information about authors and books. Try asking "How many authors are there?" or "List top 5 authors".' }
                ],
                
                toggleChat() {
                    this.isOpen = !this.isOpen;
                    if (this.isOpen) {
                        this.$nextTick(() => {
                            this.scrollToBottom();
                        });
                    }
                },
                
                sendMessage() {
                    if (!this.userInput.trim()) return;
                    
                    // Add user message
                    this.messages.push({ sender: 'user', text: this.userInput });
                    
                    // Save the user input
                    const query = this.userInput;
                    this.userInput = '';
                    
                    // Show typing indicator
                    this.messages.push({ sender: 'bot', text: '...' });
                    
                    // Scroll to bottom
                    this.scrollToBottom();
                    
                    // Send to server
                    fetch('/chatbot/query', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ query })
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Remove typing indicator
                        this.messages.pop();
                        
                        // Add bot response
                        this.messages.push({ sender: 'bot', text: data.response });
                        
                        // Scroll to bottom
                        this.scrollToBottom();
                    });
                },
                
                scrollToBottom() {
                    const messagesContainer = document.getElementById('chat-messages');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }));
        });
    </script>
</body>
</html>