<script setup>
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue';
import {useTrans} from "$/Composables/useTrans";

let props = defineProps({
    data: Object,
    showModal: false,
    title: '',
});

const emit = defineEmits(['closeModal']);

let { trans } = useTrans();
</script>
<template>
    <JetDialogModal :show="showModal" @end="close">
        <template #title>
            {{ title }}
            <hr class="my-4" />
        </template>
        <template #content>
            <div class="print_area">
                <div class="flex justify-between my-4">
                    <div><p class="font-bold">Company</p></div>
                    <div>
                        <p>{{ data.company.name }}</p>
                    </div>
                </div>

                <div class="flex justify-between my-4">
                    <div><p class="font-bold">Fee</p></div>
                    <div>
                        <p>{{ data.fee.name }}</p>
                    </div>
                </div>

                <div class="flex justify-between my-4">
                    <div><p class="font-bold">Fee Amount</p></div>
                    <div>
                        <p>{{ data.fees_amount }}</p>
                    </div>
                </div>

                <div class="flex justify-between my-4">
                    <div><p class="font-bold">Is Percent</p></div>
                    <div>
                        <p>{{ data.is_percent }}</p>
                    </div>
                </div>

            </div>
        </template>
        <template #footer>
            <slot></slot>
            <JetSecondaryButton @click="emit('closeModal')">
                {{ trans('global.close') }}
            </JetSecondaryButton>
        </template>
    </JetDialogModal>
</template>
