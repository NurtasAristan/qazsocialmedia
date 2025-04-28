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
    form.post(route('shezhire.addRelative'), {
        preserveScroll: true,
    });
}
</script>

<template>
    <AppLayout title="Shezhire">
        <div class="p-6 space-y-8">
            <h1 class="text-2xl font-bold">{{ person.full_name }}</h1>

            <!-- Relatives list -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div>
                    <h2 class="font-semibold">Children</h2>
                    <ul class="list-disc ml-4">
                        <li v-for="child in person.children" :key="child.id">
                            {{ child.full_name }}
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="font-semibold">Parents</h2>
                    <ul class="list-disc ml-4">
                        <li v-for="parent in person.parents" :key="parent.id">
                            {{ parent.full_name }}
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="font-semibold">Spouses</h2>
                    <ul class="list-disc ml-4">
                        <li v-for="spouse in person.spouses" :key="spouse.id">
                            {{ spouse.full_name }}
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Add Relative Form -->
            <div class="mt-10">
                <h2 class="text-xl font-semibold mb-4">Add New Relative</h2>
                <form @submit.prevent="submit" class="space-y-4">
                    <div>
                        <label class="block mb-1 font-medium">Full Name</label>
                        <input type="text" v-model="form.full_name" class="border rounded px-3 py-2 w-full" required />
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