document.addEventListener('DOMContentLoaded', function() {
    const aiAgentTrigger = document.getElementById('aiAgentTrigger');
    const aiAgentModal = document.getElementById('aiAgentModal');
    const aiAgentClose = document.getElementById('aiAgentClose');
    const aiAgentInput = document.getElementById('aiAgentInput');
    const aiAgentSend = document.getElementById('aiAgentSend');
    const aiAgentMessages = document.getElementById('aiAgentMessages');

    // Sample responses (replace with actual AI responses later)
    const sampleResponses = [
        "I can help you learn more about our educational technology solutions. What specific area interests you?",
        "Our AI solutions are designed to enhance learning experiences. Would you like to know more about a particular feature?",
        "We offer comprehensive IoT solutions for educational institutions. I'd be happy to explain how they can benefit your organization.",
        "Our cloud computing services are tailored for educational needs. What challenges are you looking to address?",
        "I can provide information about our professional development programs. Which area would you like to explore?"
    ];

    function toggleModal() {
        aiAgentModal.classList.toggle('show');
        if (aiAgentModal.classList.contains('show')) {
            aiAgentInput.focus();
        }
    }

    function addMessage(content, isUser = false) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `ai-message ${isUser ? 'user-message' : ''}`;
        
        messageDiv.innerHTML = `
            <div class="ai-avatar">
                <i class="fas ${isUser ? 'fa-user' : 'fa-robot'}"></i>
            </div>
            <div class="ai-message-content">
                ${content}
            </div>
        `;
        
        aiAgentMessages.appendChild(messageDiv);
        aiAgentMessages.scrollTop = aiAgentMessages.scrollHeight;
    }

    function getAIResponse(userMessage) {
        // Simple keyword-based responses (replace with actual AI logic later)
        const message = userMessage.toLowerCase();
        let response = "";

        if (message.includes('pricing') || message.includes('cost')) {
            response = "Our pricing is customized based on your institution's needs. Would you like to speak with our sales team?";
        } else if (message.includes('demo') || message.includes('trial')) {
            response = "I'd be happy to arrange a demo for you. Please provide your email address or contact our sales team at sales@artifitech.com";
        } else if (message.includes('ai') || message.includes('artificial intelligence')) {
            response = "Our AI solutions include personalized learning paths, automated assessment, and intelligent tutoring systems. Which aspect would you like to learn more about?";
        } else if (message.includes('contact') || message.includes('support')) {
            response = "You can reach our support team at support@artifitech.com or call us at +27 12 771 1212. How else can I assist you?";
        } else {
            // Random response if no keywords match
            response = sampleResponses[Math.floor(Math.random() * sampleResponses.length)];
        }

        return response;
    }

    function handleUserMessage() {
        const message = aiAgentInput.value.trim();
        if (!message) return;

        // Add user message
        addMessage(message, true);
        aiAgentInput.value = '';

        // Simulate AI thinking with typing indicator
        setTimeout(() => {
            const response = getAIResponse(message);
            addMessage(response);
        }, 1000);
    }

    // Event Listeners
    aiAgentTrigger.addEventListener('click', toggleModal);
    aiAgentClose.addEventListener('click', toggleModal);

    aiAgentSend.addEventListener('click', handleUserMessage);

    aiAgentInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            handleUserMessage();
        }
    });

    // Close modal when clicking outside
    document.addEventListener('click', function(e) {
        if (aiAgentModal.classList.contains('show') && 
            !aiAgentModal.contains(e.target) && 
            !aiAgentTrigger.contains(e.target)) {
            toggleModal();
        }
    });
});
