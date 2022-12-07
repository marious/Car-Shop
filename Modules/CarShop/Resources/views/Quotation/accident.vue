<template>
    <SectionMain>
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Inform Accident')"
            main
        >
        </SectionTitleLineWithButton>
        <CardBox is-form @submit.prevent="submit">
            <div class="form-group mb-6">
                <label for="accident_date" class="form-label inline-block mb-2 text-gray-700">{{ __('Accident Date')
                    }}</label>
                <Calendar inputId="accident_date" v-model="form.accident_date" dateFormat="yy-mm-dd"
                          class="form-control block w-full" aria-autocomplete="none" :maxDate="exceedDate"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['accident_date']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="description" class="form-label inline-block mb-2 text-gray-700">
                    {{ __('Accident Description') }}</label>
                <Textarea v-model="form.description" class="form-control block w-full" cols="30"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['description']"
                />
            </div>


            <div class="form-group mb-6" v-if="showFinancial">
                <label for="admin_note" class="form-label inline-block mb-2 text-gray-700">{{ __('Mk Notes') }}</label>
                <Textarea v-model="form.admin_note" class="form-control block w-full" cols="30"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['admin_note']"
                />
            </div>

            <div class="form-group mb-6 payment-amount" v-if="showFinancial">
                <label for="compensation" class="form-label inline-block mb-2 text-gray-700">
                {{ __('Amount Paid') }}</label>
                <InputNumber type="text" v-model="form.compensation" class="form-control block w-full"
                           id="compensation" aria-autocomplete="none" />
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['compensation']"
                />
            </div>

            <div class="form-group mb-6" v-if="showFinancial">
                <label for="compensation" class="form-label inline-block mb-2 text-gray-700">{{ __('Payment Way')
                    }}</label>

                <Dropdown v-model="form.payment_way" :options="paymentWays" optionLabel="label" optionValue="value"
                          :placeholder="__('Select Payment Way')" class="form-control block w-full"
                          @change="handleChangePayment"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['payment_way']"
                />
            </div>

            <div class="form-group mb-6"  v-if="paymentWay === 'bank'">
                <label for="account_num" class="form-label inline-block mb-2 text-gray-700">{{ __('Account Number') }}</label>
                <InputText type="text" v-model="form.account_num" class="form-control block w-full"
                           id="account_num"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['account_num']"
                />
            </div>

            <div class="form-group mb-6" v-if="paymentWay === 'check'">
                <label for="check_num" class="form-label inline-block mb-2 text-gray-700">{{ __('Check No') }}</label>
                <InputText type="text" v-model="form.check_num" class="form-control block w-full"
                           id="check_num"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['check_num']"
                />
            </div>

            <div class="form-group mb-6">
                <ViltMedia :message="f" :row="imageRow" v-model="attachments"/>
            </div>

            <div class="mb-6">
                <BaseButtons>
                    <BaseButton
                        type="submit"
                        color="info"
                        label="Submit"
                        :disabled="form.processing"
                        :processing="form.processing"
                    />
                    <BaseButton
                        class="ml-1"
                        color="info"
                        outline
                        label="Back"
                        as="Link"
                        :href="route('quotations.approved')"
                    />
                </BaseButtons>
            </div>
        </CardBox>
    </SectionMain>
</template>

<script setup>
import {ref} from "vue";
import {mdiBallotOutline} from "@mdi/js";
import SectionMain from "@/Components/SectionMain.vue";
import CardBox from "@/Components/CardBox.vue";
import InputText from 'primevue/inputtext';
import InputNumber from 'primevue/inputnumber';
import Calendar from 'primevue/calendar';
import ViltMedia from "../../../../Base/Services/Rows/Render/ViltMedia.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import Dropdown from 'primevue/dropdown';
import BaseButton from "@/Components/BaseButton.vue";
import JetInputError from "@/Jetstream/InputError.vue";
import Textarea from 'primevue/textarea';
import {useForm} from "@inertiajs/inertia-vue3";

const props = defineProps({
    quotationId: Number,
    showFinancial: Boolean,
});


let carModels = ref([]);

const exceedDate = new Date(Date.now());

let paymentWays = ref([
    {label: 'Cash', value: 'cash'},
    {label: 'Bank', value: 'bank'},
    {label: 'Check', value: 'check'},
]);

let paymentWay = ref('');
const attachments = ref([]);
const imageRow = {
    multi: true,
    name: 'Attachments',
};


const form = useForm(
    {
        accident_date: null,
        description: null,
        admin_note: null,
        compensation: null,
        payment_way: null,
        attachments: attachments,
        account_num: null,
        check_num: null,
    },
    {remember: false}
);


const submit = (e) => {
    form.post(route("accident.store", props.quotationId), {
        onSuccess: () => {
            form.reset();
        }
    });
};

const paymentType = ref(null);

const handleChangePayment = function (item) {
    paymentWay.value = item.value;
}

</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>
<style>
.payment-amount [type='text'] {
    border: none;
    padding: 0;
}
</style>
