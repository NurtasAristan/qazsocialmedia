<script setup>
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

defineProps({
    person: Object,
});

const form = useForm({
    full_name: '',
    type: 'child',
});

function submit() {
    form.post(route('shezhire.addRelative', { person: person.id }), {
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout title="Shezhire">
        <div class="p-6 space-y-8">
            <h1 class="text-2xl font-bold text-center">{{ person.full_name }}</h1>

            <!-- Family Tree View -->
            <div class="flex flex-col items-center space-y-6">

                <!-- Parents -->
                <div class="flex flex-col items-center">
                    <div class="font-semibold mb-1">Parents</div>
                    <div class="flex space-x-4">
                        <div
                            v-for="parent in person.parents"
                            :key="parent.id"
                            class="p-3 bg-gray-100 rounded-lg border shadow-sm"
                        >
                            {{ parent.full_name }}
                        </div>
                    </div>
                </div>

                <!-- Self + Spouses -->
                <div class="flex flex-col items-center">
                    <div class="p-3 bg-blue-100 rounded-lg border shadow text-center">
                        {{ person.full_name }}
                    </div>
                    <div class="w-px h-6 bg-gray-400"></div>
                    <div class="relative flex items-center justify-center space-x-6 mt-2 w-full">
                        <div class="absolute top-1/2 left-0 right-0 h-px bg-gray-400 z-0"></div>
                        <div
                            v-for="spouse in person.spouses"
                            :key="spouse.id"
                            class="relative z-10 p-3 bg-gray-100 rounded-lg border shadow-sm"
                        >
                            {{ spouse.full_name }}
                        </div>
                    </div>
                </div>

                <!-- Children -->
                <div class="flex flex-col items-center">
                    <div class="font-semibold mb-1">Children</div>
                    <div class="flex space-x-4">
                        <div
                            v-for="child in person.children"
                            :key="child.id"
                            class="p-3 bg-gray-100 rounded-lg border shadow-sm"
                        >
                            {{ child.full_name }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Relative Form -->
            <div class="mt-10">
                <h2 class="text-xl font-semibold mb-4">Add New Relative</h2>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Full Name</label>
                        <input
                            type="text"
                            v-model="form.full_name"
                            class="border rounded px-3 py-2 w-full"
                            required
                        />
                    </div>

                    <div>
                        <label class="block mb-1 font-medium">Relationship Type</label>
                        <select v-model="form.type" class="border rounded px-3 py-2 w-full">
                            <option value="child">Child</option>
                            <option value="parent">Parent</option>
                            <option value="spouse">Spouse</option>
                        </select>
                    </div>

                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Add Relative
                    </button>
                </form>
            </div>
        </div>
    </AppLayout>
</template>