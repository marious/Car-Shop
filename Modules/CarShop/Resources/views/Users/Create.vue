<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Create User')"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <div class="mb-3 xl:w-full">
                <label
                    for="name"
                    class="form-label inline-block mb-2 text-gray-700 text-l"
                    >{{ __("Name") }}</label
                >
                <input
                    type="text"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="name"
                    v-model="form.name"
                />
                <jet-input-error class="mt-2" :message="form.errors.name" />
            </div>
            <BaseDivider />
            <div class="mb-3 xl:w-full">
                <label
                    for="email"
                    class="form-label inline-block mb-2 text-gray-700 text-l"
                    >{{ __("Email") }}</label
                >
                <input
                    type="email"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="email"
                    v-model="form.email"
                />
                <jet-input-error class="mt-2" :message="form.errors.email" />
            </div>
            <BaseDivider />
            <div class="mb-3 xl:w-full">
                <label
                    for="name"
                    class="form-label inline-block mb-2 text-gray-700 text-l"
                    >{{ __("Phone") }}</label
                >
                <input
                    type="text"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="name"
                    v-model="form.phone"
                />
                <jet-input-error class="mt-2" :message="form.errors.phone" />
            </div>
            <BaseDivider />
            <div class="mb-3 xl:w-full">
                <label
                    for="user_type"
                    class="form-label inline-block mb-2 text-gray-700 text-l"
                    >{{ __("User Type") }}
                </label>
                <select
                    v-model="form.userType"
                    class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    aria-label="Default select example"
                >
                    <option value="1">Car Shop Admin</option>
                    <option value="2">Sales</option>
                </select>
                <jet-input-error class="mt-2" :message="form.errors.userType" />
            </div>
            <BaseDivider />
            <div class="mb-3 xl:w-full">
                <label
                    for="user_type"
                    class="form-label inline-block mb-2 text-gray-700 text-l"
                    >{{ __('Car Shop')}}</label
                >
                <select
                    v-model="form.carShop"
                    class="form-select appearance-none block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding bg-no-repeat border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    aria-label="Default select example"
                >
                    <option :value="carSop.id" v-for="carSop in carShops?.data">
                        {{ carSop.name }}
                    </option>
                </select>
                <jet-input-error class="mt-2" :message="form.errors.carShop" />
            </div>
            <BaseDivider />
            <div class="mb-3 xl:w-full">
                <label
                    for="name"
                    class="form-label inline-block mb-2 text-gray-700 text-l"
                    >{{__('Password')}}</label
                >
                <input
                    v-model="form.password"
                    type="password"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="name"
                />
                <jet-input-error class="mt-2" :message="form.errors.password" />
            </div>
            <BaseDivider />
            <div class="mb-3 xl:w-full">
                <label
                    for="password_confirm"
                    class="form-label inline-block mb-2 text-gray-700 text-l"
                    >{{__('Confirm Password')}}</label
                >
                <input
                    v-model="form.password_confirmation"
                    type="password"
                    class="form-control block w-full px-4 py-2 text-xl font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-600 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                    id="name"
                />
                <jet-input-error
                    class="mt-2"
                    :message="form.errors.password_confirmation"
                />
            </div>
            <BaseDivider />

            <FormField :label="__('Is Active')">
                <FormCheckRadioGroup
                    id="is_active"
                    v-model="form.is_active"
                    name="is_active"
                    type="switch"
                    :options="{ public: '' }"
                />
            </FormField>
            <jet-input-error :message="form.errors.is_active" class="mt-2" />

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
                        :href="route('system-users.index')"
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
import BaseButton from "@/Components/BaseButton.vue";
import FormField from "@/Components/FormField.vue";
import FormCheckRadioGroup from "@/Components/FormCheckRadioGroup.vue";
import BaseDivider from "@/Components/BaseDivider.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";

import JetInputError from "@/Jetstream/InputError.vue";

import { useForm } from "@inertiajs/inertia-vue3";

let props = defineProps({
    carShops: Object,
});

const form = useForm(
    {
        name: null,
        email: null,
        phone: null,
        userType: null,
        carShop: null,
        password: null,
        password_confirmation: null,
        is_active: false,
    },
    { remember: false }
);

const submit = (e) => {
    form.post(route("system-users.store"));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
