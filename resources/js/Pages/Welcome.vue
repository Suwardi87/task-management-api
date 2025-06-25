<template>
  <Head title="Welcome" />
  <div class="flex items-center justify-center min-h-screen bg-gradient-to-tr from-blue-50 via-white to-purple-100">
    <div class="bg-white p-10 rounded-3xl shadow-2xl w-full max-w-2xl border border-gray-200 space-y-6">
      <div class="text-center">
        <div class="flex justify-center mb-4">
          <span class="text-5xl">🚀</span>
        </div>
        <h1 class="text-4xl font-bold text-gray-800">Welcome to Task Manager</h1>
        <p class="text-gray-500 mt-2 text-lg">
          Manage your tasks efficiently with Laravel + Vue 3 + Inertia
        </p>
      </div>

      <div class="flex flex-col sm:flex-row justify-center gap-4 mt-8">
        <Link
          v-if="canLogin && !$page.props.auth.user"
          :href="route('login')"
          class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-xl shadow-md text-center transition-all"
        >
          🔐 Login
        </Link>
        <Link
          v-if="canRegister && !$page.props.auth.user"
          :href="route('register')"
          class="flex-1 bg-white hover:bg-gray-100 text-blue-600 border border-blue-600 font-bold py-3 px-6 rounded-xl shadow-md text-center transition-all"
        >
          ✍️ Register
        </Link>
        <Link
          v-if="$page.props.auth.user"
          :href="route('dashboard')"
          class="flex-1 bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded-xl shadow-md text-center transition-all"
        >
          📋 Dashboard
        </Link>
      </div>

      <div class="mt-10">
        <h3 class="text-xl font-semibold text-gray-700 mb-3">✨ Fitur Utama</h3>
        <ul class="space-y-2 text-gray-600 text-sm sm:text-base list-disc list-inside">
          <li>🔒 Autentikasi Aman (Login & Register)</li>
          <li>🛠️ CRUD Task interaktif</li>
          <li>👥 Assign task ke user</li>
          <li>✅ Validasi Form & Notifikasi</li>
          <li>📱 Desain modern & responsif</li>
        </ul>
      </div>

      <footer class="pt-8 text-center text-sm text-gray-400">
        Laravel v{{ laravelVersion }} • PHP v{{ phpVersion }}
      </footer>
    </div>
  </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3'

defineProps({
  canLogin: Boolean,
  canRegister: Boolean,
  laravelVersion: { type: String, required: true },
  phpVersion: { type: String, required: true },
})
</script>
