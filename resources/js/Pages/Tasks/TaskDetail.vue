<template>
    <AppLayout :title="task.title">
        <div class="mx-auto max-w-2xl my-10">
            <div class="bg-white rounded-lg shadow p-8 space-y-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">{{ task.title }}</h2>
                <div class="space-y-2">
                    <div>
                        <span class="font-semibold text-gray-700">Deskripsi:</span>
                        <span class="text-gray-700">{{ task.description || '-' }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Status:</span>
                        <span class="capitalize text-gray-700">{{ task.status }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Jatuh Tempo:</span>
                        <span class="text-gray-700">{{ task.due_date }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-gray-700">Ditugaskan ke:</span>
                        <span class="text-gray-700">{{ task.assigned_to?.name || '-' }}</span>
                    </div>
                </div>
            </div>

            <div class="pt-6 flex gap-4 justify-end">
                <Link
                    v-if="task && task.id"
                    :href="route('tasks.edit', task.id)"
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 font-semibold transition"
                >
                    Edit Task
                </Link>
                <button
                    @click="deleteTask"
                    class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 font-semibold transition"
                >
                    Delete Task
                </button>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue'
import { Link, router } from '@inertiajs/vue3'
import { defineProps } from 'vue'

const props = defineProps({
    task: Object
})

function deleteTask() {
    if (confirm('Are you sure you want to delete this task?')) {
        router.delete(route('tasks.destroy', props.task.id), {
            onSuccess: () => {
                router.visit(route('tasks.index'))
            },
            onError: () => {
                alert('Failed to delete task.')
            }
        })
    }
}
</script>
