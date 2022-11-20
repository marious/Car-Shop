<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            title="Edit Company"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <div class="mb-3 xl:w-full">
                <label
                    for="name_en"
                    class="form-label inline-block mb-2 text-gray-700 text-xl"
                    >{{ __("Name") }} [EN]</label
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
                    >{{ __("Name") }} [AR]</label
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

            <div>
                <label
                    for="bear_expenses"
                    class="form-label inline-block mb-2 text-gray-700 text-xl"
                >{{ __('Bear Expenses') }}</label
                >
                <input
                    type="text"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="bear_expenses"
                    v-model="form.bear_expenses"
                />
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['bear_expenses']"
                />
            </div>
            <BaseDivider />
            <FormField label="terms_conditions">
                <ViltRich
                    id="terms_conditions"
                    :error="form.errors.terms_conditions"
                    v-model="form.terms_conditions"
                />
            </FormField>
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
                        :href="route('companies.index')"
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
    form.put(route("companies.update", form.id));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
