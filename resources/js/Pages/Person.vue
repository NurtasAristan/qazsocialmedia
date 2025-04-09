<script setup>
import { ref } from 'vue';
import { Link, useForm, router } from '@inertiajs/vue3';
import AppLayout from '@/Layouts/AppLayout.vue';

const addPersonForm = useForm({
    full_name: '',
    birth_date: '',
    gender: '',
    description: '',
})
</script>

<template>
    <AppLayout title="Add Person">
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-800 mb-4">Create Person</h1>
            <form @submit.prevent="addPersonForm.post('/person')" class="space-y-4">
                <div>
                    <label for="name" class="block text-gray-600">Name</label>
                    <input v-model="addPersonForm.full_name" type="text" id="name" class="w-full p-2 border rounded" required />
                </div>
        
                <div>
                    <label for="dob" class="block text-gray-600">Date of Birth</label>
                    <input v-model="addPersonForm.birth_date" type="date" id="dob" class="w-full p-2 border rounded" />
                </div>
        
                <div>
                    <label for="gender" class="block text-gray-600">Gender</label>
                    <select v-model="addPersonForm.gender" id="gender" class="w-full p-2 border rounded">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
        
                <div>
                    <label for="bio" class="block text-gray-600">Bio</label>
                    <textarea v-model="addPersonForm.description" id="bio" class="w-full p-2 border rounded"></textarea>
                </div>
        
                <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create Person</button>
            </form>
        </div>
    </AppLayout>
</template>
  
  