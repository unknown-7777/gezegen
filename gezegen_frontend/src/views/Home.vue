<script setup>
import { ref, onMounted } from 'vue'
import Navbar from '../components/Navbar.vue'
import api from '../api/index.js'

const hotels = ref([])

onMounted(async () => {
    const response = await api.get('/hotels')
    hotels.value = response.data
})
</script>

<template>
  <div>
    <Navbar />

    <div class="relative bg-blue-600 text-white py-32 px-8 text-center">
      <h1 class="text-5xl font-bold mb-4">Explore the World</h1>
      <p class="text-xl text-blue-100 mb-10">
        Discover amazing destinations and create unforgettable memories
      </p>
      <div class="flex items-center bg-white rounded-full px-6 py-4 max-w-2xl mx-auto gap-4">
        <input
          type="text"
          placeholder="Where do you want to go?"
          class="flex-1 text-gray-700 outline-none text-lg"
        />
        <button class="bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">
          Search
        </button>
      </div>
    </div>

    <div class="py-16 px-8 max-w-7xl mx-auto">
      <h2 class="text-3xl font-bold text-gray-800 mb-2">Featured Hotels</h2>
      <p class="text-gray-500 mb-10">Handpicked places just for you</p>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        <div
          v-for="hotel in hotels"
          :key="hotel.id"
          class="rounded-2xl overflow-hidden shadow-md hover:shadow-xl transition cursor-pointer group"
        >
          <div class="overflow-hidden h-56 bg-blue-100 flex items-center justify-center">
            <span class="text-blue-400 text-4xl">🏨</span>
          </div>

          <div class="p-5 bg-white flex items-center justify-between">
            <div>
              <h3 class="text-lg font-bold text-gray-800">{{ hotel.name }}</h3>
              <p class="text-gray-500 text-sm">{{ hotel.city.name }}</p>
              <p class="text-gray-400 text-xs">{{ hotel.address }}</p>
            </div>
            <span class="text-blue-600 font-bold text-lg">⭐ {{ hotel.rating }}</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
