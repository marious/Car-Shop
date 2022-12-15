<script setup>
import {usePage} from "@inertiajs/inertia-vue3";

const props = defineProps({
    'accidents': Array
});
let page = usePage().props.value.data;
console.log(route().params);
</script>
<template>
    <div class="px-6 pt-6 mx-auto">
        <div
            class="flex flex-col justify-start md:flex-row md:justify-between w-full mb-6"
            cancreate="true"
        >
            <div>
                <h2 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">
                    {{ __("Accident List") }}
                </h2>
                <ol class="flex mt-2 text-gray-500 dark:text-white">
                    <li class="mr-2">
                        <Link
                            class="flex items-center hover:text-main dark:hover:text-dark_green_color"
                            :href="page.appUrl + '/admin'"
                        ><i class="mr-1 bx bx-home rtl:mr-0 rtl:ml-1"></i
                        ><span>{{ __('Home') }}</span></Link
                        >
                    </li>
                    <li class="mr-2">
                        <Link
                            class="flex items-center hover:text-main dark:hover:text-dark_green_color"
                            :href="route('quotations.approved')"
                        ><span>/ {{ __('Approved Quotations') }}</span></Link
                        >
                    </li>
                    <li class="mr-2"><span>/</span></li>
                    <li class="mr-2">
                        <a href="#" class="text-main dark:text-dark_green_color">
                            {{ __("Accident List") }}</a
                        >
                    </li>
                </ol>
            </div>
            <div class="flex items-start justify-end md:justify-start md:items-end">
                <Link :href="route('accident.make', route().params.quotationId)"
                      class="relative inline-flex items-center px-8 py-3 overflow-hidden text-white bg-main rounded group active:bg-blue-500 focus:outline-none focus:ring"

                >
                     <span
                         class="absolute left-0 transition-transform -translate-x-full group-hover:translate-x-4"
                     ><i class="bx bx-sm mt-2 bx-plus"></i></span
                     ><span
                    class="text-sm font-medium transition-all group-hover:ml-4"
                >{{ __("Add Accident") }}</span
                >
                </Link>
            </div>
        </div>
    </div>
    <div class="px-6 pt-6 mx-auto">
        <div
            class="bg-white dark:bg-gray-800 dark:border-gray-600 rounded-lg border"
        >
            <div class="relative overflow-y-auto dark:border-gray-800">
                <div>
                    <table
                        class="w-full text-left divide-y table-auto xl:rtl:text-right filament-tables-table"
                    >
                        <thead class="bg-gray-100 border-t border-b">
                        <tr
                            class="bg-tableHead text-main dark:bg-gray-800 dark:text-white"
                        >
                            <th class="filament-tables-header-cell">#</th>
                            <th class="filament-tables-header-cell rtl:text-center">
                                {{ __('Customer Name') }}
                            </th>
                            <th class="filament-tables-header-cell rtl:text-center">
                                {{ __('Document Number') }}
                            </th>
                            <th class="filament-tables-header-cell rtl:text-center">
                                {{ __('Accident Date') }}
                            </th>
                            <th class="w-5 rtl:text-center">{{ __('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(accident, i) in accidents" :key="accident.id">
                            <td>{{ i + 1 }}</td>
                            <td class="rtl:text-center">{{ accident.quotation.customer_name }}</td>
                            <td class="rtl:text-center">{{ accident.policy_num }}</td>
                            <td class="rtl:text-center">{{ accident.accident_date }}</td>
                            <td class="px-4 py-3 whitespace-nowrap filament-tables-actions-cell rtl:text-center">
                                <div
                                    class="flex items-center justify-end gap-4 my-4"
                                >
                                    <div>
                                        <Link
                                            class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-primary-700 hover:text-primary-500 filament-tables-link-action"
                                            :href="route('accident.show', accident.id)"
                                            preserve-scroll
                                            preserve-state
                                        >
                                            <i
                                                class="bx bx-show text-[16px]"
                                            ></i>
                                            <div class="table_tooltip">
                                                {{ __('View') }}
                                            </div>
                                        </Link>
                                    </div>
                                    <div>
                                        <Component
                                            :is="'Link'"
                                            class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-warning-700 hover:text-warning-600 filament-tables-link-action"
                                            :href=" route('accident.edit', {
                                                        id: accident.id,
                                                    })"
                                        >
                                            <i
                                                class="bx bx-edit text-[16px]"
                                            ></i>
                                            <div class="table_tooltip">
                                                {{ __('Edit') }}
                                            </div>
                                        </Component>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
