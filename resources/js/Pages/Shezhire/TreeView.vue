<script setup>
import { ref } from 'vue';

// Props
defineProps({
    person: Object,   // A person with children already loaded
    depth: {
        type: Number,
        default: 0,  // To control indentation
    },
});
</script>

<template>
    <div :class="['ml-' + depth * 4, 'mb-6']">
        <div class="flex items-center space-x-2">
            <div class="font-semibold text-gray-800">{{ person.full_name }}</div>
            <div v-if="person.birth_date" class="text-gray-500 text-sm">({{ person.birth_date }})</div>
        </div>

        <!-- Render children if any -->
        <div v-if="person.children && person.children.length" class="mt-2">
            <TreeView
                v-for="child in person.children"
                :key="child.id"
                :person="child"
                :depth="depth + 1"
            />
        </div>
    </div>
</template>

<script>
export default {
    name: 'TreeView',
};
</script>

<style scoped>
/* Optional: nice tree look */
div {
    transition: all 0.3s ease;
}
</style>