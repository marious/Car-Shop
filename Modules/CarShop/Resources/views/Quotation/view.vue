<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="title + ' ' + titleStatus"
            main
        >
        </SectionTitleLineWithButton>

        <CardBox is-form>
            <div class="mb-3 xl:w-full mb-2">
                <Message v-if="successLicence" severity="success" :life="5000">
                    {{ __('Approved Successfully') }}
                </Message>

                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">{{ __('Car Info') }}</h2>
                <table class="min-w-full">
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Customer Name') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.customer_name }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Phone Number') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.phone_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Birth Date') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.birth_date }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Plate Number') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.car_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Chasses No') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.chasses_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Motor No') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.motor_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Company') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.company.name.ar }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Car Brand') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.brand.name.en }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left rtl:text-right">
                            {{ __('Car Model') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.model.name.en }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left rtl:text-right">
                            {{ __('Car Price') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ quotation.price }}
                        </td>
                    </tr>

                </table>

                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">{{ __('Financial Info') }}</h2>
                <table class="min-w-full">
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left rtl:text-right">
                            {{ __('Net Premium') }}
                        </th>
                        <td class="rtl:text-right">{{ quotation.premium }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left rtl:text-right">
                            {{ __('Total Premium') }}
                        </th>
                        <td class="rtl:text-right">{{ quotation.total_premium }}</td>
                    </tr>
                    <tr v-for="fee in quotation.fees">
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left rtl:text-right">
                            {{ fee.name.en }}
                        </th>
                        <td class="rtl:text-right">
                            {{ fee.pivot.amount }}
                        </td>
                    </tr>
                </table>
                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">{{ __('Attachments') }}</h2>
                <div class="mt-5">
                    <Image v-for="image in medias"
                           :src="image['original_url']"
                           :key="image['id']"
                           alt="Image" width="350" preview
                           class="p-1 bg-white border rounded max-w-sm mr-2"
                    />
                </div>

                <div class="flex space-x-2 justify-center" v-if="!successLicence && showApproved">
                    <button type="button"
                            class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out"
                            @click="showModal = !showModal"
                    >
                        {{ __('Approve') }}
                    </button>
                </div>
            </div>
        </CardBox>
        <LicenceModal
            :show="showModal"
            title="Add Licence"
            @closeModal="showModal = !showModal"
            @successSaveLicence="licneceSuccess"
            :data="quotation"
        />
    </SectionMain>
</template>

<script setup>
import {mdiBallotOutline} from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import {ref, computed} from "vue";
import LicenceModal from "./Modals/LicenceModal.vue";
import Message from 'primevue/message';
import Image from 'primevue/image';
import {translations} from "$/Mixins/translations";


const __ = translations.methods.__;


let props = defineProps({
    quotation: Object,
    medias: Array,
    showApproved: Boolean,
});

let successLicence = ref(false);
let quotationApproved = ref(props.quotation.is_approved == 0 ? false : true);

let titleStatus = computed(() => {
    return quotationApproved.value ?
        '  <span class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">' + __('Approved') + '</span>'
        :
        '  <span class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-red-600 text-white rounded">' + __('Not Approved') + '</span>\n';

});
let showModal = ref(false);


function showLicenceModal() {
    showModal.value = true;
}

const licneceSuccess = () => {
    quotationApproved.value = true;
    successLicence.value = !successLicence.value;
};

const title = __('Quotation Info');
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
