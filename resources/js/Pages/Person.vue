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
        <div class="container mx-auto max-w-md px-2 py-6">
            <h1 class="text-xl font-semibold text-gray-800 mb-3">Create Person</h1>
            <form @submit.prevent="addPersonForm.post('/person')" class="space-y-3">
                <div>
                    <label for="name" class="block text-gray-600 text-sm mb-1">Name</label>
                    <input v-model="addPersonForm.full_name" 
                        type="text" 
                        id="name" 
                        class="w-full p-1.5 border rounded-md text-sm"
                        required />
                </div>
        
                <div>
                    <label for="dob" class="block text-gray-600 text-sm mb-1">Date of Birth</label>
                    <input v-model="addPersonForm.birth_date" 
                        type="date" 
                        id="dob" 
                        class="w-full p-1.5 border rounded-md text-sm" />
                </div>
        
                <div>
                    <label for="gender" class="block text-gray-600 text-sm mb-1">Gender</label>
                    <select v-model="addPersonForm.gender" 
                        id="gender" 
                        class="w-full p-1.5 border rounded-md text-sm">
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
        
                <div>
                    <label for="bio" class="block text-gray-600 text-sm mb-1">Bio</label>
                    <textarea v-model="addPersonForm.description" 
                        id="bio" 
                        class="w-full p-1.5 border rounded-md text-sm resize-none" 
                        rows="3"></textarea>
                </div>
        
                <button type="submit" class="bg-blue-500 text-white px-4 py-1.5 text-sm rounded-md hover:bg-blue-600">Create</button>
            </form>
        </div>
    </AppLayout>
</template>
  
  