<script setup>
defineProps({
  post: Object
})
</script>

<template>
    <div class="bg-white p-4 rounded-lg shadow-md">
      <div class="flex justify-between items-center mb-2">
        <div>
          <h3 class="font-bold text-lg">{{ post.title }}</h3>
          <p class="text-sm text-gray-500">By {{ post.author }}</p>
        </div>
        <div v-if="post.verified" class="text-green-600 text-sm font-semibold">
          Verified
        </div>
      </div>
      <p class="text-gray-700">{{ post.content }}</p>
      <div class="flex justify-between mt-3 text-sm text-gray-600">
        <div>
          <span v-for="tag in post.tags" :key="tag" class="mr-2">#{{ tag }}</span>
        </div>
        <div>{{ post.likes }} likes</div>
      </div>
    </div>
</template>