<script setup>
import Post from '@/Components/Post.vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';

defineProps({ 
    user: Object
})

function followUser(userId) {
    router.post(route('users.follow', userId));
}

function unfollowUser(userId) {
    router.delete(route('users.unfollow', userId));
}

</script>


<template>
    <AppLayout :title="user.name">
        <div class="container mx-auto px-6 py-8">
            <!-- User Profile -->
            <div class="flex flex-col items-center bg-white rounded-lg shadow-md p-6 mb-8">
                <div class="w-24 h-24 bg-blue-100 rounded-full flex items-center justify-center text-blue-500 text-4xl font-bold">
                    {{ user.name.charAt(0) }}
                </div>
                <h1 class="mt-4 text-2xl font-bold text-gray-800">{{ user.name }}</h1>
                <p class="text-sm text-gray-500 mt-1">Nationality: {{ user.nationality.name }}</p>
                <p class="text-sm text-gray-500">Settlement: {{ user.settlement ? user.settlement.name : 'Unknown' }}</p>
            </div>

            <div>
                <button class="border rounded-lg p-1 bg-blue-500" @click="followUser(user.id)">Follow</button>
                <button class="border rounded-lg p-1 bg-red-500" @click="unfollowUser(user.id)">Unfollow</button>
            </div>

            <!-- Posts Section -->
            <div>
                <h2 class="text-xl font-bold text-gray-800 mb-4">Posts by {{ user.name }}</h2>
                <div class="flex flex-col gap-6">
                    <Post
                        v-for="post in user.posts"
                        :post="post"
                    >
                        <!--p class="mt-2 text-sm text-gray-600 line-clamp-3">{{ post.content }}</p>
                        <div class="mt-4 text-right">
                            <a
                                href="#"
                                class="text-blue-500 hover:underline text-sm font-medium"
                            >
                                Read more
                            </a>
                        </div-->
                    </Post>
                </div>
            </div>
        </div>
    </AppLayout>
</template>