<script setup>
import { ref } from 'vue';
import Toggle from '@vueform/toggle';
import JetInputError from '@/Jetstream/InputError.vue';
import '@vueform/toggle/themes/default.css';

const props = defineProps({
  modelValue: Boolean,
  row: {
    Object,
    default: {},
  },
  error: {
    String,
    default: null,
  },
  disabled: Boolean,
});

//const value = ref(props.modelValue);
</script>

<template>
  <div class="py-2 px-2">
    <label v-if="row.name" :for="row.name" class="text-sm font-normal"
      >{{ row.label ? row.label : row.name }}
      <span v-if="row.required" class="text-red-600 text-bold">*</span>
    </label>
    <br />
    <Toggle
      :name="row.name"
      :id="row.name"
      @change="$emit('update:modelValue', !modelValue)"
      :classes="{
        container:
          'inline-block rounded-full outline-none focus:ring focus:ring-' +
          row.color +
          '-500 focus:ring-opacity-30',
        toggle:
          'flex w-12 h-5 rounded-full relative cursor-pointer transition items-center box-content border-2 text-xs leading-none',
        toggleOn:
          'bg-' +
          row.color +
          '-500 border-' +
          row.color +
          '-500 justify-start text-white',
        toggleOff: 'bg-gray-200 border-gray-200 justify-end text-gray-700',
        toggleOnDisabled:
          'bg-gray-300 border-gray-300 justify-start text-gray-400 cursor-not-allowed',
        toggleOffDisabled:
          'bg-gray-200 border-gray-200 justify-end text-gray-400 cursor-not-allowed',
        handle:
          'inline-block bg-white w-5 h-5 top-0 rounded-full absolute transition-all',
        handleOn: 'left-full transform -translate-x-full',
        handleOff: 'left-0',
        handleOnDisabled: 'bg-gray-100 left-full transform -translate-x-full',
        handleOffDisabled: 'bg-gray-100 left-0',
        label: 'text-center w-8 border-box whitespace-nowrap select-none',
      }"
    />
    <small v-if="row.hint" class="text-gray-400 mx-2">{{ row.hint }}</small>
    <JetInputError :error="error" class="mt-2" />
  </div>
</template>
