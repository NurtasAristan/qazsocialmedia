<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
defineProps({ chats: Array });
</script>

<template>
    <AppLayout title="Chat">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Your Chats</h1>

            <div v-for="chat in chats" :key="chat.id" class="border-b py-2">
                <Link :href="route('chat.show', chat.id)">
                    <div class="text-lg font-semibold">
                        {{ chat.type === 'group' ? 'Group Chat' : chat.users.map(u => u.name).join(', ') }}
                    </div>
                    <div class="text-sm text-gray-600">
                        {{ chat.messages.length ? chat.messages[chat.messages.length - 1].content : 'No messages yet' }}
                    </div>
                </Link>
            </div>
        </div>
    </AppLayout>
    
</template>