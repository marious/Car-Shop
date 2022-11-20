<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/inertia-vue3';
import Icon from '$/Shared/Icon.vue';

const selectable_locale = computed(() => {
  if (usePage().props.value.locale === 'en') {
    return 'ar';
  }
  return 'en';
});
</script>
<template>
  <div class="ml-4">
    <Link :href="route('language', [selectable_locale])">
      <Icon class="w-5 h-5" :name="selectable_locale" />
      {{ __('My Profile') }}
    </Link>
  </div>
</template>
