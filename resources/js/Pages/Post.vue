<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    post: Object
})
</script>

<template>
    <AppLayout :title=post.title>
        <div>
            <p>{{ post.content }}</p>
        </div>
    </AppLayout>
</template>