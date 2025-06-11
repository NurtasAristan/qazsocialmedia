<script setup>
import { onMounted, ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import OrgChart from '@balkangraph/orgchart.js';

// Оборачиваем familyData в ref
const familyData = [
  { id: 1, name: 'Ata', title: 'Great Grandfather' },
  { id: 2, pid: 1, name: 'Baba', title: 'Grandfather' },
  { id: 3, pid: 1, name: 'Aga', title: 'Uncle' },
  { id: 4, pid: 2, name: 'Äke', title: 'Father' },
  { id: 5, pid: 4, name: 'Men', title: 'Me' },
]

const nodes = ref([...familyData])

console.log('All nodes:', nodes.value);

// Храним ссылку на экземпляр диаграммы
let chart = null;

// Добавление родителя (универсальное)
function addParent(childId, name, role = null) {
  const newId = Date.now(); // уникальный ID
  const newNode = { id: newId, name, title: role ? role.charAt(0).toUpperCase() + role.slice(1) : 'Parent' }

  const child = nodes.value.find(n => n.id === childId);
  if (!child) {
    console.warn('Child not found for ID:', childId);
    return;
  }

  // Если нужно связать двух родителей
  if (role === 'father' || role === 'mother') {
    const existingParent = nodes.value.find(n => n.id === child.pid);
    if (existingParent) {
      newNode.partner = existingParent.id;
    }
  }

  // Добавляем родителя
  nodes.value.push(newNode);

  // Обновляем pid у ребёнка
  if (!child.pid) {
    child.pid = newId;
  }

  chart.load(nodes.value);
}

onMounted(() => {
  chart = new OrgChart(document.getElementById('tree'), {
    nodes: [
    // Grandparents (Father's side)
    { id: 1, name: "Grandfather (Father's side)" },
    { id: 2, name: "Grandmother (Father's side)", tags: ["partner"] },

    // Father (child of paternal grandparents)
    { id: 3, pid: 1, mid: 2, name: "Father" },

    // Grandparents (Mother's side)
    { id: 4, name: "Grandfather (Mother's side)" },
    { id: 5, name: "Grandmother (Mother's side)", tags: ["partner"] },

    // Mother (child of maternal grandparents)
    { id: 6, pid: 4, mid: 5, name: "Mother" },

    // The main person (child of both parents)
    { id: 7, pid: 3, mid: 6, name: "The Man" },
  ],
    nodeBinding: {
      field_0: 'name',
      field_1: 'title',
    },
    template: 'ana',
    nodeMenu: {
      add: { text: "Add" },
      remove: { text: "Delete" },
    },
    menu: {
      addParent: {
            text: 'Добавить родителя',
            onClick: (node) => {
                const parentName = prompt('Введите имя родителя:')
                if (parentName) {
                    addParent(node.id, parentName)
                }
            }
        },
      addFather: {
        text: "Добавить отца",
        onClick: (id) => {
          const name = prompt("Имя отца:");
          if (name) addParent(id, name, 'father');
        }
      },
      addMother: {
        text: "Добавить мать",
        onClick: (id) => {
          const name = prompt("Имя матери:");
          if (name) addParent(id, name, 'mother');
        }
      }
    },
    enableSearch: false,
  });
});
</script>

<template>
    <AppLayout>
        <Head title="Family Tree" />
        <div class="max-w-6xl mx-auto py-8 px-4">
            <h1 class="text-2xl font-bold mb-6">Family Tree</h1>
            <div id="tree" class="w-full h-[600px] border rounded-lg"></div>
        </div>
    </AppLayout>
</template>