<template>
    <div class="relative text-center" :style="{ marginLeft: depth * 40 + 'px' }">
      <div
        class="p-2 rounded-xl border bg-white shadow-md cursor-pointer"
        @click="$emit('select', node)"
      >
        <div class="font-semibold">{{ node.name }}</div>
        <div class="text-sm text-gray-500">{{ node.gender === 'male' ? 'Ата' : 'Апа' }}</div>
        <div v-if="node.tribe" class="text-xs mt-1 text-blue-600">Ру: {{ node.tribe }}</div>
      </div>
  
      <div class="ml-4 mt-2">
        <TreeNode
          v-for="child in node.children"
          :key="child.id"
          :node="child"
          :depth="depth + 1"
          @select="$emit('select', $event)"
        />
      </div>
    </div>
  </template>
  
  <script setup>
  defineProps({
    node: Object,
    depth: {
      type: Number,
      default: 0
    }
  });
  </script>