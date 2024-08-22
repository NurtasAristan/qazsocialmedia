<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    myPosts: Array,
    categories: Array
})
</script>

<template>
    <AppLayout title="Dashboard" :categories="categories">
        <div v-for="post in myPosts" :key="post.id" class="m-4 p-2 w-64 rounded border-2">
            <div class="border-b-2">
                <span class="material-symbols-outlined rounded-full border-2">more_horiz</span>
            </div>
            <li class="inline-block px-2 border-2 rounded list-none" v-for="category in post.categories">
                <p>{{ category.category }}</p>
            </li>
            <p class="font-bold">{{ post.title }}</p>
            <p>{{ post.content }}</p>
        </div>
    </AppLayout>
</template>
