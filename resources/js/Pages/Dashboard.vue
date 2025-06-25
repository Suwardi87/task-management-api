<template>
  <AppLayout title="Dashboard">
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Dashboard
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
          <div class="p-6 bg-gradient-to-r from-blue-500 to-purple-600 text-white border-b border-gray-300 rounded-t-lg">
            <div class="grid grid-cols-1 gap-6 md:grid-cols-4">
              <div v-for="(val, key) in stats" :key="key" class="p-4 bg-white text-center rounded-lg shadow-md">
                <p class="text-sm font-medium text-gray-700 uppercase">
                  {{ key.replace('_', ' ') }}
                </p>
                <p class="text-3xl font-bold">{{ val }}</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { ref, onMounted } from 'vue'
import axios from 'axios'

const stats = ref({})

onMounted(async () => {
  const response = await axios.get('/api/tasks/stats')
  stats.value = response.data
})
</script>

