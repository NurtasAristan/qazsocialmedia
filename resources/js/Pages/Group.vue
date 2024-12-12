<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
defineProps({ 
    group: Object,
    users: Array
})

</script>

<template>
    <AppLayout title="Group">
      <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-4">
          <h1 class="text-2xl font-bold text-gray-800">{{ group.name }}</h1>
          <p class="text-gray-600 text-sm">{{ group.created_at ? `Created on: ${new Date(group.created_at).toLocaleDateString()}` : '' }}</p>
        </div>
        <div class="p-4 rounded-md shadow-md bg-white overflow-hidden">
          <div v-if="group.description" class="mb-4">
            <p class="text-gray-700 text-base">{{ group.description }}</p>
          </div>
          <div class="font-bold mb-2">Group Members</div>
          <div v-for="user in users" :key="user.id">
            <Link :href="`/users/${user.id}`" class="block mb-2 text-gray-800 hover:underline">
              {{ user.name }}
            </Link>
          </div>
        </div>
      </div>
    </AppLayout>
  </template>