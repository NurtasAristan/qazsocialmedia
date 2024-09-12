<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    myPosts: Array,
    categories: Array
})

const form = useForm({
    content: null,
})
</script>

<template>
    <AppLayout title="Dashboard">
        <div class="flex items-center bg-transparent">
            <form @submit.prevent="form.post('/dashboard')" class="w-full max-w-md rounded border-2 bg-yellow-300">
                <div class="p-2">
                    <textarea v-model="form.content" id="content" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Content" required />
                </div>
                <div class="p-2 flex items-center justify-end">
                    <button type="submit" class="p-4 text-white inline-flex justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <div v-for="post in myPosts" :key="post.id" class="my-4 p-2 w-64 rounded border-2">
            <p>{{ post.content }}</p>
        </div>
    </AppLayout>
</template>
