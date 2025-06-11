<script setup>
import { ref } from 'vue';
import {Link, router} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    users: Array,
    settlements: Array,
    nationalities: Array
})

const searchQuery = ref('');

const performSearch = () => {
    router.get('/explore', { search: searchQuery.value }, {
        preserveState: true, // Keeps the state (e.g., pagination) intact
        replace: true, // Avoids adding redundant history entries
    });
};
</script>

<template>
    <AppLayout title="Friends">
        <div class="container mx-auto px-6 py-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Friends</h1>
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
                        placeholder="Search users..."
                    />
                    <button
                        type="submit"
                        class="absolute end-2.5 bottom-2.5 px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-700 dark:hover:bg-blue-800 dark:focus:ring-blue-800"
                    >
                        Search
                    </button>
                </div>
            </form>

            <!-- Filters and User Cards -->
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Filters -->
                <div class="w-full sm:w-1/3 bg-gray-100 p-4 rounded-lg shadow-md sm:self-start">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Filters</h2>
                    <div>
                        <label for="gender-filter" class="block text-sm font-medium text-gray-600 mb-1">
                            Gender
                        </label>
                        <input type="radio" name="gender" value="any" checked><label>Any</label>
                        <input type="radio" name="gender" value="male"><label>Male</label>
                        <input type="radio" name="gender" value="female"><label>Female</label>
                    </div>
                    <div>
                        <label for="settlement-filter" class="block text-sm font-medium text-gray-600 mb-1">
                            Settlement
                        </label>
                        <select
                            id="settlement-filter"
                            class="w-full p-2 rounded border border-gray-300 focus:ring focus:ring-blue-200 focus:outline-none focus:border-blue-500"
                        >
                            <option value="" disabled selected>Choose a settlement</option>
                            <option v-for="settlement in settlements" :key="settlement.id" :value="settlement.id">
                                {{ settlement.name }}
                            </option>
                        </select>
                    </div>
                    <div class="mt-4">
                        <label for="nationality-filter" class="block text-sm font-medium text-gray-600 mb-1">
                            Nationality
                        </label>
                        <select
                            id="nationality-filter"
                            class="w-full p-2 rounded border border-gray-300 focus:ring focus:ring-blue-200 focus:outline-none focus:border-blue-500"
                        >
                            <option value="" disabled selected>Choose a nationality</option>
                            <option v-for="nationality in nationalities" :key="nationality.id" :value="nationality.id">
                                {{ nationality.name }}
                            </option>
                        </select>
                    </div>
                </div>

                <!-- User Cards -->
                <div class="w-full sm:w-2/3">
                    <div v-if="users.length === 0" class="text-center text-gray-500 text-lg mt-10">
                        No users found matching your criteria.
                    </div>
                    <div v-else class="flex flex-col gap-4">
                        <div
                            v-for="user in users"
                            :key="user.id"
                            class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow"
                        >
                            <Link :href="'/user/'+encodeURIComponent(user.name)" class="block">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                        <img v-if="user.profile_photo_url" :src="user.profile_photo_url" class="h-8 w-8 rounded-full" alt="Profile">
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">{{ user.name }}</h3>
                                    <p class="text-lg text-gray-800">{{ user.nationality ? user.nationality.name : 'Unknown'}}</p>
                                    <p class="text-lg text-gray-800">{{ user.settlement ? user.settlement.name : 'Unknown' }}</p>
                                </div>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>