<template>
    <nav class="flex items-center justify-between px-8 py-4 bg-white shadow-sm sticky top-0 z-50">

        <RouterLink to="/" class="text-2xl font-bold text-blue-600">
            Gezegen
        </RouterLink>

        <div class="flex items-center gap-8">
            <RouterLink to="/" class="text-gray-600 hover:text-blue-600 transition">
                Home
            </RouterLink>
            <RouterLink to="/destinations" class="text-gray-600 hover:text-blue-600 transition">
                Destinations
            </RouterLink>
            <RouterLink to="/bookings" class="text-gray-600 hover:text-blue-600 transition">
                My Trips
            </RouterLink>
        </div>

        <div class="flex items-center gap-3">
              <RouterLink to="/login" class="text-gray-600 hover:text-blue-600 transition">
                Login
              </RouterLink>
              <RouterLink to="/register" class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">
                Sign Up
              </RouterLink>
        </div>

    </nav>
</template>
