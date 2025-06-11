<script setup>
import axios from 'axios'
import { ref, computed } from 'vue'
import {Link} from '@inertiajs/vue3';
const props = defineProps({
  userId: Number,
  post: Object
})
const translation = ref('')
const isTranslating = ref(false)
const translatePost = async() => {
  isTranslating.value = true
  try {
    const response = await axios.post('/api/translate', {
      text: props.post.content,
      target_language: 'Kazakh',
    })
    translation.value = response.data
  } catch (e) {
    console.error(e)
  } finally {
    isTranslating.value = false
  }
}

const likes = ref([...props.post.likes ?? []])
const isLiked = computed(() => {
  if (!Array.isArray(likes.value)) {
    return false;
  }
  return likes.value.some(like => like.user_id === props.userId);
});

async function postLike() {
  try {
    const { data } = await axios.post(`/posts/${props.post.id}/likes`) 
    likes.value = data
    isLiked.value = true
  } catch (e) {
    console.error('Failed to post like:', e);
  }
}

const newComment = ref('')
const comments = ref([...props.post.comments ?? []])
async function sendComment() {
  try {
    const { data } = await axios.post(`/posts/${props.post.id}/comments`, {
      content: newComment.value
    })
    comments.value.push(data)
    newComment.value = ''
  } catch (e) {
    console.error('Failed to send comment:', e);
  }
}
</script>

<template>
  <div class="bg-white rounded-xl border border-gray-200 p-2">
    <div class="text-sm text-gray-600">
      <Link :href="'/user/'+encodeURIComponent(props.post.user.name)">{{ props.post.user.name }}</Link> | {{ new Date(props.post.created_at).toLocaleDateString() }}
    </div>
    <div class="text-base text-gray-800">{{ props.post.content }}</div>
    <button
      @click="translatePost"
      class="text-blue-600 hover:underline mt-3 block"
      :disabled="isTranslating"
    >
      {{ isTranslating ? 'Translating...' : 'Translate to Kazakh' }}
    </button>
    <div v-if="translation" class="mt-3 p-3 bg-gray-50 border border-gray-200 rounded text-gray-800">
      <strong>Translation:</strong> {{ translation }}
    </div>
    <div class="flex">
      <div class="w-12 hover:bg-gray-200 flex rounded-lg p-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" 
          class="size-6 cursor-pointer" :class="{ 'fill-red-500': isLiked }" @click="postLike">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
        <p>{{ likes.length }}</p>
      </div>
      <div class="hover:bg-gray-200 rounded-lg p-1">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 cursor-pointer">
          <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 8.511c.884.284 1.5 1.128 1.5 2.097v4.286c0 1.136-.847 2.1-1.98 2.193-.34.027-.68.052-1.02.072v3.091l-3-3c-1.354 0-2.694-.055-4.02-.163a2.115 2.115 0 0 1-.825-.242m9.345-8.334a2.126 2.126 0 0 0-.476-.095 48.64 48.64 0 0 0-8.048 0c-1.131.094-1.976 1.057-1.976 2.192v4.286c0 .837.46 1.58 1.155 1.951m9.345-8.334V6.637c0-1.621-1.152-3.026-2.76-3.235A48.455 48.455 0 0 0 11.25 3c-2.115 0-4.198.137-6.24.402-1.608.209-2.76 1.614-2.76 3.235v6.226c0 1.621 1.152 3.026 2.76 3.235.577.075 1.157.14 1.74.194V21l4.155-4.155" />
        </svg>
      </div>
      

    </div>
    <div v-for="(comment, index) in comments" :key="index" class="text-sm text-gray-700 mb-2">
      <span class="font-semibold">{{ comment.user?.name ?? 'User' }}</span>: {{ comment.comment }}
    </div>
    <div class="flex">
      <input v-model="newComment" type="text" class="py-1 rounded-lg" placeholder="Leave a comment"/>
      <button
        @click="sendComment"
        class="ml-2 px-4 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition"
        >
        Send
      </button>
    </div>
  </div>
</template>