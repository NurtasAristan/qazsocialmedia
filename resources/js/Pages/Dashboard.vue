<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ articles: Array })
</script>

<template>
    <AppLayout title="Dashboard">
        <div v-for="article in articles" :key="article.id">
            <p>{{ article.title }}</p>
            <p>{{ article.content }}</p>
        </div>
    </AppLayout>
</template>
