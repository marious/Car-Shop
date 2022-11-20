<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Create Company Fee')"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">

            <div class="sm:col-span-12">
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
                    <jet-input-error
                        :message="form.errors.company"
                        class="mt-2"
                    />
                </FormField>
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
                </FormField>
                <jet-input-error :message="form.errors.fee" class="mt-2" />
            </div>
            <BaseDivider />


            <FormField label="Is Percent">
                <FormCheckRadioGroup
                    id="is_percent"
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

            <FormField :label="__('Fee Amount')">
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
import { ref } from "vue";
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

const form = useForm(
    {
        fees_amount: null,
        is_percent: false,
        company: null,
        fee: null,
    },
    { remember: false }
);

const submit = (e) => {
    form.post(route("company-fees.store"));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
