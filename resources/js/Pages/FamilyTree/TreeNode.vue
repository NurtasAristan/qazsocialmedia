<template>
    <div class="text-center border p-2 rounded shadow w-fit mx-auto my-2">
      <div class="font-semibold">{{ person.name }}</div>
      <div class="text-sm text-gray-500">{{ person.gender }}</div>
      <a :href="`/family-tree/create/${person.id}`" class="text-blue-500 text-xs underline">+ Добавить ребёнка</a>
  
      <div v-if="person.children.length" class="flex justify-center mt-4 space-x-4">
        <TreeNode v-for="child in person.children" :key="child.id" :person="child" />
      </div>
    </div>
</template>
  
<script setup>
defineProps({ person: Object })
</script>