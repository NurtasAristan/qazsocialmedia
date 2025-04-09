<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const { group, users, isFollowing } = defineProps({ 
    group: Object,
    users: Array,
    isFollowing: Boolean,
})

const following = ref(isFollowing)
const loading = ref(false)

const toggleFollow = async () => {
  loading.value = true
  try {
    await router.post(`/groups/${group.id}/follow`, {}, {
      preserveScroll: true,
      onSuccess: () => {
        following.value = !following.value
      }
    })
  } finally {
    loading.value = false
  }
}
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
          <button
            @click="toggleFollow"
            class="ml-4 px-4 py-2 rounded bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50"
            :disabled="loading"
          >
            {{ following ? 'Unfollow' : 'Follow' }}
          </button>
          <div class="font-bold mb-2">{{ users.length }}</div>
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