<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Checkbox from '@/Components/Checkbox.vue'

defineProps({
  canResetPassword: Boolean,
  status: String
})

const form = useForm({
  email: '',
  password: '',
  remember: false
})

const submit = () => {
  form
    .transform(data => ({
      ...data,
      remember: form.remember ? 'on' : ''
    }))
    .post(route('login'), {
      onFinish: () => form.reset('password')
    })
}
</script>

<template>
  <Head title="Login" />

  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-50 to-purple-100 px-4">
    <div class="bg-white rounded-2xl shadow-lg w-full max-w-md p-8 space-y-6 border border-gray-100">
      <div class="text-center">
        <div class="text-5xl mb-2">🔐</div>
        <h1 class="text-3xl font-bold text-gray-800">Welcome Back</h1>
        <p class="text-gray-500 text-sm">Please login to continue managing your tasks</p>
      </div>

      <div v-if="status" class="bg-green-100 text-green-700 px-4 py-2 rounded text-sm">
        {{ status }}
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            class="mt-1 block w-full"
            required
            autofocus
            autocomplete="username"
          />
          <InputError class="mt-1" :message="form.errors.email" />
        </div>

        <div>
          <InputLabel for="password" value="Password" />
          <TextInput
            id="password"
            v-model="form.password"
            type="password"
            class="mt-1 block w-full"
            required
            autocomplete="current-password"
          />
          <InputError class="mt-1" :message="form.errors.password" />
        </div>

        <div class="flex items-center justify-between">
          <label class="flex items-center space-x-2 text-sm text-gray-600">
            <Checkbox v-model:checked="form.remember" name="remember" />
            <span>Remember me</span>
          </label>
          <Link
            v-if="canResetPassword"
            :href="route('password.request')"
            class="text-sm text-blue-600 hover:underline"
          >
            Forgot password?
          </Link>
        </div>

        <PrimaryButton
          class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded shadow transition"
          :class="{ 'opacity-25': form.processing }"
          :disabled="form.processing"
        >
          👉 Log in
        </PrimaryButton>
      </form>
    </div>
  </div>
</template>
