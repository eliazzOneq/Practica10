<script setup>
defineProps({
  label: {
    type: String,
    required: true
  },

  modelValue: {
    type: [String, Number],
    default: ''
  },

  error: {
    type: String,
    default: ''
  },

  type: {
    type: String,
    default: 'text'
  },

  placeholder: {
    type: String,
    default: ''
  }
})

const emit = defineEmits([
  'update:modelValue'
])

const actualizarValor = (event) => {
  emit('update:modelValue', event.target.value)
}
</script>

<template>
  <div class="campo">
    <label>{{ label }}</label>

    <input
      :type="type"
      :value="modelValue"
      :placeholder="placeholder"
      :class="{ error: error }"
      @input="actualizarValor"
    />

    <span
      v-if="error"
      class="error-msg"
    >
      {{ error }}
    </span>
  </div>
</template>

<style scoped>
.campo {
  display: flex;
  flex-direction: column;
  margin-bottom: 15px;
}

label {
  margin-bottom: 5px;
  font-weight: bold;
}

input {
  padding: 8px;
  border: 1px solid #ccc;
  border-radius: 4px;
}

input.error {
  border-color: red;
}

.error-msg {
  color: red;
  font-size: 0.85rem;
  margin-top: 4px;
}
</style>