<template>
  <AppLayout :title="task.title">
    <template #header>
      <div class="flex items-center gap-2 text-gray-800">
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
          viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round"
            d="M15 12H9m-2 0a8 8 0 1016 0 8 8 0 10-16 0zm8-6v6" />
        </svg>
        <h2 class="text-xl font-semibold">Edit Task</h2>
      </div>
    </template>

    <div class="flex items-center justify-center min-h-screen bg-gray-100">
      <form
        @submit.prevent="updateTask"
        class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl space-y-6 border border-gray-200"
      >
        <div>
          <h3 class="text-2xl font-bold text-gray-700 mb-2">Task Details</h3>
          <p class="text-sm text-gray-500">Perbarui detail tugas di bawah ini.</p>
        </div>

        <FormField
          v-model="form.title"
          label="📝 Judul"
          :errors="form.errors.title"
        />

        <FormField
          v-model="form.description"
          label="🧾 Deskripsi"
          type="textarea"
          :errors="form.errors.description"
        />

        <FormField
          v-model="form.due_date"
          label="📅 Jatuh Tempo"
          type="date"
          :errors="form.errors.due_date"
        />

        <FormField
          v-model="form.assigned_to"
          label="👤 Ditugaskan ke"
          type="select"
          :options="userOptions"
          :errors="form.errors.assigned_to"
        />

        <FormField
          v-model="form.status"
          label="📌 Status"
          type="select"
          :options="statusOptions"
          :errors="form.errors.status"
        />

        <div class="pt-4">
          <PrimaryButton
            :disabled="form.processing"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg shadow transition-all"
          >
            💾 Update Task
          </PrimaryButton>
        </div>
      </form>
    </div>
  </AppLayout>
</template>

<script setup>
import { useForm } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import FormField from "@/Components/FormField.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { defineProps, computed } from "vue";

const props = defineProps({
  task: { type: Object, default: () => ({}) },
  users: { type: Array, default: () => [] },
});

const userOptions = computed(() =>
  props.users.map((user) => ({
    value: String(user.id),
    label: user.name,
  }))
);

const statusOptions = [
  { value: "pending", label: "Pending" },
  { value: "in_progress", label: "In Progress" },
  { value: "done", label: "Done" },
];

const form = useForm({
  title: props.task?.title ?? "",
  description: props.task?.description ?? "",
  due_date: props.task?.due_date ?? "",
  assigned_to: props.task?.assigned_to
    ? String(
        typeof props.task.assigned_to === "object"
          ? props.task.assigned_to.id
          : props.task.assigned_to
      )
    : "",
  status: props.task?.status ?? "pending",
});

function updateTask() {
  form.put(route("tasks.update", props.task?.id), {
    onSuccess: () => alert("Task updated successfully!"),
  });
}
</script>

