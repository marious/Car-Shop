<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import ViltMedia from "$$/ViltMedia.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import JetInputError from "@/Jetstream/InputError.vue";
import Message from 'primevue/message';
import {onMounted, ref, watch} from 'vue';

const props = defineProps({
    info: Object,
    showModal: false,
    title: "",
});

const currentYear = new Date().getFullYear();
const minDateValue = new Date('1900-01-01');
const maxDate = new Date(`${currentYear - 17}-01-01`);

const successSend = ref(false);
const name = ref('');
const birthDate = ref('');
const phoneNum = ref('');
const carNumber = ref('');
const chassisNo = ref('');
const motorNo = ref('');
const attachments = ref([]);
const imageRow = {
    multi: true,
    name: 'Attachments',
};

const emit = defineEmits(["closeModal"]);

let form = useForm({
    year: props.info.year,
    price: props.info.price,
    brand_id: props.info.brandId,
    model_id: props.info.subBrandId,
    company_id: props.info.companyId,
    customer_name: name,
    birth_date: birthDate,
    car_num: carNumber,
    chasses_num: chassisNo,
    motor_num: motorNo,
    attachments: attachments,
    phone_num: phoneNum,
});


const submit = (e) => {
    form.year = props.info.year;
    form.price = props.info.price;
    form.brand_id = props.info.brandId;
    form.model_id = props.info.subBrandId;
    form.company_id = props.info.companyId;

    form.post(route('quotation.store'), {
        onSuccess: () => {
            name.value = '';
            birthDate.value = '';
            carNumber.value = '';
            chassisNo.value = '';
            motorNo.value = '';
            phoneNum.value = '';
            attachments.value = [];
            successSend.value = true;
            form.reset();
            setTimeout(() => close(), 1000);
        }
    })
    e.preventDefault();
}

function close() {
    successSend.value = false;
    // name.value = '';
    // birthDate.value = '';
    // carNumber.value = '';
    // chassisNo.value = '';
    // motorNo.value = '';
    // attachments.value = [];
    emit('closeModal');
}


watch(name, newVal => form.customer_name = newVal);
watch(birthDate, newVal => form.birth_date = newVal);
watch(carNumber, newVal => form.car_num = newVal);
watch(phoneNum, newVal => form.phone_num = newVal);
watch(chassisNo, newVal => form.chasses_num = newVal);
watch(motorNo, newVal => form.motor_num = newVal);
watch(attachments, newVal => form.attachments = newVal);
</script>
<template>
    <JetDialogModal :show="showModal" @end="close">
        <template #title>
            <h5 class="text-gray-900 text-xl font-medium mb-2 pb-2">
                {{ __('Make Quotation') }}
            </h5>
            <hr class="my-4"/>
        </template>
        <template #content>
            <Message v-if="successSend" severity="success" :life="5000">{{ __('Data Saved Successfully') }}</Message>
            <div class="form-group mb-6">
                <label for="name" class="form-label inline-block mb-2 text-gray-700">{{ __('Customer Name') }}</label>
                <InputText type="text" v-model="name" class="form-control block w-full" id="name"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['customer_name']"
                />
            </div>
            <div class="form-group mb-6">
                <label for="birth-date" class="form-label inline-block mb-2 text-gray-700">
                    {{ __('Birth Date') }}
                </label>
                <Calendar inputId="birth-date" v-model="birthDate" dateFormat="yy-mm-dd"
                          class="form-control block w-full" :minDate="minDateValue" :maxDate="maxDate" manualInput/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['birth_date']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="phone-number" class="form-label inline-block mb-2 text-gray-700">{{ __('Phone Number')
                    }}</label>
                <InputText type="text" v-model="phoneNum" class="form-control block w-full" id="phone-number"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['car_num']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="car-number" class="form-label inline-block mb-2 text-gray-700">{{ __('Plate Number') }}</label>
                <InputText type="text" v-model="carNumber" class="form-control block w-full" id="car-number"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['car_num']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="chassis-number" class="form-label inline-block mb-2 text-gray-700">{{ __('Chasses No') }}</label>
                <InputText type="text" v-model="chassisNo" class="form-control block w-full"
                           id="chassis-number"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['chasses_num']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="motor-number" class="form-label inline-block mb-2 text-gray-700"> {{ __('Motor No') }}</label>
                <InputText type="text" v-model="motorNo" class="form-control block w-full"
                           id="motor-number"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['motor_num']"
                />
            </div>

            <div class="form-group mb-6">
                <ViltMedia :message="dfd" :row="imageRow" v-model="attachments"/>
            </div>
        </template>
        <template #footer>
            <button type="submit" @click="submit" class="px-6
      py-2.5
      bg-blue-600
      text-white
      font-medium
      text-xs
      leading-tight
      uppercase
      rounded
      shadow-md
      hover:bg-blue-700 hover:shadow-lg
      focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
      active:bg-blue-800 active:shadow-lg
      transition
      duration-150
      ease-in-out mr-2"
            >

                {{ __('Save') }}
            </button>


            <JetSecondaryButton @click="close">
                {{ __('Close') }}
            </JetSecondaryButton>
        </template>

    </JetDialogModal>
</template>
