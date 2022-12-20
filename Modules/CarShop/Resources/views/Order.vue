<script setup>
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import FormField from "@/Components/FormField.vue";
import FormControl from "@/Components/FormControl.vue";
import BaseButton from "@/Components/BaseButton.vue";
import BaseButtons from "@/Components/BaseButtons.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import ViewModal from "./ViewModal.vue";
import vSelect from "vue-select";
import "vue-select/dist/vue-select.css";
import {useForm} from "@inertiajs/inertia-vue3";
import {ref} from "vue";
import CommissionModal from "./CommissionModal.vue";
import QutationModal from "./Quotation/QutationModal.vue";

let props = defineProps({
    processing: false,
    carBrands: Object,
    carModels: Object,
    showCommission: Boolean,
    showQuotation: Boolean,
});

let currentYear = new Date().getFullYear() + 1;
let yearsRange = 11;

let feedBack = ref({});
let processTotalPremium = ref(false);
let showResult = ref(false);

let subBrands = ref([]);
let carsTotalPremium = ref([]);

const form = useForm({
    brands: "",
    subBrand: "",
    price: "",
    year: "",
});

function getSubBrand(e) {
    subBrands.value = [];
    form.subBrand = "";
    subBrands.value = [];
    axios.get(route("order.get_sub_brand", form.brands.id)).then((res) => {
        subBrands.value = res.data.data;
    });
}

function submit(e) {
    processTotalPremium.value = true;
    showResult.value = false;
    carsTotalPremium.value = [];
    axios
        .post(route("order.get_result"), form)
        .then((res) => {
            processTotalPremium.value = false;
            showResult.value = true;
            carsTotalPremium.value = res.data;
            feedBack.value = [];
        })
        .catch((err) => {
            carsTotalPremium.value = [];
            processTotalPremium.value = false;
            showResult.value = true;
            feedBack.value = err.response.data.errors;
        });
}

let showModalData = ref({});
let showModalComissionData = ref({});
let quotationData = ref({});
let showModal = ref(false);
let showCommissionModal = ref(false);
let showQuotationModal = ref(false);

function pdfDownload() {
}

function modalView(
    {price, subBrandId, year, brandId, companyId},
    modalType = "modalData"
) {
    axios
        .post(route("order.item_details"), {
            price,
            subBrandId,
            year,
            brandId,
            companyId,
        })
        .then((res) => {
            if (modalType === "commission") {
                showModalComissionData.value = res.data;
                showCommissionModal.value = true;
            } else {
                showModalData.value = res.data;
                showModal.value = true;
            }
        })
        .catch((err) => {
            console.log(err);
        });
}

function quotationModal(obj) {
    quotationData.value = obj;
    showQuotationModal.value = true;
}
</script>

<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Enter Your Car Info')"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <FormField>
                <div>
                    <label
                        for="car-brand"
                        class="mb-2 inline-block font-medium"
                    >{{ __("Select Brand") }}</label
                    >
                    <v-select
                        id="car-brand"
                        class="px-2 py-1 border border-gray-200 rounded-none shadow-none bg-gray-50"
                        v-model="form.brands"
                        @update:modelValue="getSubBrand"
                        :options="carBrands.data"
                        label="name"
                    ></v-select>
                    <jet-input-error
                        :message="feedBack.brands ? feedBack.brands[0] : ''"
                        class="mt-1"
                    />
                </div>

                <div>
                    <label
                        for="car-model"
                        class="mb-2 inline-block font-medium"
                    >{{ __("Select Model") }}</label
                    >
                    <v-select
                        id="car-model"
                        class="px-2 py-1 border border-gray-200 rounded-none shadow-none bg-gray-50"
                        v-model="form.subBrand"
                        :options="subBrands"
                        label="name"
                    ></v-select>
                    <jet-input-error
                        :message="feedBack.subBrand ? feedBack.subBrand[0] : ''"
                        class="mt-1"
                    />
                </div>
            </FormField>

            <FormField>
                <label for="price" class="inline-block font-medium">{{
                        __("Price")
                    }}</label>
                <input
                    id="price"
                    v-model="form.price"
                    type="number"
                    ref="inputEl"
                />
                <jet-input-error
                    :message="feedBack.price ? feedBack.price[0] : ''"
                    class="mt-1"
                />
                <label for="year" class="inline-block mt-2 font-medium">{{
                        __("Model Year")
                    }}</label>
                <select v-model="form.year" id="year">
                    <option value="0" selected disabled>
                        -- {{ __("Select Year") }} --
                    </option>
                    <option
                        v-for="(i, index) in yearsRange"
                        :key="index"
                        :value="currentYear - i + 1"
                    >
                        {{ currentYear - i + 1 }}
                    </option>
                </select>
                <jet-input-error
                    :message="feedBack.year ? feedBack.year[0] : ''"
                    class="mt-1"
                />
            </FormField>
            <BaseDivider/>

            <template #footer>
                <BaseButtons>
                    <BaseButton
                        type="submit"
                        color="info"
                        label="Submit"
                        :disabled="processTotalPremium"
                        :processing="processTotalPremium"
                    />
                </BaseButtons>
            </template>
        </CardBox>
        <CardBox>
            <div class="text-center" v-if="processTotalPremium">
                <div role="status">
                    <svg
                        class="inline mr-2 w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                        viewBox="0 0 100 101"
                        fill="none"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                            fill="currentColor"
                        />
                        <path
                            d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                            fill="currentFill"
                        />
                    </svg>
                    <span class="sr-only">{{ __("Loading") }}...</span>
                </div>
            </div>
            <div>
                <h5
                    class="text-gray-900 text-xl font-medium mb-2 pb-2"
                    v-if="carsTotalPremium.length"
                >
                    Insurance For {{ carsTotalPremium[0].brand_name }}
                    {{ carsTotalPremium[0].car_model_name }}
                </h5>
                <div class="flex justify-start" v-if="showResult">
                    <div
                        class="rounded-lg shadow-lg bg-whit max-w-xl ml-5 p-10"
                        v-for="car in carsTotalPremium"
                    >
                        <a href="#!">
                            <img
                                class="rounded-t-lg"
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/8/86/Orange_sport_car.svg/1280px-Orange_sport_car.svg.png"
                                alt=""
                            />
                        </a>
                        <div class="p-6">
                            <p
                                class="text-gray-900 text-l font-medium mb-2 pb-2"
                            >
                                {{ __("Company") }} :
                                {{ car.company.name }}
                            </p>
                            <hr/>
                            <p
                                class="text-gray-900 text-l font-medium mb-2 pb-2"
                            >
                                {{ __("Car Price") }} :
                                {{ car.sum_insured }} EGP
                            </p>
                            <hr/>
                            <p
                                class="text-gray-900 text-l font-medium mb-2 pb-2 pt-2"
                            >
                                {{ __("Rate") }} : {{ car.rate }} %
                            </p>
                            <hr/>
                            <p
                                class="text-gray-900 text-sm font-medium mb-2 pb-2 pt-2"
                            >
                                {{ __("Net Premium") }} : {{ car.premium }} EGP
                            </p>
                            <hr/>
                            <p
                                class="text-gray-900 text-sm font-medium mb-2 pb-2 pt-2"
                            >
                                {{ __("Total Premium") }} :
                                {{ car.total_premium }} EGP
                            </p>
                            <hr/>
                            <p
                                class="text-gray-900 text-sm font-medium mb-2 pb-2 pt-2"
                            >
                                {{ __("Bear Expenses") }} :
                                {{ car.company.bears_expenses }}
                            </p>

                            <button
                                type="button"
                                class="inline-block px-6 py-2.5 bg-blue-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-blue-700 hover:shadow-lg focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-blue-800 active:shadow-lg transition duration-150 ease-in-out mt-5"
                                @click.prevent="
                                    modalView({
                                        year: car.year,
                                        subBrandId: car.subBrandId,
                                        price: car.price,
                                        brandId: car.brandId,
                                        companyId: car.company.id,
                                    })
                                "
                            >
                                {{ __("Details") }}
                            </button>

                            <button
                                v-if="showCommission"
                                @click.prevent="
                                    modalView(
                                        {
                                            year: car.year,
                                            subBrandId: car.subBrandId,
                                            price: car.price,
                                            brandId: car.brandId,
                                            companyId: car.company.id,
                                        },
                                        'commission'
                                    )
                                "
                                class="inline-block ml-2 px-6 py-2 bg-gray-600 text-white font-medium text-sm leading-tight uppercase rounded shadow-md hover:bg-gray-800 hover:shadow-lg focus:bg-gray-800 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-lg transition duration-150 ease-in-out mt-5"
                            >
                                <i class="bx bx-money"></i>
                            </button>

                            <button
                                v-if="showQuotation"
                                @click.prevent="quotationModal({
                                    year: car.year,
                                    subBrandId: car.subBrandId,
                                    price: car.price,
                                    brandId: car.brandId,
                                    companyId: car.company.id,
                                })"
                                class="inline-block ml-2 px-6 py-2 bg-gray-600 text-white font-medium text-sm leading-tight uppercase rounded shadow-md hover:bg-gray-800 hover:shadow-lg focus:bg-gray-800 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-lg transition duration-150 ease-in-out mt-5"
                            >
                                Quotation
                            </button>

                            <a
                                :href="route(`order.download`, {
                                    _query: {
                                            year: car.year,
                                            subBrandId: car.subBrandId,
                                            price: car.price,
                                            brandId: car.brandId,
                                            companyId: car.company.id,
                                    }
                                })"
                                class="inline-block ml-2 px-6 py-2 bg-gray-600 text-white font-medium text-sm leading-tight uppercase rounded shadow-md hover:bg-gray-800 hover:shadow-lg focus:bg-gray-800 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-gray-800 active:shadow-lg transition duration-150 ease-in-out mt-5"
                                target="_blank"
                            >
                                <i class="bx bxs-file-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </CardBox>

        <ViewModal
            :show-modal="showModal"
            :data="showModalData"
            @closeModal="showModal = !showModal"
        />
        <CommissionModal
            :show-modal="showCommissionModal"
            :data="showModalComissionData"
            @closeModal="showCommissionModal = !showCommissionModal"
        />

        <QutationModal
            :show-modal="showQuotationModal"
            :info="quotationData"
            @closeModal="showQuotationModal = !showQuotationModal"
        />
    </SectionMain>
</template>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>

<style>
@import "vue-select/dist/vue-select.css";

.loader {
    text-align: center;
    color: #bbbbbb;
}

.vs__dropdown-toggle {
    border: none !important;
}
</style>
