<script setup>
import { reactive, ref } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import DropdownMenu from '@/Components/DropdownMenu.vue'
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ 
    user: Object,
    myPosts: Array
})

const editingPost = ref(null);

const form = useForm({
    id: null,
    title: null,
    content: null,
})

const startEditing = (post) => {
    editingPost.value = post;
    form.id = post.id;
    form.title = post.title;
    form.content = post.content;
};

const cancelEditing = () => {
    editingPost.value = null;
    form.reset();
};

// Submit the edit form
const submitEdit = () => {
    form.post(`/posts/${form.id}`, {
        onSuccess: () => {
            cancelEditing();
            alert('Post updated successfully!');
        },
    });
};

const deletePost = (id) => {
    if (confirm('Are you sure you want to delete this post?')) {
        router.delete(route("home.destroy",id))
    }
};
</script>

<template>
    <AppLayout title="Home">
        <!-- Create Post Form -->
        <div class="my-8 mx-auto max-w-4xl">
            <form @submit.prevent="form.post('/home')" class="p-6 bg-white rounded-lg shadow-md">
                <div class="space-y-4">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
                        <input
                            type="text"
                            v-model="form.title"
                            id="title"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            placeholder="Enter a title"
                            required
                        />
                    </div>
                    <div>
                        <label for="content" class="block text-sm font-medium text-gray-700">Content</label>
                        <textarea
                            v-model="form.content"
                            id="content"
                            rows="4"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200"
                            placeholder="What's on your mind?"
                            required
                        ></textarea>
                    </div>
                    <div class="text-right">
                        <button
                            type="submit"
                            class="inline-block px-6 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring focus:ring-blue-300"
                        >
                        {{ $t('buttons.post') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div v-if="editingPost" class="my-8 p-6 bg-white rounded-lg shadow-md">
                <h2 class="text-xl font-semibold text-gray-700 mb-4">Edit Post</h2>
                <form @submit.prevent="submitEdit">
                    <div class="space-y-4">
                        <div>
                            <label for="edit-title" class="block text-sm font-medium text-gray-700">Title</label>
                            <input
                                v-model="form.title"
                                id="edit-title"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Enter a title"
                            />
                        </div>
                        <div>
                            <label for="edit-content" class="block text-sm font-medium text-gray-700">Content</label>
                            <textarea
                                v-model="form.content"
                                id="edit-content"
                                rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Write your content..."
                                required
                            ></textarea>
                        </div>
                        <div class="flex justify-between">
                            <button
                                type="button"
                                @click="cancelEditing"
                                class="px-4 py-2 text-sm font-medium text-gray-500 bg-gray-200 rounded-lg shadow-md hover:bg-gray-300 focus:outline-none"
                            >
                                Cancel
                            </button>
                            <button
                                type="submit"
                                class="px-6 py-2 text-sm font-medium text-white bg-green-600 rounded-lg shadow-md hover:bg-green-700 focus:outline-none"
                            >
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        <!-- Posts Section -->
        <section class="my-8">
            <div class="max-w-4xl mx-auto flex flex-col space-y-6">
                <div
                    v-for="post in myPosts"
                    :key="post.id"
                    class="bg-white p-4 rounded-lg shadow-lg hover:shadow-xl transition-shadow"
                >
                    <div class="flex justify-between items-center border-b pb-2">
                        <div>
                            <h3 class="text-lg font-bold text-gray-800">{{ user.name }}</h3>
                            <span class="text-sm text-gray-500">
                                Posted on {{ new Date(post.created_at).toLocaleDateString() }}
                            </span>
                        </div>
                        <DropdownMenu :post="post" />
                    </div>
                    <div class="mt-3">
                        <h4 class="text-md font-semibold text-gray-700">{{ post.title }}</h4>
                        <p class="mt-2 text-gray-600">{{ post.content }}</p>
                    </div>
                    <div class="mt-4 flex justify-between">
                        <button
                            class="text-sm text-blue-500 hover:underline"
                            @click="startEditing(post)"
                        >
                            Edit
                        </button>
                        <button
                            class="text-sm text-red-500 hover:underline"
                            @click="deletePost(post.id)"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </section>
    </AppLayout>
</template>
