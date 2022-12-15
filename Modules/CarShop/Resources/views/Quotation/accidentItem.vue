<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Accident Info')"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form>
            <div class="mb-3 xl:w-full mb-2">
                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">{{ __('Car Info') }}</h2>
                <table class="min-w-full">
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Customer Name') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.customer_name }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                           {{ __('Document Number') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.policy_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Plate Number') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.car_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Chasses No') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.chasses_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Company') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.company.name.ar }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                           {{ __('Car Brand') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.brand.name.en }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left rtl:text-right">
                            {{ __('Car Model') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.model.name.en }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left rtl:text-right">
                            {{ __('Car Price') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.quotation.price }}
                        </td>
                    </tr>

                </table>
                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">{{ __('Accident Info') }}</h2>
                <table class="min-w-full">
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Accident Date') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.accident_date }}
                        </td>
                    </tr>


                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                           {{ __('Accident Description') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.description }}
                        </td>
                    </tr>

                    <tr v-if="isAdmin">
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Mk Notes') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.admin_note }}
                        </td>
                    </tr>

                    <tr v-if="isAdmin">
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                           {{ __('Amount Paid') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.compensation }}
                        </td>
                    </tr>


                    <tr v-if="isAdmin">
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                            {{ __('Payment Way') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.payment_way }}
                        </td>
                    </tr>

                    <tr v-if="accident.payment_way === 'bank' && isAdmin">
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                           {{ __('Account Number') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.account_num }}
                        </td>
                    </tr>

                    <tr v-if="accident.payment_way === 'check' && isAdmin">
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left rtl:text-right">
                           {{ __('Check No') }}
                        </th>
                        <td class="rtl:text-right">
                            {{ accident.check_num }}
                        </td>
                    </tr>

                </table>

                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">{{ __('Attachments')}}</h2>
                <div class="mt-5">
                    <Image v-for="image in medias"
                           :src="image['original_url']"
                           :key="image['id']"
                           alt="Image" width="350" preview
                           class="p-1 bg-white border rounded max-w-sm mr-2"
                    />
                </div>
            </div>
        </CardBox>

    </SectionMain>
</template>

<script setup>
import {mdiBallotOutline} from "@mdi/js";
import CardBox from "@/Components/CardBox.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import SectionMain from "@/Components/SectionMain.vue";
import Image from 'primevue/image';


let props = defineProps({
    accident: Object,
    medias: Array,
    isAdmin: Boolean,
});
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
