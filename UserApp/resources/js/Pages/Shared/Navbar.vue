<script setup>
import { Link, usePage } from '@inertiajs/vue3'
import { ref, computed } from 'vue';

const userDropDown = ref(false);

// ✅ Create a computed for user
const authUser = computed(() => usePage().props.auth.user);
</script>

<template>
  <!-- Navbar -->
  <nav class="bg-white shadow-md">
    <div class="container mx-auto px-4 flex justify-between items-center py-4">
      <div class="flex items-center space-x-4">
        <div class="flex items-center space-x-1">
          <img src="@/assets/logo.png" alt="Logo" class="h-8" />
          <span class="text-md font-semibold">PandaStore</span>
        </div>

        <Link href="/" class="text-gray-700 hover:text-blue-500">Home</Link>
        <Link href="/carts" class="text-gray-700 hover:text-blue-500">Cart</Link>
        <Link href="/wishlists" class="text-gray-700 hover:text-blue-500">Wishlist</Link>
      </div>

      <div class="relative">
        <!-- ✅ Now use authUser -->
        <div v-if="!authUser" class="flex items-center space-x-4">
          <Link href="/login" class="text-gray-700 hover:text-blue-500">Login</Link>
          <Link href="/register" class="text-gray-700 hover:text-blue-500">Register</Link>
        </div>

        <div v-else>
          <button @click="userDropDown = !userDropDown" id="user-dropdown-btn" class="flex items-center space-x-2">
            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed=User&backgroundColor=b6b6b6&mouth=serious" alt="User Avatar" class="h-8 w-8 rounded-full border border-gray-300 shadow-sm" />
            <span class="text-gray-700 font-medium">{{ authUser.profile?.cus_name ?? 'User' }}</span>
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>
          <div id="user-dropdown" :class="{ 'hidden': !userDropDown }"
            class="z-10 absolute right-0 mt-2 w-48 bg-white shadow-lg rounded-lg">
            <ul class="py-2">
              <li>
                <Link href="/dashboards" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Dashboard</Link>
              </li>
              <li>
                <Link href="/logout" class="block px-4 py-2 text-red-500 hover:bg-gray-100">Logout</Link>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>

<style></style>
