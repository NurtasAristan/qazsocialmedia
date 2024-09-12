<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    posts: Array
})

</script>

<template>
    <AppLayout title="Explore">
        <div v-for="post in posts" :key="post.id" class="my-4 p-2 w-64 rounded border-2">
            <p>{{ post.content }}</p>
        </div>
    </AppLayout>
</template>