<script setup>
import { ref } from "vue";
import { usePage } from "@inertiajs/inertia-vue3";
// import CreateModal from './../Components/Modals/CreateModal.vue';
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
                {{__('Company Fees')}}
            </h2>
            <ol class="flex mt-2 text-gray-500 dark:text-white">
                <li class="mr-2">
                    <Link
                        class="flex items-center hover:text-main dark:hover:text-dark_green_color"
                        :href="page.appUrl + '/admin'"
                        ><i class="mr-1 bx bx-home rtl:mr-0 rtl:ml-1"></i
                        ><span>{{__('Home')}}</span></Link
                    >
                </li>
                <li class="mr-2"><span>/</span></li>
                <li class="mr-2">
                    <a href="#" class="text-main dark:text-dark_green_color">
                        {{__('Fees')}}</a
                    >
                </li>
            </ol>
        </div>
        <div class="flex items-start justify-end md:justify-start md:items-end">
            <Component
                :is="isModal ? 'button' : 'Link'"
                :href="route('company-fees.create')"
                class="relative inline-flex items-center px-8 py-3 overflow-hidden text-white bg-main rounded group active:bg-blue-500 focus:outline-none focus:ring"
                @click="isModal ? showCreateModal() : ''"
            >
                <span
                    class="absolute left-0 transition-transform -translate-x-full group-hover:translate-x-4"
                    ><i class="bx bx-sm mt-2 bx-plus"></i></span
                ><span
                    class="text-sm font-medium transition-all group-hover:ml-4"
                    >{{__('Create Company Fee')}}</span
                >
            </Component>
        </div>
    </div>
    <div>
        <div class="flex justify-between p-4">
            <div><!--v-if--></div>
            <div class="flex items-center justify-end w-full gap-2 md:max-w-sm">
                <div class="flex-1">
                    <div class="filament-tables-search-input">
                        <label for="tableSearchQueryInput" class="sr-only"
                            >{{__('Search')}}</label
                        >
                        <div class="relative group">
                            <span
                                class="absolute inset-y-0 left-0 flex items-center justify-center text-gray-400 pointer-events-none w-9 h-9 group-focus-within:text-primary-500"
                                ><svg
                                    class="w-5 h-5"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    aria-hidden="true"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"
                                    ></path></svg></span
                            ><input
                                @input="fireSearch"
                                :value="modelValue"
                                id="tableSearchQueryInput"
                                :placeholder="__('Search')"
                                type="search"
                                autocomplete="off"
                                class="block w-full placeholder-gray-400 transition duration-75 border-gray-300 rounded-lg shadow-sm dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800 h-9 pl-9 focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600"
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--        <CreateModal :show-modal="createModal" @closeModal="createModal = false" />-->
    </div>
</template>
