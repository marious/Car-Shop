<script setup>
import { Inertia } from '@inertiajs/inertia';
import { ref } from 'vue';

defineProps({
  collection: Object,
});

let perPage = ref(10);

function changePerPage(count) {
  Inertia.get(route('posts.index'), `per_page=10`, {
    preserveState: true,
    replace: true,
  });
}
</script>
<template>
  <nav class="flex items-center justify-between">
    <div
      class="flex items-center justify-center flex-col md:flex-row md:items-center md:justify-between flex-1 mb-0 md:mb-4"
    >
      <div class="flex items-center">
        <div
          class="text-sm font-normal dark:text-white mt-1 mt-[10px] mb-[20px] md:mt-0 md:mb-0"
        >
          Show {{collection.from}} To {{collection.to}} Of {{ collection.total }} Results
        </div>
      </div>
      <div class="flex flex-col items-center md:flex-row">
        <div
          class="flex items-start space-x-2 rtl:space-x-reverse filament-tables-pagination-records-per-page-selector mb-[20px] md:mb-0"
        >
          <div class="flex items-center">
            <div v-if="collection.links.length > 3">
              <div class="flex flex-wrap -mb-1">
                <template v-for="(link, key) in collection.links">
                  <div
                    v-if="link.url === null"
                    :key="key"
                    class="mb-1 px-4 py-3 text-gray-400 text-sm leading-4 border rounded"
                    v-html="link.label ? link.label : '&laquo; Previous'"
                  >
                  </div>
                  <Link
                    v-else
                    :key="`link-${key}`"
                    class="mb-1 px-4 py-3 focus:text-indigo-500 text-sm leading-4 hover:bg-white border focus:border-indigo-500 rounded"
                    :class="{ 'bg-main text-white': link.active }"
                    :href="link.url"
                    v-html="link.label ? link.label : '&laquo; Previous'"
                  />
                </template>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>
</template>
