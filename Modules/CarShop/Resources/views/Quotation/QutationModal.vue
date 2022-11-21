<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import ViltMedia from "$$/Base/Services/Rows/Render/ViltMedia.vue";
import {useForm} from "@inertiajs/inertia-vue3";
import JetInputError from "@/Jetstream/InputError.vue";
import Message from 'primevue/message';
import {ref} from 'vue';

const props = defineProps({
    info: Object,
    showModal: false,
    title: "",
});


const successSend = ref(false);
const name = ref('');
const birthDate = ref('');
const carNumber = ref('');
const chassisNo = ref('');
const motorNo = ref('');
const attachments = ref([]);
const imageRow = {
    multi: true,
    name: 'attachments',
};

const emit = defineEmits(["closeModal"]);

const form = useForm({
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
}, {remember: false});


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
            attachments.value = [];
            successSend.value = true;
            form.reset();
        }
    })
    e.preventDefault();
}

function close() {
    successSend.value = false;
    name.value = '';
    birthDate.value = '';
    carNumber.value = '';
    chassisNo.value = '';
    motorNo.value = '';
    attachments.value = [];
    emit('closeModal');
}

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
            <Message v-if="successSend" severity="success" :life="5000">تم إرسال البيانات بنجاح</Message>
            <div class="form-group mb-6">
                <label for="name" class="form-label inline-block mb-2 text-gray-700">اسم
                    العميل</label>
                <InputText type="text" v-model="name" class="form-control block w-full" id="name"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['customer_name']"
                />
            </div>
            <div class="form-group mb-6">
                <label for="birth-date" class="form-label inline-block mb-2 text-gray-700">تاريخ
                    الميلاد</label>
                <Calendar inputId="birth-date" v-model="birthDate" dateFormat="yy-mm-dd"
                          class="form-control block w-full"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['birth_date']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="car-number" class="form-label inline-block mb-2 text-gray-700">رقم اللوحة</label>
                <InputText type="text" v-model="carNumber" class="form-control block w-full" id="car-number"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['car_num']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="chassis-number" class="form-label inline-block mb-2 text-gray-700">رقم الشاسيه</label>
                <InputText type="text" v-model="chassisNo" class="form-control block w-full"
                           id="chassis-number"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['chasses_num']"
                />
            </div>

            <div class="form-group mb-6">
                <label for="motor-number" class="form-label inline-block mb-2 text-gray-700">رقم الموتور</label>
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
      ease-in-out mr-2">Save
            </button>

            <JetSecondaryButton @click="close">
                {{ __('Close') }}
            </JetSecondaryButton>
        </template>

    </JetDialogModal>
</template>
