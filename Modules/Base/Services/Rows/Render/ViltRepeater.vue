<template>
    <div class="py-2 px-2" v-if="view === 'input'">
        <label v-if="row.name" :for="row.name" class="text-sm font-normal capitalize">{{
                row.label ? row.label : row.name
            }}
            <span v-if="row.required" class="text-red-600 text-bold">*</span>
        </label>

        <div>
            <div
                class="p-4 my-4 border rounded-lg"
                v-for="(value, index) in main"
                :key="index"
            >
                <div class="flex justify-end">
                    <button
                        @click.prevent="removeItem(value)"
                        class="text-danger-500"
                    >
                        <i class="bx bx-trash"></i>
                    </button>
                </div>
                <div v-for="(item, key) in row.options" :key="key">
                    <ViltText v-if="item.vue === 'ViltText.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltEmail v-if="item.vue === 'ViltEmail.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltTel v-if="item.vue === 'ViltTel.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltTextArea v-if="item.vue === 'ViltTextArea.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltNumber v-if="item.vue === 'ViltNumber.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltSelect v-if="item.vue === 'ViltSelect.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltSwitch v-if="item.vue === 'ViltSwitch.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltColor v-if="item.vue === 'ViltColor.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltDate v-if="item.vue === 'ViltDate.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltDateTime v-if="item.vue === 'ViltDateTime.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltTime v-if="item.vue === 'ViltTime.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                    <ViltMedia v-if="item.vue === 'ViltMedia.vue'" :row="item" v-model="main[index][item.name]" @update:modelValue="update"/>
                </div>
            </div>
            <button
                @click.prevent="addItem()"
                class="inline-flex items-center justify-center px-4 font-medium tracking-tight text-white transition-colors border border-transparent rounded-lg shadow focus:outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset filament-button dark:focus:ring-offset-0 h-9 focus:ring-white bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action"
            >
                Add New Item
            </button>
        </div>
        <small v-if="row.hint" class="text-gray-400 mx-2">{{row.hint}}</small>
        <JetInputError v-if="message" :message="message" class="mt-2" />
    </div>

    <div class="flex justify-between my-4" v-if="view === 'view'">
        <div>
            <p class="font-bold capitalize">{{ row.label ? row.label: row.name }}</p>
        </div>
        <div>
            <p>{{ value[row.trackById] }}</p>
        </div>
    </div>
    <div v-if="view === 'table'">
        <p>{{ value[row.trackById] }}</p>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import JetInputError from "@/Jetstream/InputError.vue";
import ViltText from '$$/ViltText.vue'
import ViltTel from '$$/ViltTel.vue'
import ViltTextArea from "$$/ViltTextArea.vue";
import ViltNumber from "$$/ViltNumber.vue";
import ViltSelect from "$$/ViltSelect.vue";
import ViltSwitch from "$$/ViltSwitch.vue";
import ViltColor from "$$/ViltColor.vue";
import ViltEmail from "$$/ViltEmail.vue";
import ViltDate from "$$/ViltDate.vue";
import ViltDateTime from "$$/ViltDateTime.vue";
import ViltTime from "$$/ViltTime.vue";
import ViltMedia from "$$/ViltMedia.vue";

export default defineComponent({
    components: {
        JetInputError,
        ViltTextArea,
        ViltText,
        ViltTel,
        ViltNumber,
        ViltSelect,
        ViltSwitch,
        ViltColor,
        ViltEmail,
        ViltDate,
        ViltDateTime,
        ViltTime,
        ViltMedia,
    },
    data() {
        return {
            main: [],
        };
    },
    mounted() {
        let rows = this.optionRows;
        let JSONRows = JSON.stringify(rows);
        this.main.push(JSON.parse(JSONRows));

        if (this.row.default) {
            this.main = this.row.default;
        }
        if (this.modelValue) {
            this.main = this.modelValue;
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
    computed:{
        optionRows(){
            let rows = {};
            for(let i=0; i<this.row.options.length; i++){
                if(this.row.options[i].default){
                    rows[this.row.options[i].name] = this.row.options[i].default;
                }
                else {
                    if(this.row.options[i].vue === 'ViltSwitch.vue'){
                        rows[this.row.options[i].name] = false;
                    }
                    else if(this.row.options[i].vue === 'ViltColor.vue'){
                        rows[this.row.options[i].name] = "#000000";
                    }
                    else {
                        rows[this.row.options[i].name] = "";
                    }
                }
            }
            return rows;
        }

    },
    methods: {
        addItem() {
            let lastItem = this.main[this.main.length - 1];
            for(let i=0; i<this.row.options.length; i++){
                if(this.row.options[i].required){
                    if(!lastItem[this.row.options[i].name]){
                        this.$toast.error(this.row.options[i].label ? this.row.options[i].label : this.row.options[i].name + " is required", {
                            position: "top",
                            style: {
                                background: "#d41717",
                                "border-radius": "0.25rem",
                            },
                        });
                        return;
                    }
                }
            }

            let rows = this.optionRows;
            let JSONRows = JSON.stringify(rows);
            this.main.push(JSON.parse(JSONRows));
            this.$emit("update:modelValue", this.main);
        },
        removeItem(value) {
            this.main.splice(this.main.indexOf(value), 1);
            this.$emit("update:modelValue", this.main);
        },
        update() {
            this.$emit("update:modelValue", this.main);
        },
    },
});
</script>
