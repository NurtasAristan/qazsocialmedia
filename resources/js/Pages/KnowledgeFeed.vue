<script setup>
import { ref, onMounted } from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue';
import PostCard from '@/Components/PostCard.vue'

const posts = ref([])
const trendingTopics = ref(['AI', 'Space', 'Laravel', 'Climate'])

onMounted(() => {
  // Simulate fetching data
  posts.value = [
    {
      id: 1,
      author: 'Alice',
      title: 'What is Quantum Entanglement?',
      content: 'Quantum entanglement is a phenomenon where particles remain connected...',
      tags: ['Physics', 'Quantum'],
      verified: true,
      likes: 24,
    },
    {
      id: 2,
      author: 'Bob',
      title: 'Laravel 11 Tips & Tricks',
      content: 'Here are some hidden features in Laravel 11 you may not know...',
      tags: ['Laravel', 'PHP'],
      verified: false,
      likes: 15,
    }
  ]
})
</script>

<template>
  <AppLayout title="Add Person">
    <div class="flex min-h-screen bg-gray-100">
      <!-- Sidebar -->
      <aside class="w-64 bg-white p-4 border-r hidden md:block">
        <h2 class="text-xl font-bold mb-4">Filters</h2>
        <div class="space-y-2">
          <div>
            <label class="text-sm font-medium">Topic</label>
            <select class="w-full mt-1 p-2 border rounded">
              <option>All</option>
              <option>Science</option>
              <option>Programming</option>
              <option>History</option>
            </select>
          </div>
          <div>
            <label class="text-sm font-medium">Sort By</label>
            <select class="w-full mt-1 p-2 border rounded">
              <option>Latest</option>
              <option>Most Liked</option>
              <option>Verified</option>
            </select>
          </div>
        </div>
      </aside>
  
      <!-- Main Feed -->
      <main class="flex-1 p-6">
        <div class="mb-6">
          <h1 class="text-2xl font-bold">Knowledge Feed</h1>
          <p class="text-gray-500">Curated posts from trusted contributors</p>
        </div>
  
        <div class="space-y-4">
          <PostCard
            v-for="post in posts"
            :key="post.id"
            :post="post"
          />
        </div>
      </main>
  
      <!-- Right Sidebar -->
      <aside class="w-72 bg-white p-4 border-l hidden lg:block">
        <h2 class="text-lg font-semibold mb-4">Trending</h2>
        <ul class="space-y-2 text-sm text-gray-700">
          <li v-for="topic in trendingTopics" :key="topic">#{{ topic }}</li>
        </ul>
      </aside>
    </div>
  </AppLayout>
</template>