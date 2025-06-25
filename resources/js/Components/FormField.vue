<template>
  <div>
    <label :for="label" class="block text-sm font-medium text-gray-700">
      {{ label }}
    </label>

    <div class="mt-1">
      <!-- Input -->
      <input
        v-if="type === 'text' || type === 'date'"
        :type="type"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :id="label"
        class="w-full border-gray-300 rounded shadow-sm"
      />

      <!-- Textarea -->
      <textarea
        v-else-if="type === 'textarea'"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :id="label"
        class="w-full border-gray-300 rounded shadow-sm"
      ></textarea>

      <!-- Select -->
      <select
        v-else-if="type === 'select'"
        :value="modelValue"
        @change="$emit('update:modelValue', $event.target.value)"
        :id="label"
        class="w-full border-gray-300 rounded shadow-sm"
      >
        <option value="">Pilih</option>
        <option
          v-for="option in options"
          :key="option.value"
          :value="option.value"
        >
          {{ option.label }}
        </option>
      </select>
    </div>

    <!-- Error Message -->
    <div v-if="errors" class="text-sm text-red-600 mt-1">
      {{ errors }}
    </div>
  </div>
</template>

<script setup>
defineProps({
  modelValue: [String, Number],
  label: String,
  errors: String,
  type: {
    type: String,
    default: 'text',
  },
  options: {
    type: Array,
    default: () => [],
  },
})

defineEmits(['update:modelValue'])
</script>
