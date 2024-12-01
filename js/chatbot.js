// Dialogflow Chatbot Integration
const chatbot = {
    dfMessenger: null,
    isInitialized: false,

    init() {
        // Create chat button
        const chatButton = document.createElement('button');
        chatButton.className = 'chat-button';
        chatButton.innerHTML = '<i class="fas fa-robot"></i>';
        chatButton.setAttribute('aria-label', 'Open chat');
        document.body.appendChild(chatButton);

        // Add click event to initialize chat
        chatButton.addEventListener('click', () => {
            if (!this.isInitialized) {
                this.initializeChat();
            } else {
                // Toggle chat visibility if already initialized
                const chatElement = document.querySelector('df-messenger');
                const expanded = chatElement.getAttribute('expand') === 'true';
                chatElement.setAttribute('expand', (!expanded).toString());
            }
        });
    },

    initializeChat() {
        // Initialize Dialogflow client
        this.dfMessenger = document.createElement('df-messenger');
        this.dfMessenger.setAttribute('intent', 'WELCOME');
        this.dfMessenger.setAttribute('chat-title', '🤖 ArtifiTech Support');
        this.dfMessenger.setAttribute('agent-id', 'YOUR_DIALOGFLOW_AGENT_ID');
        this.dfMessenger.setAttribute('language-code', 'en');
        
        // Create custom chat icon with robot
        const chatIcon = document.createElement('div');
        chatIcon.innerHTML = '<i class="fas fa-robot"></i>';
        this.dfMessenger.setAttribute('chat-icon', chatIcon.innerHTML);
        
        // Position on right side and set initial state
        this.dfMessenger.setAttribute('expand', 'true');
        this.dfMessenger.setAttribute('chat-position', 'right');
        
        // Customize chatbot appearance to match website theme
        this.dfMessenger.style.cssText = `
            --df-messenger-bot-message: var(--primary-dark);
            --df-messenger-button-titlebar-color: var(--primary-dark);
            --df-messenger-chat-background-color: var(--bg-primary);
            --df-messenger-send-icon: var(--accent-red);
            --df-messenger-user-message: var(--accent-red);
            --df-messenger-font-color: var(--text-primary);
            --df-messenger-input-box-color: var(--bg-secondary);
            --df-messenger-input-font-color: var(--text-primary);
            --df-messenger-input-placeholder-font-color: var(--text-secondary);
        `;
        
        document.body.appendChild(this.dfMessenger);
        this.isInitialized = true;
    }
};

// Initialize chat button when DOM is loaded
document.addEventListener('DOMContentLoaded', () => chatbot.init()); 