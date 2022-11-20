<script setup>
import JetDialogModal from "@/Jetstream/DialogModal.vue";
import JetSecondaryButton from "@/Jetstream/SecondaryButton.vue";
import { useTrans } from "$/Composables/useTrans";
const emit = defineEmits(["close", "delete"]);

defineProps({
    showModal: Boolean,
});

let { trans } = useTrans();
</script>
<template>
    <JetDialogModal :show="showModal" @end="close()">
        <template #content>
            <div class="text-center">
                <h1 class="py-4 text-lg font-bold text-red-500">
                    {{ trans("global.delete") }}
                </h1>
                <h3 class="text-gray-400 text-center">
                    {{ trans("global.delete.message") }}
                </h3>
            </div>
        </template>

        <template #footer>
            <button
                class="inline-flex items-center justify-center px-4 mr-3 font-normal tracking-tight text-white transition-colors border border-transparent rounded-lg shadow focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 focus:ring-white bg-danger-600 hover:bg-danger-500 focus:bg-danger-700 focus:ring-offset-danger-700 filament-page-button-action"
                @click.prevent="emit('delete')"
            >
                Delete
            </button>
            <JetSecondaryButton @click="emit('close')">
                Close
            </JetSecondaryButton>
        </template>
    </JetDialogModal>
</template>
