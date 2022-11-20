<script setup>
import { onMounted, ref } from 'vue';
import JetInputError from '@/Jetstream/InputError.vue';
let props = defineProps({
  modelValue: {},
  row: {
    Object,
    default: {},
  },
  view: {
    String,
    default: 'input',
  },
  error: {
    String,
    default: null,
  },
});

let value = ref('');
onMounted(() => {
  if (props.modelValue) {
    value.value = props.modelValue;
  }
  if (props.row.default && !props.modelValue) {
    value.value = props.row.default;
  }
});
</script>

<template>
  <div class="py-2 px-2" v-if="view === 'input'">
    <label
      v-if="row.name"
      :for="row.name"
      class="text-sm font-normal capitalize"
      >{{ row.label ? row.label : row.name }}
      <span v-if="row.required" class="text-red-600 text-bold">*</span>
    </label>
    <input
      :type="row.type ? row.type : 'text'"
      :name="row.name"
      :id="row.name"
      :disabled="row.disabled"
      :value="modelValue"
      v-model="value"
      :placeholder="row.placeholder"
      @input="$emit('update:modelValue', value)"
      class="w-full mt-2 h-10 p-4 pr-12 text-sm border-gray-200 rounded-lg shadow-sm"
      :class="{ 'border border-red-600': error }"
    />
    <small v-if="row.hint" class="text-gray-400 mx-2">{{ row.hint }}</small>
    <JetInputError v-if="error" :message="error" class="mt-2" />
  </div>
  <div class="flex justify-between my-4" v-if="view === 'view'">
    <div>
      <p class="font-bold">{{ row.label ? row.label : row.name }}</p>
    </div>
    <div>
      <p>{{ value }}</p>
    </div>
  </div>
  <div v-if="view === 'table'">
    <p>{{ value }}</p>
  </div>
</template>
