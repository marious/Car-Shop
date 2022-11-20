<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";

defineProps({
    modelValue: String,
    isModal: Boolean,
});

const emit = defineEmits(["update:modelValue"]);

let page = usePage().props.value.data;

let createModal = ref(false);

function fireSearch(e) {
    emit("update:modelValue", e.target.value);
}

function showCreateModal() {
    createModal.value = true;
}
</script>
<template>
    <div
        class="flex flex-col justify-start md:flex-row md:justify-between w-full mb-6"
        cancreate="true"
    >
        <div>
            <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
               Translation {{ route().params.lang == 'ar' ? ' To English' : ' To Arabic'}}
            </h2>
            <ol class="flex mt-2 text-gray-500 dark:text-white">
                <li class="mr-2">
                    <Link
                        class="flex items-center hover:text-main dark:hover:text-dark_green_color"
                        :href="page.appUrl + '/admin'"
                        ><i class="mr-1 bx bx-home rtl:mr-0 rtl:ml-1"></i
                        ><span>Home</span></Link
                    >
                </li>
                <li class="mr-2"><span>/</span></li>
                <li class="mr-2">
                    <a href="#" class="text-main dark:text-dark_green_color">
                        Translation {{ route().params.lang == 'ar' ? ' To English' : ' To Arabic'}}</a
                    >
                </li>
            </ol>
        </div>
        <div class="flex items-start justify-end md:justify-start md:items-end">
            <div
                class="relative inline-flex items-center px-8 py-3 overflow-hidden text-white bg-main rounded group active:bg-blue-500 focus:outline-none focus:ring"
            >
                <span
                    class="absolute left-0 transition-transform -translate-x-full group-hover:translate-x-4"
                    ><i class="bx bx-sm mt-2 bx-plus"></i></span
                ><Link
                    :href="route('translation.index', route().params.lang == 'ar' ? 'en' : 'ar')"
                    class="text-sm font-medium transition-all group-hover:ml-4 w-full"
                    >Translation {{ route().params.lang == 'ar' ? ' To English' : ' To Arabic'}}</Link
                >
            </div>
        </div>
    </div>
    <div>
        <div class="flex justify-between p-4">
        </div>

    </div>
</template>
