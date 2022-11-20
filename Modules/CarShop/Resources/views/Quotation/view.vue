<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="'Quotations Info ' + titleStatus"
            main
        >
        </SectionTitleLineWithButton>

        <CardBox is-form>
            <div class="mb-3 xl:w-full mb-2">
                <Message v-if="successLicence" severity="success" :life="5000">
                    Approved Successfully
                </Message>

                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">Quotations Info</h2>
                <table class="min-w-full">
                        <tr>
                            <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                                اسم العميل
                            </th>
                            <td>
                                {{ quotation.customer_name }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                                تاريخ الميلاد
                            </th>
                            <td>
                                {{ quotation.birth_date }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                               رقم اللوحة
                            </th>
                            <td>
                                {{ quotation.car_num }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                                رقم الشاسيه
                            </th>
                            <td>
                                {{ quotation.chasses_num }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                                رقم الموتور
                            </th>
                            <td>
                                {{ quotation.motor_num }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                                الشركة
                            </th>
                            <td>
                                {{ quotation.company.name.ar }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                              ماركة السيارة
                            </th>
                            <td>
                                {{ quotation.brand.name.en }}
                            </td>
                        </tr>
                        <tr>
                            <th scope="col" class="text-lg font-bold  px-6 py-4 text-left">
                                موديل السيارة
                            </th>
                            <td>
                                {{ quotation.model.name.en }}
                            </td>
                        </tr>

                </table>

                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">Financial Info</h2>
                <table class="min-w-full">
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left">Net Premium</th>
                        <td>{{ quotation.premium }}</td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left">Total Premium</th>
                        <td>{{ quotation.total_premium }}</td>
                    </tr>
                    <tr v-for="fee in quotation.fees">
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left">
                            {{fee.name.ar}}
                        </th>
                        <td>
                            {{fee.pivot.amount}}
                        </td>
                    </tr>
                </table>
                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">Attachments</h2>
                <div class="mt-5">
                    <Image v-for="image in medias"
                           :src="image['original_url']"
                           :key="image['id']"
                           alt="Image" width="350" preview
                           class="p-1 bg-white border rounded max-w-sm mr-2"
                    />
                </div>

                <div class="flex space-x-2 justify-center" v-if="!successLicence && showApproved">
                    <button type="button" class="inline-block px-6 py-2.5 bg-green-500 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-green-600 hover:shadow-lg focus:bg-green-600 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-green-700 active:shadow-lg transition duration-150 ease-in-out"
                            @click="showModal = !showModal"
                    >
                        Approve
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


let props = defineProps({
    quotation: Object,
    medias: Array,
    showApproved: Boolean,
});

let successLicence = ref(false);
let quotationApproved = ref(props.quotation.is_approved == 0 ? false : true);

let titleStatus = computed(() => {
   return quotationApproved.value ?
       '  <span class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-green-500 text-white rounded">Approved</span>'
       :
       '  <span class="text-xs inline-block py-1 px-2.5 leading-none text-center whitespace-nowrap align-baseline font-bold bg-red-600 text-white rounded">Not Approved</span>\n';

});
let showModal = ref(false);


function showLicenceModal() {
    showModal.value = true;
}

const licneceSuccess = () => {
    quotationApproved.value = true;
    successLicence.value = ! successLicence.value;
};

</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
