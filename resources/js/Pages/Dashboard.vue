<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    myArticles: Array,
    categories: Array,
    artcats: Array
})
</script>

<template>
    <AppLayout title="Dashboard" :categories="categories">
        <div v-for="article in myArticles" :key="article.id" class="m-4 p-2 w-64 rounded border-2">
            <div class="border-b-2">
                <span class="material-symbols-outlined rounded-full border-2">more_horiz</span>
            </div>
            <li class="inline-block px-2 border-2 rounded list-none" v-for="category in article.categories">
                <p>{{ category.category }}</p>
            </li>
            <p class="font-bold">{{ article.title }}</p>
            <p>{{ article.content }}</p>
        </div>
    </AppLayout>
</template>
