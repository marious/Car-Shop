<script setup>
import {ref} from 'vue';
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import Calendar from 'primevue/calendar';
import Dropdown from 'primevue/dropdown';
import Button from 'primevue/button';
import JetInputError from "@/Jetstream/InputError.vue";

let props = defineProps({
    carShops: Array,
});

props.carShops.unshift({
    id: false,
    name: {
        en: 'All Car Shops',
        ar: 'All Car Shops',
    }
});

let quotationsReport = ref(false);
let isLoading = ref(false);

const form = useForm({
    fromDate: '',
    toDate: '',
    carShop: false,
});

let feedBack = ref([]);

const submit = () => {
    isLoading.value = true;
    axios.post(route('report.search'), form)
        .then(res => {
            quotationsReport.value = res.data
            feedBack.value = [];
            isLoading.value = false;
        })
        .catch(err => {
            isLoading.value = false;
            feedBack.value = err.response.data.errors;
        })
};

let formatDate = (date) => {
    return `${date.getDate()} - ${(date.getMonth() + 1)} - ${date.getFullYear()}`;
}

function makeSum(arr, type = '') {
    return arr.reduce((acc, value) => {
        return parseFloat(acc) + parseFloat(value[type])
    }, 0);
}
</script>
<template>
    <div class="px-6 pt-2 mx-auto">
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            :title="__('Car Shop Report')"
            main
        >
        </SectionTitleLineWithButton>
    </div>
    <div class="px-6 pt-6 mx-auto">
        <div class="bg-white dark:bg-gray-800 dark:border-gray-600 rounded-lg border">
            <div class="card-container">
                <div>
                    <label for="from-date">{{ __('From Date') }}</label>
                    <Calendar v-model="form.fromDate" inputId="birth-date" dateFormat="yy-mm-dd"
                              class="form-control block w-full" aria-autocomplete="none" id="from-date"/>
                    <jet-input-error
                        :message="feedBack.fromDate ? feedBack.fromDate[0] : ''"
                        class="mt-1"
                    />
                </div>
                <div>
                    <label for="to-date">{{ __('To Date') }}</label>
                    <Calendar v-model="form.toDate" inputId="birth-date" dateFormat="yy-mm-dd"
                              class="form-control block w-full" aria-autocomplete="none" id="to-date"/>
                    <jet-input-error
                        :message="feedBack.toDate ? feedBack.toDate[0] : ''"
                        class="mt-1"
                    />
                </div>
                <div>
                    <label for="" class="block">{{ __('Car Shop') }}</label>
                    <Dropdown v-model="form.carShop" :options="carShops" optionLabel="name.en"
                              :placeholder="__('Select Car Shop')"/>
                    <jet-input-error
                        :message="feedBack.carShop ? feedBack.carShop[0] : ''"
                        class="mt-1"
                    />
                </div>
                <div>
                    <Button :label="__('Submit')" class="submit-btn" @click.prevent="submit" :loading="isLoading"/>
                </div>
            </div>

            <table class="w-full text-left text-black-500 dark:text-gray-400" v-if="quotationsReport">
                <caption
                    class="p-5 text-lg font-semibold text-left text-gray-900 bg-white dark:text-white dark:bg-gray-800 text-center">
                    {{ __('Report From') }} ( {{ formatDate(form.fromDate) }} {{ __('To') }} {{
                        formatDate(form.toDate)
                    }} )
                </caption>
                <thead>
                <tr>
                    <th>{{ __('Car Shop') }}</th>
                    <th>{{ __('Policy Count') }}</th>
                    <th>{{ __('Total Net Premium') }}</th>
                    <th>{{ __('Total Gross Premium') }}</th>
                    <th>{{ __('Total Commission') }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="quotation in quotationsReport" :key="quotation.car_shop_id">
                    <th>{{ quotation.car_shop.name.ar }}</th>
                    <td>{{ quotation.policy_count }}</td>
                    <td>{{ parseFloat(quotation.total_net_premium) }}</td>
                    <td>{{ parseFloat(quotation.total_gross_premium) }}</td>
                    <td>{{ parseFloat(quotation.commission) }}</td>
                </tr>
                <tr>
                    <th>{{ __('Total') }}</th>
                    <th>{{ makeSum(quotationsReport, 'policy_count') }}</th>
                    <th>{{ makeSum(quotationsReport, 'total_net_premium') }} EGP</th>
                    <th>{{ makeSum(quotationsReport, 'total_gross_premium') }} EGP</th>
                    <th>{{ makeSum(quotationsReport, 'commission') }} EGP</th>
                </tr>

                </tbody>
            </table>

        </div>
    </div>
</template>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>

<style scoped>
.card-container {
    display: flex;
    padding: 20px;
}

.card-container div {
    margin-right: 10px;
}

.submit-btn {
    display: inline-block;
    margin-top: 20px;
}
</style>
