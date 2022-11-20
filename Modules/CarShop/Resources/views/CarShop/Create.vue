<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            title="Create Car Shop"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <div class="mb-3 xl:w-full">
                <label
                    for="name_en"
                    class="form-label inline-block mb-2 text-gray-700 text-xl"
                    >name [EN]</label
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
                    >name [AR]</label
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
            <FormField label="location">
                <ViltRich
                    id="location"
                    :error="form.errors.location"
                    v-model="form.location"
                />
            </FormField>
            <BaseDivider />
            <FormField label="commission">
                <FormControl
                    v-model="form.commission"
                    type="text"
                    :error="form.errors.commission"
                />
            </FormField>
            <jet-input-error class="mt-2" :message="form.errors.commission" />
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
                        :href="route('car-shops.index')"
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
import ViltRich from "$/Components/Inputs/ViltRich.vue";

import JetInputError from "@/Jetstream/InputError.vue";

import { useForm } from "@inertiajs/inertia-vue3";

const form = useForm(
    {
        name: { en: null, ar: null },
        location: null,
        commission: null,
    },
    { remember: false }
);

const submit = (e) => {
    form.post(route("car-shops.store"));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
