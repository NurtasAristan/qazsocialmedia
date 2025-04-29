<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import axios from 'axios';
import { ref, onMounted, onUnmounted, nextTick} from 'vue';

const props = defineProps({
  chats: Array
});

const selectedChat = ref(null);
const messages = ref([]);
const newMessage = ref("");
const messagesBox = ref(null);
let channel = null;

async function selectChat(chat) {
    selectedChat.value = chat;
    messages.value = [];

    const { data } = await axios.get(`/chats/${chat.id}/messages`);
    messages.value = data;

    channel = window.Echo.private(`chat.${chat.id}`);
    channel.listen('MessageSent', (e) => {
        messages.value.push(e.message);
        nextTick(() => scrollToBottom());
    });

    nextTick(() => scrollToBottom());
}

function scrollToBottom() {
  if (messagesBox.value) {
    messagesBox.value.scrollTop = messagesBox.value.scrollHeight;
  }
}

async function sendMessage() {
    if (!newMessage.value.trim() || !selectedChat.value) return;
    
    try {
        const { data } = await axios.post(`/chats/${selectedChat.value.id}/messages`, {
            content: newMessage.value,
        });
        
        messages.value.push(data);
        newMessage.value = '';
        nextTick(() => scrollToBottom());
    } catch (e) {
        console.error('Failed to send message:', e);
    }
}

onUnmounted(() => {
  if (channel) {
    window.Echo.leave(channel.name);
  }
});
</script>

<template>
    <AppLayout title="Chat">
        <div class="flex flex-col sm:flex-row h-[80vh] bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-200">
            <!-- Sidebar -->
            <aside class="w-full sm:w-1/4 p-4 bg-gray-100">
                <!-- Chats Header -->
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-700">Chats</h2>
                </div>

                <!-- Search Bar -->
                <div class="relative mb-4">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                        <svg
                            class="w-5 h-5 text-gray-500"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                        >
                            <path d="M21 21l-6-6M10 4a6 6 0 100 12 6 6 0 000-12z" />
                        </svg>
                    </span>
                    <input
                        type="text"
                        placeholder="Search chats"
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:ring focus:ring-blue-200 focus:outline-none focus:border-blue-500 text-gray-700"
                    />
                </div>

                <!-- Chat List -->
                <ul class="space-y-2">
                    <li
                        v-for="chat in chats"
                        :key="chat.id"
                        class="flex items-center gap-4 p-3 rounded-lg hover:bg-blue-100 cursor-pointer transition"
                        @click="selectChat(chat)"
                    >
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center text-gray-600">
                            <span class="material-symbols-outlined">person</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-800">{{ chat.users[0].name }}</h3>
                            <p class="text-sm text-gray-500 truncate">Last message in chat...</p>
                        </div>
                    </li>
                </ul>
            </aside>

            <!-- Chat Area -->
            <main class="flex-1 bg-white p-6 flex flex-col">
                <div v-if="selectedChat" class="flex-1 flex flex-col overflow-hidden">
                    <!-- Messages scrollable area -->
                    <div class="flex-1 overflow-y-auto space-y-2 pr-2" ref="messagesBox">
                        <div v-for="msg in messages" :key="msg.id" class="p-2 border rounded shadow-sm">
                            <div class="font-semibold text-sm">{{ msg.sender?.name ?? 'Unknown' }}</div>
                            <div>{{ msg.content }}</div>
                        </div>
                    </div>

                    <!-- Input area stays fixed at bottom -->
                    <div class="mt-4 flex items-center border-t pt-3">
                        <input
                            v-model="newMessage"
                            type="text"
                            placeholder="Type your message..."
                            class="flex-1 border rounded-lg px-4 py-2 focus:outline-none focus:ring focus:ring-blue-200"
                            @keydown.enter="sendMessage"
                        />
                        <button
                            @click="sendMessage"
                            class="ml-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
                        >
                            Send
                        </button>
                    </div>
                </div>

                <div v-else class="flex-1 flex items-center justify-center text-gray-500">
                    <div class="text-center">
                    <h2 class="text-xl font-semibold">No Chat Selected</h2>
                    <p class="mt-2 text-sm">Select a chat to start messaging</p>
                    </div>
                </div>
            </main>
        </div>
    </AppLayout>
</template>