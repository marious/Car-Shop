<script setup>
import { useAttrs, ref, watch } from "vue";
import debounce from "lodash/debounce";
import { Inertia } from "@inertiajs/inertia";
import { pickBy } from "lodash";
import Pagination from "$/Components/Pagination.vue";
import { useTrans } from "@@/Composables/useTrans";
import TopHeader from "./TopHeader.vue";
import DeleteModal from "./Modals/DeleteModal.vue";
// import UpdateModal from './Components/Modals/UpdateModal.vue';
import ViewModal from "./Modals/ViewModal.vue";

let props = defineProps({
    isModal: Boolean,
    filters: Object,
    companyPrices: Object,
});

const attrs = useAttrs();
const { trans } = useTrans();

const form = ref({
    search: props.filters.search,
});

let showModal = ref(false);
let updateModal = ref(false);
let deleteModal = ref(false);
let deletedItemId = ref(0);
let showModalData = ref({});

let updatedFormData = ref({
    title: "",
    body: "",
    is_published: false,
});

function fireDelete(id) {
    deleteModal.value = true;
    deletedItemId = id;
}

function deleteItem() {
    Inertia.delete(route("company-prices.destroy", { id: deletedItemId }), {
        onSuccess: () => (deleteModal.value = false),
    });
}

function showEditModal(data) {
    updatedFormData.value = data;
    updateModal.value = true;
}

function showViewModal(data) {
    showModalData.value = data;
    showModal.value = true;
}

watch(
    form,
    function () {
        debounce(function () {
            Inertia.get("/admin/company-prices", pickBy(form.value), {
                preserveState: true,
            });
        }, 300)();
    },
    {
        deep: true,
    }
);
</script>

<template>
    <div class="px-6 pt-6 mx-auto">
        <TopHeader v-model="form.search" :isModal="isModal" />
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
                                <th class="filament-tables-header-cell">Id</th>
                                <th class="filament-tables-header-cell">
                                    {{ __("Company") }}
                                </th>
                                <th class="filament-tables-header-cell">
                                    {{ __("Price") }}
                                </th>
                                <th class="filament-tables-header-cell">
                                    {{ __("From") }}
                                </th>
                                <th class="filament-tables-header-cell">
                                    {{ __("To") }}
                                </th>
                                <th class="filament-tables-header-cell">
                                    {{ __("Rate") }}
                                </th>
                                <th class="w-5">{{ __("Action") }}</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y whitespace-nowrap">
                            <tr
                                class="hover:bg-primary-500/5 dark:hover:bg-primary-500/5 filament-tables-row dark:text-white"
                                v-for="companyPrice in companyPrices.data"
                                :key="companyPrice.id"
                            >
                                <td>{{ companyPrice.id }}</td>
                                <td>{{ companyPrice.company.name }}</td>
                                <td>{{ companyPrice.price.name }}</td>
                                <td>{{ companyPrice.param_from }}</td>
                                <td>{{ companyPrice.param_to }}</td>
                                <td>{{ companyPrice.rate }}</td>

                                <td
                                    class="px-4 py-3 whitespace-nowrap filament-tables-actions-cell"
                                >
                                    <div
                                        class="flex items-center justify-end gap-4 my-4"
                                    >
                                        <div>
                                            <Link
                                                class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-primary-700 hover:text-primary-500 filament-tables-link-action"
                                                href="#"
                                                @click.prevent="
                                                    showViewModal(companyPrice)
                                                "
                                                preserve-scroll
                                                preserve-state
                                            >
                                                <i
                                                    class="bx bx-show text-[16px]"
                                                ></i>
                                                <div class="table_tooltip">
                                                    {{ __("View") }}
                                                </div>
                                            </Link>
                                        </div>
                                        <div>
                                            <Component
                                                :is="
                                                    isModal ? 'button' : 'Link'
                                                "
                                                class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-warning-700 hover:text-warning-600 filament-tables-link-action"
                                                :href="
                                                    route(
                                                        'company-prices.edit',
                                                        { id: companyPrice.id }
                                                    )
                                                "
                                                @click="
                                                    isModal
                                                        ? showEditModal(post)
                                                        : ''
                                                "
                                            >
                                                <i
                                                    class="bx bx-edit text-[16px]"
                                                ></i>
                                                <div class="table_tooltip">
                                                    {{ __("Edit") }}
                                                </div>
                                            </Component>
                                        </div>
                                        <button
                                            type="button"
                                            class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-danger-600 hover:text-danger-500 filament-tables-link-action"
                                            @click.prevent="
                                                fireDelete(companyPrice.id)
                                            "
                                        >
                                            <svg
                                                class="w-4 h-4"
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
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                ></path>
                                            </svg>
                                            <i
                                                class="bx bx-delete text-[16px]"
                                            ></i>
                                            <div class="table_tooltip">
                                                {{__('Delete')}}
                                            </div>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination :collection="companyPrices.meta" class="mt-6" />

        <DeleteModal
            title="Delete Post"
            :show="deleteModal"
            @close="deleteModal = !deleteModal"
            @delete="deleteItem"
        />

        <ViewModal
            :show-modal="showModal"
            :data="showModalData"
            title="View Company Price"
            @closeModal="showModal = !showModal"
        />
    </div>
</template>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
