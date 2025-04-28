<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const props = defineProps({ chat: Object });
const message = ref('');
const messages = ref([...props.chat.messages]);

function sendMessage() {
    router.post(route('chat.send', props.chat.id), { content: message.value }, {
        preserveScroll: true,
        onSuccess: () => message.value = ''
    });
}

onMounted(() => {
    window.Echo.private(`chat.${props.chat.id}`)
        .listen('MessageSent', (e) => {
            messages.value.push(e.message);
        });
});

onUnmounted(() => {
    window.Echo.leave(`chat.${props.chat.id}`);
});
</script>

<template>
    <AppLayout>
        <div class="p-4 flex flex-col h-screen">
            <div class="flex-1 overflow-y-auto">
                <div v-for="msg in messages" :key="msg.id" class="mb-2">
                    <div class="font-semibold">{{ msg.sender?.name ?? 'Unknown' }}</div>
                    <div>{{ msg.content }}</div>
                </div>
            </div>

            <div class="mt-4 flex">
                <input v-model="message" class="flex-1 border rounded p-2" placeholder="Type a message..." />
                <button @click="sendMessage" class="ml-2 bg-blue-500 text-white rounded p-2">Send</button>
            </div>
        </div>
    </AppLayout>
</template>