<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import { useTrans } from "$/Composables/useTrans";

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
                    <div><p class="font-bold">Brand</p></div>
                    <div>
                        <p>{{ data.brand.name }}</p>
                    </div>
                </div>

                <div class="flex justify-between my-4">
                    <div><p class="font-bold">Model</p></div>
                    <div>
                        <div style="display: flex; flex-wrap: wrap; justify-content: start">
                            <span
                                v-for="model in data.models"
                                :key="model.id"
                                class="text-xs mt-2 mb-2 py-1 px-2.5 text-center whitespace-nowrap font-bold bg-blue-600 text-white rounded mr-2 ml-2"
                            >
                                {{ model.name }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <slot></slot>
            <JetSecondaryButton @click="emit('closeModal')">
                {{ trans("global.close") }}
            </JetSecondaryButton>
        </template>
    </JetDialogModal>
</template>
