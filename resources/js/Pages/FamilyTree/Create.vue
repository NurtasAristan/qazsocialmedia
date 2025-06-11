<template>
    <AppLayout title="Family Tree - Create">
        <div class="p-4">
            <h2 class="text-xl font-bold mb-4">Добавить члена семьи</h2>
            <form @submit.prevent="submit">
                <input v-model="form.name" placeholder="Имя" class="border p-2 mb-2 block w-full" />
                <select v-model="form.gender" class="border p-2 mb-2 block w-full">
                <option value="male">Мужской</option>
                <option value="female">Женский</option>
                </select>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Сохранить</button>
            </form>
        </div>
    </AppLayout>
</template>
  
<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
  import { useForm } from '@inertiajs/vue3'
  
  const props = defineProps({ parent: Object })
  
  const form = useForm({
    name: '',
    gender: '',
    parent_id: props.parent?.id || null,
  })
  
  function submit() {
    form.post('/family-tree')
  }
</script>