<template>
    <div class="py-2 px-2" v-if="view === 'input'">
        <label v-if="row.name" :for="row.name" class="text-sm font-normal capitalize">{{
                row.label ? row.label : row.name
            }}
            <span v-if="row.required" class="text-red-600 text-bold">*</span>
        </label>
        <VueTelInput
            :disabled="row.disabled"
            v-model="value"
            @input="updateData"
            class="mt-2"
            :inputOptions="{
                    placeholder: row.placeholder,
                    name: row.name,
                    id: row.name,
                    styleClasses: 'text-sm py-3  rounded-default  dark:border-gray-700 dark:text-gray-400 dark:bg-gray-800',
                }"
            :value="value"
        />
        <small v-if="row.hint" class="text-gray-400 mx-2">{{row.hint}}</small>
        <JetInputError :message="message" class="mt-2" />
    </div>
    <div  v-if="view === 'view'" class="flex justify-between my-4" >
        <div>
            <p class="font-bold capitalize">{{ row.label ? row.label: row.name }}</p>
        </div>
        <div>
            <p>{{ modelValue }}</p>
        </div>
    </div>
    <div v-if="view === 'table'">
        <p class="bg-main-500 text-main-200 py-2 px-2">{{ modelValue }}</p>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import JetInputError from "@/Jetstream/InputError.vue";
import { VueTelInput } from "vue3-tel-input";
import "vue3-tel-input/dist/vue3-tel-input.css";

export default defineComponent({
    components: {
        JetInputError,
        VueTelInput,
    },
    data() {
        return {
            value: "",
        };
    },
    mounted() {
        if(this.row.default){
            this.value = this.row.default
        }
        if (this.modelValue) {
            this.value = this.modelValue;
        }
    },
    props: {
        modelValue: {},
        row: {
            Object,
            default: {},
        },
        view: {
            String,
            default: "input",
        },
        message: {
            String,
            default: null,
        },
    },
    methods: {
        updateData(number, phoneObject) {
            if (phoneObject) {
                this.value = phoneObject.number;
                this.$emit("update:modelValue", phoneObject.number);
            }
        },
    },
});
</script>
<style>
.vue-tel-input{
    border-color: #C8C8C8;
}
.dark .vti__dropdown:hover {
    background-color: #111010;
}
.dark .vti__dropdown-list{
    background-color: #1f2937;
    border: 1px solid #1f2937;
}
.dark .vti__dropdown-item.highlighted {
    background-color: #000;
}
</style>
