<template>
  <LayoutsAppLayout :title="'Create Task'">
    <template #header>
      <div class="flex items-center gap-2 text-gray-800">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M9 12h6m2 0a8 8 0 11-16 0 8 8 0 0116 0zM12 6v6" />
        </svg>
        <h2 class="text-xl font-semibold">Create New Task</h2>
      </div>
    </template>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <form @submit.prevent="submitForm"
        class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl space-y-6 border border-gray-200">
        <div>
          <h3 class="text-2xl font-bold text-gray-700 mb-2">Task Details</h3>
          <p class="text-sm text-gray-500">Isi form di bawah untuk membuat tugas baru.</p>
        </div>

        <FormField v-model="form.title" label="📝 Title" :errors="form.errors.title" />

        <FormField v-model="form.description" label="🧾 Description" type="textarea"
          :errors="form.errors.description" />

        <FormField v-model="form.due_date" label="📅 Due Date" type="date"
          :errors="form.errors.due_date" />

        <FormField v-model="form.assigned_to" label="👤 Assign To" type="select"
          :options="users.map(user => ({ value: String(user.id), label: user.name }))"
          :errors="form.errors.assigned_to" />

        <FormField v-model="form.status" label="📌 Status" type="select" :options="[
            { value: 'pending', label: 'Pending' },
            { value: 'in_progress', label: 'In Progress' },
            { value: 'done', label: 'Done' }
          ]" :errors="form.errors.status" />

        <div class="pt-4">
          <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow transition-all">
            ✅ Create Task
          </button>
        </div>
      </form>
    </div>
  </LayoutsAppLayout>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/vue3'
import { computed } from 'vue'
import LayoutsAppLayout from '@/Layouts/AppLayout.vue'
import FormField from '@/Components/FormField.vue'

const users = computed(() => usePage().props.users ?? [])

const form = useForm({
  title: '',
  description: '',
  due_date: '',
  assigned_to: '',
  status: 'pending'
})

function submitForm() {
  form.post(route('tasks.store'))
}
</script>
