<script setup>
import { ref, onMounted } from 'vue'
import api from '../api/index.js'

const hotels = ref([])
const cities = ref([])
const error = ref('')
const editingHotel = ref(null)
const newHotel = ref({
    city_id: '',
    name: '',
    slug: '',
    address: '',
    capacity: '',
    phone: '',
    rating: '',
    description: '',
})

onMounted(async () => {
    await fetchHotels()
    await fetchCities()
})

async function fetchHotels() {
    const response = await api.get('/hotels')
    hotels.value = response.data.data
}

async function fetchCities() {
    const response = await api.get('/cities')
    cities.value = response.data
}

async function createHotel() {
    try {
        await api.post('/hotels', newHotel.value)
      newHotel.value = {
        city_id: '', name: '',
        slug: '', address: '',
        capacity: '', phone: '',
        rating: '', description: ''
      }
        error.value = ''
        await fetchHotels()
    } catch (e) {
        error.value = e.response.data.message
    }
}

function startEdit(hotel) {
    editingHotel.value = { ...hotel, city_id: hotel.city.id }
}

async function updateHotel() {
    try {
        await api.patch(`/hotels/${editingHotel.value.id}`, {
            name: editingHotel.value.name,
            address: editingHotel.value.address,
            phone: editingHotel.value.phone,
            rating: editingHotel.value.rating,
            city_id: editingHotel.value.city_id,
        })
        editingHotel.value = null
        error.value = ''
        await fetchHotels()
    } catch (e) {
        error.value = e.response.data.message
    }
}

async function deleteHotel(id) {
    if (!confirm('Are you sure?')) return
    await api.delete(`/hotels/${id}`)
    await fetchHotels()
}
</script>

<template>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Hotels</h1>

    <p v-if="error" class="text-red-500 mb-4">{{ error }}</p>

    <div class="bg-gray-50 rounded-xl p-4 mb-6">
      <h2 class="text-lg font-semibold mb-3">Add New Hotel</h2>
      <div class="grid grid-cols-2 gap-3">
        <select
          v-model="newHotel.city_id"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"
        >
          <option value="">Select city</option>
          <option v-for="city in cities" :key="city.id" :value="city.id">
            {{ city.name }}
          </option>
        </select>
        <input v-model="newHotel.name" placeholder="Hotel name"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
        <input v-model="newHotel.slug" placeholder="slug"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
        <input v-model="newHotel.address" placeholder="Address"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
        <input v-model="newHotel.capacity" placeholder="Capacity" type="number"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
        <input v-model="newHotel.phone" placeholder="Phone"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
        <input v-model="newHotel.rating" placeholder="Rating (0-5)" type="number" step="0.1"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
        <input v-model="newHotel.description" placeholder="Description"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
      </div>
      <button @click="createHotel"
        class="mt-3 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
        Add Hotel
      </button>
    </div>

    <div class="space-y-3">
      <div v-for="hotel in hotels" :key="hotel.id"
        class="bg-white border rounded-xl p-4 shadow-sm">

        <div v-if="!editingHotel || editingHotel.id !== hotel.id"
          class="flex items-center justify-between">
          <div>
            <p class="font-bold text-gray-800">{{ hotel.name }}</p>
            <p class="text-gray-500 text-sm">{{ hotel.city.name }} · {{ hotel.address }}</p>
            <p class="text-yellow-500 text-sm">⭐ {{ hotel.rating ?? 'No rating' }} · {{ hotel.rooms_count }} rooms</p>
          </div>
          <div class="flex gap-2">
            <button @click="startEdit(hotel)"
              class="bg-yellow-400 text-white px-4 py-1 rounded-lg hover:bg-yellow-500 transition text-sm">
              Edit
            </button>
            <button @click="deleteHotel(hotel.id)"
              class="bg-red-500 text-white px-4 py-1 rounded-lg hover:bg-red-600 transition text-sm">
              Delete
            </button>
          </div>
        </div>

        <div v-else>
          <div class="grid grid-cols-2 gap-3 mb-3">
            <select v-model="editingHotel.city_id"
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400">
              <option v-for="city in cities" :key="city.id" :value="city.id">
                {{ city.name }}
              </option>
            </select>
            <input v-model="editingHotel.name" placeholder="Hotel name"
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
            <input v-model="editingHotel.address" placeholder="Address"
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
            <input v-model="editingHotel.phone" placeholder="Phone"
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
            <input v-model="editingHotel.rating" placeholder="Rating" type="number" step="0.1"
              class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400"/>
          </div>
          <div class="flex gap-2">
            <button @click="updateHotel"
              class="bg-green-500 text-white px-4 py-1 rounded-lg hover:bg-green-600 transition text-sm">
              Save
            </button>
            <button @click="editingHotel = null"
              class="bg-gray-400 text-white px-4 py-1 rounded-lg hover:bg-gray-500 transition text-sm">
              Cancel
            </button>
          </div>
        </div>

      </div>
    </div>
  </div>
</template>
