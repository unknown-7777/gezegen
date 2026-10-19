<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/index.js'

const cities = ref([])
const newCity = ref({ name: '', slug: '' })
const editingCity = ref(null)
const error = ref('')

onMounted(async () => {
    await fetchCities()
})

async function fetchCities() {
    const response = await api.get('/cities')
    cities.value = response.data
}

async function createCity() {
    if (!newCity.value.name || !newCity.value.slug) {
        error.value = 'Both fields are required'
        return
    }
    try {
        await api.post('/cities', newCity.value)
        newCity.value = { name: '', slug: '' }
        error.value = ''
        await fetchCities()
    } catch (e) {
        error.value = e.response.data.message
    }
}

function startEdit(city) {
    editingCity.value = { ...city }
}

async function updateCity() {
    try {
        await api.patch(`/cities/${editingCity.value.id}`, {
            name: editingCity.value.name,
            slug: editingCity.value.slug,
        })
        editingCity.value = null
        await fetchCities()
    } catch (e) {
        error.value = e.response.data.message
    }
}

async function deleteCity(id) {
    if (!confirm('Are you sure?')) return
    await api.delete(`/cities/${id}`)
    await fetchCities()
}
</script>

<template>
  <div class="max-w-3xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Cities</h1>

    <p v-if="error" class="text-red-500 mb-4">{{ error }}</p>

    <div class="bg-gray-50 rounded-xl p-4 mb-6">
      <h2 class="text-lg font-semibold mb-3">Add New City</h2>
      <div class="flex gap-3">
        <input
          v-model="newCity.name"
          placeholder="City name"
          class="border rounded-lg px-3 py-2 flex-1 outline-none focus:ring-2 focus:ring-blue-400"
        />
        <input
          v-model="newCity.slug"
          placeholder="slug"
          class="border rounded-lg px-3 py-2 flex-1 outline-none focus:ring-2 focus:ring-blue-400"
        />
        <button
          @click="createCity"
          class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition"
        >
          Add
        </button>
      </div>
    </div>

    <div class="space-y-3">
      <div
        v-for="city in cities"
        :key="city.id"
        class="bg-white border rounded-xl p-4 flex items-center justify-between shadow-sm"
      >
        <div v-if="!editingCity || editingCity.id !== city.id">
          <p class="font-semibold text-gray-800">{{ city.name }}</p>
          <p class="text-gray-400 text-sm">{{ city.slug }}</p>
        </div>

        <div v-else class="flex gap-2 flex-1 mr-4">
          <input
            v-model="editingCity.name"
            class="border rounded-lg px-3 py-1 flex-1 outline-none focus:ring-2 focus:ring-blue-400"
          />
          <input
            v-model="editingCity.slug"
            class="border rounded-lg px-3 py-1 flex-1 outline-none focus:ring-2 focus:ring-blue-400"
          />
        </div>

        <div class="flex gap-2">
          <button
            v-if="editingCity && editingCity.id === city.id"
            @click="updateCity"
            class="bg-green-500 text-white px-4 py-1 rounded-lg hover:bg-green-600 transition text-sm"
          >
            Save
          </button>

          <button
            v-else
            @click="startEdit(city)"
            class="bg-yellow-400 text-white px-4 py-1 rounded-lg hover:bg-yellow-500 transition text-sm"
          >
            Edit
          </button>

          <button
            @click="deleteCity(city.id)"
            class="bg-red-500 text-white px-4 py-1 rounded-lg hover:bg-red-600 transition text-sm"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
