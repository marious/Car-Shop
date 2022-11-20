<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="'Accident Info'"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form>
            <div class="mb-3 xl:w-full mb-2">
                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">Quotations Info</h2>
                <table class="min-w-full">
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            اسم العميل
                        </th>
                        <td>
                            {{ accident.quotation.customer_name }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                           رقم الوثيقة
                        </th>
                        <td>
                            {{ accident.quotation.policy_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            رقم اللوحة
                        </th>
                        <td>
                            {{ accident.quotation.car_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            رقم الشاسيه
                        </th>
                        <td>
                            {{ accident.quotation.chasses_num }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            الشركة
                        </th>
                        <td>
                            {{ accident.quotation.company.name.ar }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            ماركة السيارة
                        </th>
                        <td>
                            {{ accident.quotation.brand.name.en }}
                        </td>
                    </tr>
                    <tr>
                        <th scope="col" class="text-lg font-bold  px-6 py-4 text-left">
                            موديل السيارة
                        </th>
                        <td>
                            {{ accident.quotation.model.name.en }}
                        </td>
                    </tr>

                </table>
                <h2 class="font-bold font-lg py-5 bg-gray-200 px-5">Accident Info</h2>
                <table class="min-w-full">
                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            تاريخ الحادث
                        </th>
                        <td>
                            {{ accident.accident_date }}
                        </td>
                    </tr>


                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            وصف الحادث
                        </th>
                        <td>
                            {{ accident.description }}
                        </td>
                    </tr>

                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            ملاحظات (MK)
                        </th>
                        <td>
                            {{ accident.admin_note }}
                        </td>
                    </tr>

                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            المبلغ المدفوع (التعويض)
                        </th>
                        <td>
                            {{ accident.compensation }}
                        </td>
                    </tr>


                    <tr>
                        <th scope="col" class="text-lg font-bold px-6 py-4 text-left">
                            طريقة الدفع
                        </th>
                        <td>
                            {{ accident.payment_way }}
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
});
</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
