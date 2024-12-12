<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    post: Object
})
</script>

<template>
    <AppLayout :title=post.title>
        <div>
            <p class="border-b-2 text-4xl font-bold">{{ post.title }}</p>
            <p>{{ post.content }}</p>
        </div>
    </AppLayout>
</template>