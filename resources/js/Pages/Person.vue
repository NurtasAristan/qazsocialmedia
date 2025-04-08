<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
  
const form = ref({
    name: '',
    email: '',
    password: '',
    dob: '',
    gender: 'male',
    profile_picture: null,
    location: '',
    bio: ''
});
  
const handleFileUpload = (event) => {
    form.value.profile_picture = event.target.files[0];
};
  
const submitForm = async () => {
    try {
      // Submit the form data to the backend (API call)
      console.log(form.value);
      // Here you'd send the form data to an API endpoint to create a Person
    } catch (error) {
      console.error('Error creating person:', error);
    }
};
</script>

<template>
    <AppLayout title="Group">
        <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Create Person</h1>
        <form @submit.prevent="submitForm" class="space-y-4">
            <div>
                <label for="name" class="block text-gray-600">Name</label>
                <input v-model="form.name" type="text" id="name" class="w-full p-2 border rounded" required />
            </div>
    
            <div>
                <label for="dob" class="block text-gray-600">Date of Birth</label>
                <input v-model="form.dob" type="date" id="dob" class="w-full p-2 border rounded" required />
            </div>
    
            <div>
                <label for="gender" class="block text-gray-600">Gender</label>
                <select v-model="form.gender" id="gender" class="w-full p-2 border rounded">
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>
    
            <div>
                <label for="bio" class="block text-gray-600">Bio</label>
                <textarea v-model="form.bio" id="bio" class="w-full p-2 border rounded"></textarea>
            </div>
    
            <button type="submit" class="bg-blue-500 text-white p-2 rounded">Create Person</button>
        </form>
        </div>
    </AppLayout>
</template>
  
  