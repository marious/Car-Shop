<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Edit Car Model')"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <div class="mb-3 xl:w-full">
                <label
                    for="name_en"
                    class="form-label inline-block mb-2 text-gray-700 text-xl"
                    >{{ __('Name') }} [EN]</label
                >
                <input
                    type="text"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="name"
                    v-model="form.name.en"
                />
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['name.en']"
                />
            </div>

            <BaseDivider />

            <div class="mb-3 xl:w-full">
                <label
                    for="name_ar"
                    class="form-label inline-block mb-2 text-gray-700 text-xl"
                    >{{ __('Name') }} [AR]</label
                >
                <input
                    type="text"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="name_ar"
                    v-model="form.name.ar"
                />
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['name.en']"
                />
            </div>

            <BaseDivider />

            <div class="sm:col-span-4">
                <label
                    for="name_ar"
                    class="form-label inline-block mb-2 text-gray-700 text-xl"
                    >Car Brand</label
                >
                <infinite-select
                    :per-page="15"
                    :api-url="route('api.car-brands.index')"
                    id="car_brand"
                    name="car_brand"
                    v-model="form.car_brand"
                    label="name"
                    :class="{
                        'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                            form.errors.car_brand,
                    }"
                ></infinite-select>
                <jet-input-error
                    :message="form.errors.car_brand"
                    class="mt-2"
                />
            </div>
            <BaseDivider />
            <template #footer>
                <BaseButtons>
                    <BaseButton
                        type="submit"
                        color="info"
                        label="Submit"
                        :disabled="form.processing"
                        :processing="form.processing"
                    />
                    <BaseButton
                        color="info"
                        outline
                        label="Back"
                        as="Link"
                        :href="route('car-models.index')"
                    />
                </BaseButtons>
            </template>
        </CardBox>
    </SectionMain>
</template>

<script setup>
import { ref } from "vue";
import { mdiBallotOutline } from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import InfiniteSelect from "$/Components/Inputs/InfiniteSelect.vue";

import JetInputError from "@/Jetstream/InputError.vue";

import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
    model: Object,
});

let form = useForm(
    {
        ...props.model,
    },
    { remember: false }
);

const submit = (e) => {
    form.put(route("car-models.update", form.id));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
