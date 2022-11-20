<script setup>
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import InputText from 'primevue/inputtext';
import Calendar from 'primevue/calendar';
import JetInputError from "@/Jetstream/InputError.vue";
import {useTrans} from "$/Composables/useTrans";
import {ref} from 'vue';
import {useForm} from "@inertiajs/inertia-vue3";

let props = defineProps({
    data: Object,
    showModal: false,
    title: '',
});

let { trans } = useTrans();

const emit = defineEmits(['closeModal']);
const policyNum = ref('');
const year = ref('');
const companyId = props.data.company_id;

const form = useForm({
    year,
   policyNum,
    companyId
});


const submit = (e) => {
    e.preventDefault();

    form.post(route('quotations.update', props.data.id), {
        onSuccess: () => {
            form.reset();
            emit('successSaveLicence', );
            emit('closeModal');
        },
    });
};

</script>
<template>
    <JetDialogModal :show="showModal" @end="close">
        <template #title>
            {{ title }}
            <hr class="my-4" />
        </template>
        <template #content>
            <div class="form-group mb-6">
                <label for="policyNum" class="form-label inline-block mb-2 text-gray-700">رقم الوثيقة</label>
                <InputText type="text" v-model="policyNum" class="form-control block w-full" id="policyNum"/>
                <jet-input-error
                    class="mt-2"
                    :message="form.errors['policyNum']"
                />
            </div>
            <div class="form-group mb-6">
                <label for="year" class="form-label inline-block mb-2 text-gray-700">سنة الوثيقة</label>
                <Calendar v-model="year" view="year" class="form-control block w-full"  dateFormat="yy" />

                <jet-input-error
                    class="mt-2"
                    :message="form.errors['year']"
                />
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
      ease-in-out mr-2">Sbumit
            </button>
            <JetSecondaryButton @click="emit('closeModal')">
                {{ trans('global.close') }}
            </JetSecondaryButton>
        </template>
    </JetDialogModal>
</template>
