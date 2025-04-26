<script setup>
import { ref } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import TreeNode from '@/Pages/Shezhire/TreeNode.vue'; // We will create this!

defineProps({
    tree: Object,
    rootPersonId: Number,
});
</script>

<template>
    <AppLayout title="My Shezhire">

        <div class="p-6">
            <h1 class="text-2xl font-bold mb-6">My Shezhire (Family Tree)</h1>

            <div class="flex justify-center">
                <TreeNode :person="tree" />
            </div>
        </div>
    </AppLayout>
</template>