// 1. Knowledge Base
const botResponses = {
    "hello": "Hi there! I am SAFENET's virtual assistant. How can I help you?",
    "hi": "Hello! How are you feeling today?",
    "how do i report?": "You can report an incident by clicking 'Report Incident' on your dashboard. You will need to fill out a short form.",
    "is this anonymous?": "Yes, your privacy is our priority. Your reports are only seen by authorized consultants and admins.",
    "i am being bullied": "I am so sorry to hear that. Please remember this is not your fault. Save any screenshots as evidence and submit a report immediately.",
    "i feel anxious": "It is completely normal to feel that way. Take a deep breath. Try to disconnect from social media for a while.",
    "thank you": "You are very welcome! Stay safe.",
    "default": "I understand. Dealing with online issues can be tough. Would you like to file a report? You can report the incident by clicking 'Report Incident' on your dashboard. You will need to fill out a short form."
};

// 2. Detect 'Enter' key press
function handleEnter(e) {
    if (e.key === 'Enter') sendMessage();
}

// 3. Send message
function sendMessage() {
    const input = document.getElementById('chatInput');
    const text = input.value.trim();
    if (text === "") return;

    appendMessage(text, 'user-msg'); // Add user bubble
    input.value = '';

    // Bot response with delay
    setTimeout(() => {
        const response = getBotResponse(text);
        appendMessage(response, 'bot-msg'); // Add bot bubble
    }, 600);
}

// 4. Quick message buttons
function sendQuickMsg(text) {
    appendMessage(text, 'user-msg');
    setTimeout(() => {
        const response = getBotResponse(text);
        appendMessage(response, 'bot-msg');
    }, 600);
}

// 5. Bot response logic
function getBotResponse(input) {
    const lowerInput = input.toLowerCase();

    // Sort keys by length: longest first for accurate matching
    const keys = Object.keys(botResponses).sort((a, b) => b.length - a.length);

    for (const key of keys) {
        if (lowerInput.includes(key)) return botResponses[key];
    }

    return botResponses["default"]; // fallback
}

// 6. Append message bubble to chat
function appendMessage(text, className) {
    const chatBox = document.getElementById('chatBox');
    const div = document.createElement('div');
    div.className = `message ${className}`;
    div.textContent = text;
    chatBox.appendChild(div);

    chatBox.scrollTop = chatBox.scrollHeight; // Auto scroll
}
