<script setup>
import { useForm, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({ 
    groups: Array
})

const form = useForm({
    name: null,
    description: null
})
</script>

<template>
    <AppLayout title="Groups">
      <div class="container mx-auto px-4 py-8">
        <form @submit.prevent="form.post('/groups')" class="bg-white rounded shadow-md p-4">
          <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Group name</label>
            <input type="text" v-model="form.name" id="name" class="block w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500" required>
          </div>
          <div class="mb-4">
            <label for="description" class="block text-sm font-medium text-gray-700">Group description</label>
            <textarea v-model="form.description" id="description" rows="4" class="block w-full px-3 py-2 rounded-md border border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500"></textarea>
          </div>
          <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Save
          </button>
        </form>
  
        <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div v-for="group in groups" :key="group.id" class="p-4 rounded-md shadow-md bg-white overflow-hidden">
            <Link href="/group" :data="{id: group.id}" class="text-xl font-bold text-gray-800 hover:underline block mb-2">
              {{ group.name }}
            </Link>
            <p class="text-gray-600 text-sm">{{ group.description || 'No description' }}</p>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>