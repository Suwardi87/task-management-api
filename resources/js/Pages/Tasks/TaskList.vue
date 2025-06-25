<template>
  <AppLayout title="Task List">
    <template #header>
      <h1 class="text-xl font-bold">Daftar Tugas</h1>
    </template>

    <div class="space-y-6 m-20">

      <!-- Filter -->
      <div class="flex justify-end rounded-lg bg-gray-100 p-4 mb-4">
            <select v-model="filterStatus" class="form-select w-full sm:w-1/3">
          <option value="">Semua Status</option>
          <option value="pending">Pending</option>
          <option value="in_progress">In Progress</option>
          <option value="done">Done</option>
        </select>
      </div>

      <!-- Tombol Create -->
      <div class="flex justify-end mb-4">
        <Link :href="route('tasks.create')" class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
          Create
        </Link>
      </div>

      <!-- Tabel -->
      <div class="overflow-x-auto">
        <table class="w-full bg-white rounded shadow text-sm">
          <thead class="bg-gray-200 text-gray-700">
            <tr class="uppercase">
              <th class="px-4 py-2 text-left">Judul</th>
              <th class="px-4 py-2 text-left">Jatuh Tempo</th>
              <th class="px-4 py-2 text-left">Status</th>
              <th class="px-4 py-2 text-left">Ditugaskan ke</th>
              <th class="px-4 py-2 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="task in filteredTasks"
              :key="task.id"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2 font-medium">{{ task.title }}</td>
              <td class="px-4 py-2">{{ task.due_date }}</td>
              <td class="px-4 py-2">
                <span :class="statusColor(task.status)">
                  {{ task.status.replace('_', ' ') }}
                </span>
              </td>
              <td class="px-4 py-2">{{ task.assigned_to?.name || '-' }}</td>
              <td class="px-4 py-2 space-x-2">
                <Link :href="route('tasks.show', task.id)" class="text-green-600 hover:underline">Detail</Link>
                <Link :href="route('tasks.edit', task.id)" class="text-blue-600 hover:underline">Edit</Link>
              </td>
            </tr>
            <tr v-if="filteredTasks.length === 0">
              <td colspan="5" class="text-center py-6 text-gray-400 italic">Tidak ada tugas ditemukan.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Navigasi Pagination -->
      <div class="flex justify-center gap-2">
        <Link
          v-for="(link, i) in paginationLinks"
          :key="i"
          v-if="link"
          :href="link.url || '#'"
          v-html="link.label"
          @click.prevent="link.url ? Inertia.visit(link.url) : null"
          class="px-3 py-1 border rounded text-sm"
          :class="{
            'bg-blue-600 text-white': link.active,
            'text-gray-600': !link.url || link.url === '#',
            'cursor-not-allowed': !link.url || link.url === '#'
          }"
        />
      </div>

    </div>
  </AppLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import { usePage, Link } from '@inertiajs/vue3'
import AppLayout from '@/Layouts/AppLayout.vue'

const props = usePage().props
const rawTasks = props.tasks?.data ?? []
const paginationLinks = props.tasks?.links ?? []

const filterStatus = ref('')
const filteredTasks = computed(() => {
  return filterStatus.value
    ? rawTasks.filter(task => task.status === filterStatus.value)
    : rawTasks
})

function statusColor(status) {
  switch (status) {
    case 'pending': return 'text-yellow-600 font-medium'
    case 'in_progress': return 'text-blue-600 font-medium'
    case 'done': return 'text-green-600 font-medium'
    default: return 'text-gray-600'
  }
}
</script>
