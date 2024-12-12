<script setup>
import { ref } from 'vue'
import { Link, router } from '@inertiajs/vue3'

defineProps({
  post: Object,
})

const menuOpen = ref(false)

const toggleMenu = () => {
    menuOpen = !menuOpen
}

</script>

<template>
    <div >
        <span @click="menuOpen = !menuOpen" class="material-symbols-outlined rounded-full hover:bg-gray-200">more_horiz</span>
        <div v-show="menuOpen" class="menu absolute bg-white shadow rounded p-2 mt-2">
            <Link href="route('posts.show', post.id)" class="menu-item">View</Link>
            <Link href="route('posts.edit', post.id)" class="menu-item">Edit</Link>
            <button @click="deletePost" class="menu-item text-red-500">Delete</button>
        </div>
    </div>
</template>

<style scoped>
.menu {
  display: flex;
  flex-direction: column;
}

.menu-item {
  padding: 8px;
  cursor: pointer;
  text-align: left;
}

.menu-item:hover {
  background-color: #f1f1f1;
}

.action-button {
  padding: 8px 16px;
  background-color: #3490dc;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

.action-button:hover {
  background-color: #2779bd;
}
</style>