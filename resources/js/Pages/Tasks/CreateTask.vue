<template>
    <AppLayout title="Create Task">
        <form @submit.prevent="createTask" class="space-y-4">
            <FormField
                v-model="form.title"
                label="Title"
                :errors="form.errors.title"
                required
            />

            <FormField
                v-model="form.description"
                label="Description"
                type="textarea"
                :errors="form.errors.description"
            />

            <FormField
                v-model="form.status"
                label="Status"
                type="select"
                :options="[
                    { value: 'pending', label: 'Pending' },
                    { value: 'in_progress', label: 'In Progress' },
                    { value: 'done', label: 'Done' }
                ]"
                :errors="form.errors.status"
                required
            />

            <FormField
                v-model="form.due_date"
                label="Due Date"
                type="date"
                :errors="form.errors.due_date"
                required
            />

            <FormField
                v-model="form.assigned_to"
                label="Assigned To"
                type="text"
                :errors="form.errors.assigned_to"
            />

            <div class="pt-4">
                <PrimaryButton :disabled="form.processing">Create Task</PrimaryButton>
            </div>
        </form>
    </AppLayout>
</template>

<script setup>
import { ref } from 'vue';
import { useForm } from '@inertiajs/inertia-vue3';
import AppLayout from '@/Layouts/AppLayout.vue';
import FormField from '@/Components/FormField.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';

const form = useForm({
    title: '',
    description: '',
    status: 'pending',
    due_date: '',
    assigned_to: null,
});

function createTask() {
    form.post('/tasks');
}
</script>

