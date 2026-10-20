<script setup>
import { ref, reactive, onMounted } from 'vue'
import api from '../api/index.js'

const rooms = ref([])
const hotels = ref([])
const error = ref('')
const loading = ref(false)

const filters = reactive({
  hotel_id: '',
  price_start: '',
  price_end: '',
  is_available: '',
  room_type: ''
})

onMounted(async () => {
  await fetchRooms()
  await fetchHotels()
})

async function fetchRooms() {
  loading.value = true
  try {
    const params = new URLSearchParams()
    Object.keys(filters).forEach(key => {
      if (filters[key] !== '' && filters[key] !== null) {
        params.append(key, filters[key])
      }
    })

    const response = await api.get(`/rooms?${params.toString()}`)
    rooms.value = response.data.data
    error.value = ''
  } catch (e) {
    error.value = e.response?.data?.message || 'Failed to fetch rooms'
  } finally {
    loading.value = false
  }
}

async function fetchHotels() {
  try {
    const response = await api.get('/hotels')
    hotels.value = response.data.data
  } catch (e) {
    console.error('Failed to fetch hotels', e)
  }
}
</script>

<template>
  <div class="max-w-4xl mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Rooms Management</h1>

    <p v-if="error" class="text-red-500 mb-4">{{ error }}</p>


    <div class="bg-gray-50 rounded-xl p-4 mb-6 border">
      <h2 class="text-lg font-semibold mb-3">Filter Rooms</h2>
      <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
        <select v-model="filters.hotel_id" @change="fetchRooms"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400 bg-white">
          <option value="">All Hotels</option>
          <option v-for="hotel in hotels" :key="hotel.id" :value="hotel.id">{{ hotel.name }}</option>
        </select>

        <select v-model="filters.room_type" @change="fetchRooms"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400 bg-white">
          <option value="">All Types</option>
          <option value="Standard">Standard</option>
          <option value="Deluxe">Deluxe</option>
          <option value="Suite">Suite</option>
        </select>

        <select v-model="filters.is_available" @change="fetchRooms"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400 bg-white">
          <option value="">Any Status</option>
          <option value="true">Available</option>
          <option value="false">Booked</option>
        </select>

        <input v-model="filters.price_start" @input="fetchRooms" placeholder="Min Price" type="number"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400 bg-white"/>

        <input v-model="filters.price_end" @input="fetchRooms" placeholder="Max Price" type="number"
          class="border rounded-lg px-3 py-2 outline-none focus:ring-2 focus:ring-blue-400 bg-white"/>
      </div>
    </div>


    <div v-if="loading" class="text-center py-8 text-gray-500">
      Loading rooms...
    </div>


    <div v-else class="space-y-3">
      <div v-for="room in rooms" :key="room.id"
        class="bg-white border rounded-xl p-4 shadow-sm flex items-center justify-between">

        <div>
          <div class="flex items-center gap-2">
            <p class="font-bold text-gray-800">Room #{{ room.room_number }}</p>
            <span class="text-xs px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 font-medium">{{ room.room_type }}</span>
          </div>
          <p class="text-gray-500 text-sm mt-0.5">Hotel: {{ room.hotel.name }} · Capacity: {{ room.capacity }} guests</p>
          <p class="text-gray-600 text-sm font-semibold mt-1">${{ room.price_per_night }} / night</p>
          <p v-if="room.description" class="text-gray-400 text-xs mt-1">{{ room.description }}</p>
        </div>

        <div>
          <span :class="room.is_available ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'"
            class="text-xs px-2.5 py-1 rounded-full font-medium">
            {{ room.is_available ? 'Available' : 'Booked' }}
          </span>
        </div>

      </div>

      <div v-if="rooms.length === 0" class="text-center py-8 text-gray-400">
        No rooms found matching your filters.
      </div>
    </div>
  </div>
</template>
