<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import { useTrans } from "@@/Composables/useTrans";

let props = defineProps({
    data: Object,
    showModal: false,
    title: "",
});

const emit = defineEmits(["closeModal"]);

let { trans } = useTrans();
</script>
<template>
    <JetDialogModal :show="showModal" @end="close">
        <template #title>
            <h5 class="text-gray-900 text-xl font-medium mb-2 pb-2">
                {{ __('Insurance For') }} {{ data.car_model_name }}
                {{ data.car_brand_name }}
            </h5>
            <hr class="my-4" />
        </template>
        <template #content>
            <div class="flex justify-between my-4">
                <div>
                    <p class="font-bold">{{ __("Commission") }}</p>
                </div>
                <div>
                    <p class="font-bold">{{ parseFloat(data.commission) }} EGP</p>
                </div>
            </div>
        </template>
        <template #footer>
            <slot></slot>
            <JetSecondaryButton @click="emit('closeModal')">
                {{ __('Close') }}
            </JetSecondaryButton>
        </template>
    </JetDialogModal>
</template>
