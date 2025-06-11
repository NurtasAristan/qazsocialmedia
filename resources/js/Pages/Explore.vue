<script setup>
import { ref } from 'vue';
import {Link, router} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import Post from '@/Components/Post.vue';

defineProps({ 
    userId: Number,
    posts: Array,
})

// Reactive state for the search query
const searchQuery = ref('');

const performSearch = () => {
    router.get('/explore', { search: searchQuery.value }, {
        preserveState: true, // Keeps the state (e.g., pagination) intact
        replace: true, // Avoids adding redundant history entries
    });
};

</script>

<template>
    <AppLayout title="Explore">
        <!-- Search Form -->
        <form @submit.prevent="performSearch" class="max-w-xl mx-auto my-6">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path
                            stroke="currentColor"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"
                        />
                    </svg>
                </div>
                <input
                    v-model="searchQuery"
                    type="search"
                    id="search-posts"
                    class="block w-full p-4 ps-12 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search posts..."
                />
                <button
                    type="submit"
                    class="absolute end-2.5 bottom-2.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800"
                >
                    Search
                </button>
            </div>
        </form>

        <!-- Posts List -->
        <div class="flex flex-col gap-6 max-w-3xl mx-auto">
            <Post v-for="post in posts" :userId="userId" :post="post"></Post>
            <!--div
                v-for="post in posts"
                :key="post.id"
                class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow border border-gray-200"
            >
                <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                    {{ post.content }}
                </p>
                <div class="mt-4 text-sm text-gray-500">
                    {{ post.user.name }} | {{ new Date(post.created_at).toLocaleDateString() }}
                </div>
            </div-->
        </div>
    </AppLayout>
</template>