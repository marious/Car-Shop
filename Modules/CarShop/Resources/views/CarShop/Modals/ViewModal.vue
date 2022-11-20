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
                    <div><p class="font-bold">Name</p></div>
                    <div>
                        <p>{{ data.name }}</p>
                    </div>
                </div>

                <div class="flex justify-between my-4">
                    <div><p class="font-bold">Commission</p></div>
                    <div>
                        <p>{{ data.commission }}</p>
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
