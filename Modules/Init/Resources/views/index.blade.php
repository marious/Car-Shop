<script setup>
    import {useAttrs, ref, watch} from 'vue';
    import debounce from 'lodash/debounce';
    import {Inertia} from '@inertiajs/inertia';
    import {pickBy} from 'lodash';
    import Pagination from '$/Components/Pagination.vue';
    import {useTrans} from '@@/Composables/useTrans';
    import TopHeader from './TopHeader.vue';
    import DeleteModal from './Modals/DeleteModal.vue';
    // import UpdateModal from './Components/Modals/UpdateModal.vue';
    import ViewModal from './Modals/ViewModal.vue';

    let props = defineProps({
        isModal: Boolean,
        filters: Object,
        {{lcfirst($modelPlural)}}: Object,
    });

    const attrs = useAttrs();
    const {trans} = useTrans();

    const form = ref({
        search: props.filters.search,
    });

    let showModal = ref(false);
    let updateModal = ref(false);
    let deleteModal = ref(false);
    let deletedItemId = ref(0);
    let showModalData = ref({});

    let updatedFormData = ref({
        title: '',
        body: '',
        is_published: false,
    });

    function fireDelete(id) {
        deleteModal.value = true;
        deletedItemId = id;
    }

    function deleteItem() {
        Inertia.delete(route('{{$modelRouteAndViewName}}.destroy', { id: deletedItemId }), {
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
                Inertia.get('/admin/{{ $modelRouteAndViewName }}', pickBy(form.value), {
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
        <TopHeader v-model="form.search" :isModal="isModal"/>
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
                            @if ($withoutBulk)
                            <th
                                    class="w-4 px-4 py-4 whitespace-nowrap filament-tables-checkbox-cell"
                            >
                                <input
                                        class="block border-gray-300 rounded shadow-sm text-primary-600 focus:border-primary-600 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
                                        type="checkbox"
                                />
                            </th>
                            @endif
                            @foreach ($columnsToQuery as $column)
                                <th class="filament-tables-header-cell">{{ Str::ucfirst($column) }}</th>
                            @endforeach
                            <th class="w-5">Action</th>
                        </tr>
                        </thead>

                        <tbody class="divide-y whitespace-nowrap">
                        <tr
                                class="hover:bg-primary-500/5 dark:hover:bg-primary-500/5 filament-tables-row dark:text-white"
                                v-for="{{$modelVariableName}} in {{lcfirst($modelPlural)}}.data"
                                :key="{{$modelVariableName}}.id"
                        >
                            @if ($withoutBulk)
                            <th
                                    class="w-4 px-4 whitespace-nowrap filament-tables-checkbox-cell rtl:text-right"
                            >
                                <input
                                        class="block border-gray-300 rounded shadow-sm text-primary-600 focus:border-primary-600 focus:ring focus:ring-primary-200 focus:ring-opacity-50 table-row-checkbox"
                                        value="1"
                                        type="checkbox"
                                />
                            </th>
                            @endif
                            @foreach ($columnsToQuery as $column)
                              <td>{{'{{'}} {{$modelVariableName}}.{{$column}} }}</td>
                            @endforeach

                            <td
                                    class="px-4 py-3 whitespace-nowrap filament-tables-actions-cell"
                            >
                                <div class="flex items-center justify-end gap-4 my-4">
                                    <div>
                                        <Link
                                                class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-primary-700 hover:text-primary-500 filament-tables-link-action"
                                                href="#"
                                                {{'@'}}click.prevent="showViewModal({{$modelVariableName}})"
                                                preserve-scroll
                                                preserve-state
                                        >
                                        <i class="bx bx-show text-[16px]"></i>
                                        <div class="table_tooltip">
                                            @{{ trans('global.view') }}
                                        </div>
                                        </Link>
                                    </div>
                                    <div>
                                        <Component
                                                :is="isModal ? 'button' : 'Link'"
                                                class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-warning-700 hover:text-warning-600 filament-tables-link-action"
                                                :href="route('{{$modelRouteAndViewName}}.edit', { id:
                                                {{$modelVariableName}}.id })"
                                                {{'@'}}click="isModal ? showEditModal(post) : ''"
                                        >
                                            <i class="bx bx-edit text-[16px]"></i>
                                            <div class="table_tooltip">Edit</div>
                                        </Component>
                                    </div>
                                    <button
                                            type="button"
                                            class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-danger-600 hover:text-danger-500 filament-tables-link-action"
                                            {{'@'}}click.prevent="fireDelete({{$modelVariableName}}.id)"
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
                                        <i class="bx bx-delete text-[16px]"></i>
                                        <div class="table_tooltip">Delete</div>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <Pagination :collection="{{lcfirst($modelPlural)}}.meta" class="mt-6"/>

        <DeleteModal
                title="Delete Post"
                :show="deleteModal"
                {{'@'}}close="deleteModal = !deleteModal"
                {{'@'}}delete="deleteItem"
        />
{{--        <UpdateModal--}}
{{--                :show-modal="updateModal"--}}
{{--                :data="updatedFormData"--}}
{{--                title="Update Post"--}}
{{--                {{'@'}}closeModal="updateModal = !updateModal"--}}
{{--        />--}}
        <ViewModal
                :show-modal="showModal"
                :data="showModalData"
                title="View Post"
                @@closeModal="showModal = !showModal"
        />
    </div>
</template>

<script>
    import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

    export default {
        layout: ResourceTableLayout,
    };
</script>
