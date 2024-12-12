<script setup>
import {Link} from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    users: Array,
    settlements: Array,
    nationalities: Array
})
</script>

<template>
    <AppLayout title="Friends">
        <div class="container mx-auto px-6 py-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-6">Friends</h1>

            <!-- Filters and User Cards -->
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Filters -->
                <div class="w-full sm:w-1/3 bg-gray-100 p-4 rounded-lg shadow-md">
                    <h2 class="text-lg font-semibold text-gray-700 mb-4">Filters</h2>
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
                <div class="w-full sm:w-2/3 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div
                        v-for="user in users"
                        :key="user.id"
                        class="bg-white rounded-lg shadow-md p-4 hover:shadow-lg transition-shadow"
                    >
                        <Link href="/user" :data="{ id: user.id }" class="block">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center text-gray-600">
                                    <span class="material-symbols-outlined">person</span>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-800">{{ user.name }}</h3>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Nationality: {{ user.nationality }}</p>
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>