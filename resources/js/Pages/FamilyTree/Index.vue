<template>
    <AppLayout title="Family Tree">
        <div class="p-4">
            <h1 class="text-2xl font-bold mb-4">Семейное древо</h1>
            <TreeNode :person="tree" />
        </div>
    </AppLayout>
</template>
  
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import TreeNode from './TreeNode.vue'
defineProps({ tree: Object })
</script>