<script setup>
import { ref } from 'vue';
import TreeNode from './TreeNode.vue';
import { router } from '@inertiajs/vue3'

const props = defineProps({
    person: Object,
});

const expanded = ref(true);

const addChild = () => {
    router.get(route('shezhire.create'), {
        parent_id: props.person.id,
    });
};

const addSpouse = () => {
    router.get(route('shezhire.create-spouse'), {
        person_id: props.person.id,
    });
};
</script>

<template>
    <div class="text-center">
        <div class="bg-white rounded shadow-md p-4 m-2 inline-block">
            <div class="font-bold text-lg">{{ person.name }}</div>
            <div class="text-sm text-gray-600">
                <div v-if="person.gender === 'male'">👨 Father</div>
                <div v-else-if="person.gender === 'female'">👩 Mother</div>
                <div v-else>👤</div>
            </div>

            <!-- Add Relative Buttons -->
            <div class="mt-2 space-x-2">
                <button @click="addChild" class="text-sm text-green-600 hover:underline">➕ Add Child</button>
                <button @click="addSpouse" class="text-sm text-pink-600 hover:underline">💍 Add Spouse</button>
            </div>
        </div>

        <!-- Spouses -->
        <div v-if="person.spouses && person.spouses.length" class="flex justify-center gap-2 mt-2">
            <div v-for="spouse in person.spouses" :key="spouse.id" class="bg-pink-100 rounded px-2 py-1">
                ❤️ {{ spouse.name }}
            </div>
        </div>

        <!-- Children -->
        <div v-if="person.children && person.children.length" class="mt-4">
            <button @click="expanded = !expanded" class="text-blue-500 text-sm mb-2">
                {{ expanded ? 'Hide' : 'Show' }} Children ({{ person.children.length }})
            </button>

            <div v-show="expanded" class="flex flex-wrap justify-center">
                <TreeNode v-for="child in person.children" :key="child.id" :person="child" />
            </div>
        </div>
    </div>
</template>