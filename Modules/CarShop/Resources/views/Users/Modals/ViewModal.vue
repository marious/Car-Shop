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
                    <div>
                        <p class="font-bold">{{ __("Name") }}</p>
                    </div>
                    <div>
                        <p>{{ data.name }}</p>
                    </div>
                </div>
                <div class="flex justify-between my-4">
                    <div>
                        <p class="font-bold">{{ __("Email") }}</p>
                    </div>
                    <div>
                        <p>{{ data.email }}</p>
                    </div>
                </div>
                <div class="flex justify-between my-4">
                    <div>
                        <p class="font-bold">{{ __("Phone") }}</p>
                    </div>
                    <div>
                        <p>{{ data.phone }}</p>
                    </div>
                </div>
                <div class="flex justify-between my-4">
                    <div>
                        <p class="font-bold">{{ __("User Type") }}</p>
                    </div>
                    <div>
                        <p>{{ data.user_type == 1 ? __('Car Shop Admin') : __('Sales') }}</p>
                    </div>
                </div>
                <div class="flex justify-between my-4">
                    <div>
                        <p class="font-bold">{{ __("Car Shop") }}</p>
                    </div>
                    <div>
                        <p>{{ data.carShop.name }}</p>
                    </div>
                </div>
                <div class="flex justify-between my-4">
                    <div>
                        <p class="font-bold">{{ __("Is Active") }}</p>
                    </div>
                    <div>
                        <div
                            v-if="data.is_active"
                            class="w-10 h-10 p-2 text-lg text-center text-white bg-green-500 rounded-full"
                        >
                            <i class="bx bx-check"></i>
                        </div>
                        <div
                            v-else
                            class="w-10 h-10 p-2 text-lg text-center text-white rounded-full bg-danger-500"
                        >
                            <i class="bx bx-x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </template>
        <template #footer>
            <slot></slot>
            <JetSecondaryButton @click="emit('closeModal')">
                {{ __("Close") }}
            </JetSecondaryButton>
        </template>
    </JetDialogModal>
</template>
