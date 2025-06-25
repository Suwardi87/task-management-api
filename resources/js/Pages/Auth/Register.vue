<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3'
import InputLabel from '@/Components/InputLabel.vue'
import InputError from '@/Components/InputError.vue'
import TextInput from '@/Components/TextInput.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import Checkbox from '@/Components/Checkbox.vue'

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
  terms: false
})

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation')
  })
}
</script>

<template>
  <Head title="Register" />

  <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 space-y-6 border border-gray-200">
      <div class="text-center">
        <div class="text-5xl mb-2">📝</div>
        <h2 class="text-3xl font-bold text-gray-800">Create an Account</h2>
        <p class="text-gray-500 text-sm">Join us and start managing your tasks smarter</p>
      </div>

      <form @submit.prevent="submit" class="space-y-5">
        <div>
          <InputLabel for="name" value="Name" />
          <TextInput
            id="name"
            v-model="form.name"
            type="text"
            class="mt-1 block w-full"
            required
            autofocus
            autocomplete="name"
          />
          <InputError class="mt-1" :message="form.errors.name" />
        </div>

        <div>
          <InputLabel for="email" value="Email" />
          <TextInput
            id="email"
            v-model="form.email"
            type="email"
            class="mt-1 block w-full"
            required
            autocomplete="email"
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
            autocomplete="new-password"
          />
          <InputError class="mt-1" :message="form.errors.password" />
        </div>

        <div>
          <InputLabel for="password_confirmation" value="Confirm Password" />
          <TextInput
            id="password_confirmation"
            v-model="form.password_confirmation"
            type="password"
            class="mt-1 block w-full"
            required
            autocomplete="new-password"
          />
          <InputError class="mt-1" :message="form.errors.password_confirmation" />
        </div>

        <div v-if="$page.props.jetstream?.hasTermsAndPrivacyPolicyFeature" class="text-sm text-gray-600">
          <label class="flex items-start gap-2 mt-3">
            <Checkbox v-model:checked="form.terms" name="terms" />
            <span>
              I agree to the
              <a target="_blank" :href="route('terms.show')" class="text-blue-600 hover:underline">Terms of Service</a>
              and
              <a target="_blank" :href="route('policy.show')" class="text-blue-600 hover:underline">Privacy Policy</a>.
            </span>
          </label>
          <InputError class="mt-1" :message="form.errors.terms" />
        </div>

        <div class="flex items-center justify-between">
          <Link
            :href="route('login')"
            class="text-sm text-gray-600 hover:underline hover:text-blue-600"
          >
            Already have an account?
          </Link>

          <PrimaryButton
            class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded shadow transition"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing"
          >
            🚀 Register
          </PrimaryButton>
        </div>
      </form>
    </div>
  </div>
</template>
