<template>
    <div>
        <!-- Floating Button -->
        <div class="chat-circle" @click="toggleChat">💬</div>

        <!-- Chat Box -->
        <div v-if="isOpen" class="chat-box">
            <div class="chat-header">Chat</div>
            <div class="chat-messages" ref="chatContainer">
                <div v-for="(msg, index) in messages" :key="index">
                    <strong>{{ msg.session_id == 'admin' ? 'Admin' : 'Guest' }}:</strong> {{ msg.message }}
                </div>
            </div>
            <input v-model="input" @keyup.enter="sendMessage" class="chat-input" placeholder="Type a message..." />
        </div>
    </div>
</template>

<script setup>
import { ref, nextTick } from 'vue'
import axios from 'axios'

const isOpen = ref(false)
const input = ref('')
const messages = ref([])

const chatContainer = ref(null)

function toggleChat() {
    isOpen.value = !isOpen.value
    if (isOpen.value) {
        fetchMessages()
    }
}

function scrollToBottom() {
    nextTick(() => {
        if (chatContainer.value) {
            chatContainer.value.scrollTop = chatContainer.value.scrollHeight
        }
    })
}

function fetchMessages() {
    axios
        .get('/chat/history')
        .then((res) => {
            messages.value = res.data.map((msg) => ({
                sender: msg.sender || 'Guest',
                message: msg.message,
            }))
            scrollToBottom()
        })
        .catch((err) => {
            console.error('Failed to load messages', err)
        })
}

function sendMessage() {
    if (!input.value.trim()) return

    const msg = input.value.trim()

    // Optimistic update
    messages.value.push({ sender: 'You', message: msg })
    input.value = ''
    scrollToBottom()

    axios
        .post('/chat/send', { message: msg })
        .then(() => {
            fetchMessages() // refresh messages from backend if needed
        })
        .catch((err) => {
            console.error('Send failed', err)
        })
}
</script>

<style scoped>
.chat-circle {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #d03b3b;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    font-size: 24px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    z-index: 1000;
}

.chat-box {
    position: fixed;
    bottom: 90px;
    right: 20px;
    width: 300px;
    height: 400px;
    background: white;
    border: 1px solid #ccc;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
    display: flex;
    flex-direction: column;
    z-index: 1000;
}

.chat-header {
    background: #d03b3b;
    color: white;
    padding: 10px;
    font-weight: bold;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
}

.chat-messages {
    flex: 1;
    padding: 10px;
    overflow-y: auto;
    font-size: 14px;
}

.chat-input {
    border: none;
    border-top: 1px solid #ccc;
    padding: 10px;
    outline: none;
}
</style>
