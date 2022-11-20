<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Create Company Car Model')"
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
                            for="car_brand"
                            class="mb-2 inline-block font-medium"
                            >{{ __("Car Brand") }}</label
                        >
                        <infinite-select
                            :per-page="15"
                            :api-url="route('api.car-brands.index')"
                            id="card_brands"
                            name="car_brands"
                            label="name"
                            :class="{
                                'border-red-500 sm:focus:border-red-300 sm:focus:ring-red-100':
                                    form.errors.brand,
                            }"
                            v-model="form.brand"
                            @update:modelValue="getModels"
                        ></infinite-select>
                        <jet-input-error
                            :message="form.errors.brand"
                            class="mt-2"
                        />
                    </div>
                </FormField>

                <FormField>
                    <div>
                        <label
                            for="car_brand"
                            class="mb-2 inline-block font-medium"
                            >{{ __("Car Model") }}</label
                        >
                        <v-select
                            class="px-2 py-1 border border-gray-200 rounded-none shadow-none bg-gray-50"
                            v-model="form.car_models"
                            :options="carModels"
                            label="name"
                            multiple="true"
                        ></v-select>
                        <jet-input-error
                            :message="form.errors.car_models"
                            class="mt-2"
                        />
                    </div>
                    <div>
                        <label
                            for="car_brand"
                            class="mb-2 inline-block font-medium"
                        >{{ __("Category") }}</label
                        >
                        <FormControl
                            v-model="form.category"
                            type="number"
                            :error="form.errors.category"
                        />
                        <jet-input-error class="mt-2" :message="form.errors.category" />
                    </div>
                </FormField>
            </div>
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
                        :href="route('company-car-models.index')"
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
import vSelect from "vue-select";

let carModels = ref([]);

const form = useForm(
    {
        category: null,
        car_models: null,
        company: null,
        brand: null,
    },
    { remember: false }
);

function getModels(e) {
    carModels.value = [];
    form.car_models = null;
    axios.get(route("order.get_sub_brand", form.brand.id)).then((res) => {
        carModels.value = res.data.data;
        form.car_models = res.data.data;
    });
}

const submit = (e) => {
    form.post(route("company-car-models.store"));
};
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
