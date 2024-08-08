<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    myArticles: Array,
    categories: Array
})
</script>

<template>
    <AppLayout title="Dashboard" :categories="categories">
        <div v-for="article in myArticles" :key="article.id" class="m-4 p-4 w-64 rounded border-2">
            <p class="font-bold">{{ article.title }}</p>
            <p>{{ article.content }}</p>
        </div>
    </AppLayout>
</template>
