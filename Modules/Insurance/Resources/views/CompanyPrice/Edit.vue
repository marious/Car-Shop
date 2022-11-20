<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            title="Edit Company Price"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <div class="sm:col-span-4">
                <FormField>
                    <div>
                        <label
                            for="company"
                            class="mb-2 inline-block font-medium"
                            >{{ __("Company") }}</label
                        >
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
                    </div>

                    <div>
                        <label
                            for="price"
                            class="mb-2 inline-block font-medium"
                            >{{ __("Price") }}</label
                        >
                        <infinite-select
                            :per-page="15"
                            :api-url="route('api.prices.index')"
                            id="price"
                            name="price"
                            v-model="form.price"
                            label="name"
                            :class="{
                                'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                    form.errors.price,
                            }"
                        ></infinite-select>
                        <jet-input-error
                            :message="form.errors.price"
                            class="mt-2"
                        />
                    </div>
                </FormField>

                <FormField>
                    <div>
                        <label
                            for="price"
                            class="mb-2 inline-block font-medium"
                            >{{ __("From") }}</label
                        >
                        <FormControl
                            v-model="form.param_from"
                            type="number"
                            :error="form.errors.param_from"
                        />
                        <jet-input-error
                            :message="form.errors.param_from"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <label for="to" class="mb-2 inline-block font-medium">{{
                            __("To")
                        }}</label>
                        <FormControl
                            v-model="form.param_to"
                            type="number"
                            :error="form.errors.param_to"
                        />
                        <jet-input-error
                            :message="form.errors.param_to"
                            class="mt-2"
                        />
                    </div>
                </FormField>

                <FormField label="Rate">
                    <div>
                        <FormControl
                            v-model="form.rate"
                            type="number"
                            :error="form.errors.rate"
                        />
                    </div>
                    <div></div>
                </FormField>
            </div>
            <jet-input-error :message="form.errors.rate" class="mt-2" />

            <template #footer>
                <BaseButtons>
                    <BaseButton
                        type="submit"
                        color="info"
                        :label="__('Submit')"
                        :disabled="form.processing"
                        :processing="form.processing"
                    />
                    <BaseButton
                        color="info"
                        outline
                        :label="__('Back')"
                        as="Link"
                        :href="route('company-prices.index')"
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
    form.put(route("company-prices.update", form.id));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
