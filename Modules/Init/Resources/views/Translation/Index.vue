<script setup>
import { ref, computed } from "vue";
import TopHeader from "./TopHeader.vue";
import EditableCell from "$/Components/EditableCell.vue";
import {Inertia} from "@inertiajs/inertia";

let props = defineProps({
    translations: Object,
});

// props.translations.value.map(item => item.editable = false);

console.log(props.translations);

let fields = [
    { key: "name", label: "Name" },
    { key: "translation", label: "Translation", editable: true },
];

let editable = ref([]);

let focusedTd = ref(null);
const focusedField = computed(() => {
    if (!focusedTd.value) return;
    return fields[focusedTd.cellIndex];
});

function handleDblclick(key) {
    if (editable.value[key]) {
        editable.value[key] = !editable.value[key];
    } else {
        editable.value[key] = true;
    }
}

function save() {
    // editable.value.map(item => console.log(item));
    // console.log(props.translations);
    let data = [];
    for (const key in props.translations) {
        data.push({key: key, value: props.translations[key]});
    }

    let lang = route().params.lang ? route().params.lang : 'en';

    Inertia.post(route('translation.save'), {lang, data});
}
</script>
<template>
    <div class="px-6 pt-6 mx-auto">
        <TopHeader />
        <button
            @click="save"
            type="button"
            class="inline-block mt-5 px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
        >
            {{ __('Save') }}
        </button>
    </div>
    <div class="px-6 pt-6 mx-auto">
        <div
            class="bg-white dark:bg-gray-800 dark:border-gray-600 rounded-lg border"
        >
            <div class="relative overflow-y-auto dark:border-gray-800">
                <div>
                    <table
                        class="w-full text-left divide-y table-fixed xl:rtl:text-right filament-tables-table"
                    >
                        <thead class="bg-gray-100 border-t border-b">
                            <tr
                                class="bg-tableHead text-main dark:bg-gray-800 dark:text-white"
                            >
                                <th class="filament-tables-header-cell">
                                    {{ __('Label') }}
                                </th>
                                <th class="filament-tables-header-cell">
                                    {{ route().params.lang == 'ar' ? 'Arabic' : 'English'}}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="(translation, key, index) in translations"
                                :key="key"
                            >
                                <td>{{ key }}</td>
                                <td @dblclick="handleDblclick(key)">
                                    <div
                                        v-if="
                                            editable[key] &&
                                            editable[key] === true
                                        "
                                    >
                                        <input
                                            type="text"
                                            v-model="translations[key]"
                                        />

                                    </div>
                                    <span v-else v-text="translation" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <button
            @click="save"
            type="button"
            class="inline-block mt-5 px-7 py-3 bg-blue-600 text-white font-medium text-sm leading-snug uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out"
        >
            Save
        </button>
    </div>
</template>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
