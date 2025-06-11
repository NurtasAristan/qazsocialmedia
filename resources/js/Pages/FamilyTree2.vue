<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';

onMounted(() => {
  let familyTree = new FamilyTree2(document.getElementById('tree'));
  familyTree.readOnly = false;

  familyTree.addFamilyMembers([
      { 
          id: 1, 
          fatherId: 2, 
          motherId: 3,
          name: 'Мен' 
      }, 
      {id: 2, fatherId: 4, spouseIds: [3], childIds: [1], name: 'Мерхат'},
      {id: 3, spouseIds: [2], childIds: [1], name: 'Маргисат'},
      {id: 4, childIds: [2], name: 'Мәдени'},
      {id: 5, fatherId: 4, name: 'Нұрлан'}
  ]).draw(2);

  // Remove the elements "Balkan FamilyTree JS 2"
  const tspanElements = document.querySelectorAll('tspan');
  console.log(tspanElements);
  tspanElements.forEach(tspan => {
      tspan.remove();
  });
});

const addRelative = () => {

}
</script>

<template>
  <AppLayout title="Family Tree">
    <div id="tree" style="width: 100%; height: 600px;"></div>
    <div>
      <button class="border bg-blue-500">Add a relative</button>
      <button class="border bg-pink-500">Delete a relative</button>
    </div>
    <form @submit.prevent="">
      <div>
        <label for="person-filter" class="block text-sm font-medium text-gray-600 mb-1">
          Person
        </label>
        <select id="person" class="rounded-lg">
          <option :value="1">Nurtas</option>
        </select>
        <label for="relationship-type-filter" class="block text-sm font-medium text-gray-600 mb-1">
          Relationship type
        </label>
        <select id="relationship_type" class="rounded-lg">
          <option value="parent">Parent</option>
          <option value="spouse">Spouse</option>
          <option value="child">Child</option>
        </select>
        <label for="name-filter" class="block text-sm font-medium text-gray-600 mb-1">
          Name
        </label>
        <input type="text" class="rounded-lg" placeholder="Name">
      </div>
    </form>
  </AppLayout>
</template>