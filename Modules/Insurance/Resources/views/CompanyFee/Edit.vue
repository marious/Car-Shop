<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            title="Edit Company Fee"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <FormField label="Fee Amount">
                <FormControl
                    v-model="form.fees_amount"
                    type="number"
                    :error="form.errors.fees_amount"
                />
            </FormField>
            <jet-input-error
                :message="form.errors.fees_amount"
                class="mt-2"
            />
            <BaseDivider />
            <div class="sm:col-span-4">
                <FormField label="Company">
                    <infinite-select
                        :per-page="15"
                        :api-url="route('api.companies.index')"
                        id="company"
                        name="company"
                        v-model="form.company"
                        label="name"
                        :class="{
                            'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                form.errors.company,
                        }"
                    ></infinite-select>
                </FormField>
                <jet-input-error
                    :message="form.errors.company"
                    class="mt-2"
                />
            </div>
            <BaseDivider />
            <div class="sm:col-span-4">
                <FormField label="Fee">
                    <infinite-select
                        :per-page="15"
                        :api-url="route('api.fees.index')"
                        id="fee"
                        name="fee"
                        v-model="form.fee"
                        label="name"
                        :class="{
                            'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                form.errors.fee,
                        }"
                    ></infinite-select>
                    <jet-input-error :message="form.errors.fee" class="mt-2" />
                </FormField>
            </div>
            <BaseDivider />

            <FormField label="Is Percent">
                <FormCheckRadioGroup
                    id="Is Percent"
                    v-model="form.is_percent"
                    name="is_percent"
                    type="switch"
                    :options="{ public: '' }"
                />
                <jet-input-error
                    :message="form.errors.is_percent"
                    class="mt-2"
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
                        :href="route('company-fees.index')"
                    />
                </BaseButtons>
            </template>
        </CardBox>
    </SectionMain>
</template>

<script setup>
import { mdiBallotOutline } from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import InfiniteSelect from "$/Components/Inputs/InfiniteSelect.vue";

import JetInputError from "@/Jetstream/InputError.vue";

import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
    model: Object,
});

let form = useForm(
    {
        ...props.model.data,
    },
    { remember: false }
);

const submit = (e) => {
    form.put(route("company-fees.update", form.id));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
