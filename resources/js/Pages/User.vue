<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    user: Object,
    posts: Array
})

</script>


<template>
    <AppLayout title="User">
        <div class="container mx-auto px-6 py-8">
            <!-- User Profile -->
            <div class="flex flex-col items-center bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center text-blue-500 text-4xl font-bold">
                    {{ user.name.charAt(0) }}
                </div>
                <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ user.name }}</h1>
                <p class="text-sm text-gray-500 mt-1">Email: {{ user.email }}</p>
                <p class="text-sm text-gray-500">Nationality: {{ user.nationality }}</p>
            </div>

            <!-- Posts Section -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Posts by {{ user.name }}</h2>
                <div class="flex flex-col gap-6">
                    <div
                        v-for="post in posts"
                        :key="post.id"
                        class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow"
                    >
                        <h3 class="text-lg font-semibold text-gray-800">{{ post.title }}</h3>
                        <p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ post.content }}</p>
                        <div class="mt-4 text-right">
                            <a
                                href="#"
                                class="text-blue-500 hover:underline text-sm font-medium"
                            >
                                Read more
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>