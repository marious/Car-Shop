<script setup>
import { computed } from "vue";
import { usePage } from '@inertiajs/inertia-vue3'

const props = defineProps({
  username: {
    type: String,
    required: true,
  },
  avatar: {
    type: String,
    default: null,
  },
  api: {
    type: String,
    default: "avataaars",
  },
});

const username = computed(() => props.username);

const avatar = computed(
  () => {
      return props.avatar ??
      `https://avatars.dicebear.com/api/${props.api}/${props.username}.svg`
  }

);

let profileUrl = route('user.profile', usePage().props.value.user.id);
</script>

<template>
  <div>
      <Link :href="profileUrl">
          <img
              :src="avatar"
              :alt="username"
              class="rounded-full block h-auto w-full max-w-full bg-gray-100 dark:bg-slate-800"
          />
      </Link>

  </div>
</template>
