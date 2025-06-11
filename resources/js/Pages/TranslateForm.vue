<script setup>
import { ref } from 'vue'
import axios from 'axios'

const text = ref("")
const targetLanguage = ref("Kazakh")
const translated = ref("")

const translateText = async () => {
  const response = await axios.post('/api/translate', {
    text: text.value,
    target_language: targetLanguage.value
  });
  translated.value = response.data;
}
</script>

<template>
  <div>
    <form @submit.prevent="translateText">
      <textarea v-model="text" placeholder="Enter text to translate" class="border p-2 w-full"></textarea>
      <select v-model="targetLanguage" class="border p-2 mt-2">
        <option value="Kazakh">Kazakh</option>
        <option value="Russian">Russian</option>
        <option value="English">English</option>
      </select>
      <button class="bg-blue-500 text-white p-2 mt-2">Translate</button>
    </form>

    <div v-if="translated" class="mt-4 bg-gray-100 p-4">
      <strong>Translated:</strong> {{ translated }}
    </div>
  </div>
</template>