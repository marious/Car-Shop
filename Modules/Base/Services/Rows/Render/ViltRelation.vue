<template>
    <div class="py-2 px-2" v-if="view === 'input'">
        <label v-if="row.name" :for="row.name" class="text-sm font-normal capitalize">{{
                row.label ? row.label : row.name
            }}
            <span v-if="row.required" class="text-red-600 text-bold">*</span>
        </label>
        <multiselect
            v-model="value"
            :options="records"
            :multiple="true"
            :track-by="row.trackById"
            :label="row.trackByName"
            :disabled="row.disabled"
            :class="row.className"
            :loading="isLoading"
            :searchable="true"
            @search-change="asyncFind"
            class="mt-2"
        >
            <template #singleLabel="props">
                <div class="flex justify-start space-x-2">
                    <img class="option__image w-8" v-if="props.option.media" :src="props.option.media" alt="No Man’s Sky">
                    <span class="option__desc">
                        <span class="option__title">
                            {{ props.option.name }}
                        </span>
                        <br>
                        <span class="option__small text-sm text-gray-400" v-if="props.option.description">
                            {{ props.option.description }}
                        </span>
                    </span>
                </div>
            </template>
            <template #option="props">
                <div class="flex justify-start space-x-2">
                    <img class="option__image w-8" v-if="props.option.media" :src="props.option.media" :alt="props.option.name">
                    <div class="option__desc">
                        <span class="option__title">
                            {{ props.option.name }}
                        </span>
                        <br>
                        <span class="option__small text-sm text-gray-400" v-if="props.option.description">
                            {{ props.option.description }}
                        </span>
                    </div>
                </div>
            </template>
        </multiselect>
        <small v-if="row.hint" class="text-gray-400 mx-2">{{row.hint}}</small>
        <JetInputError :message="message" class="mt-2" />
    </div>
    <div class="flex justify-between my-4" v-if="view === 'view'">
        <div>
            <p class="font-bold capitalize">{{ row.label ? row.label: row.name }}</p>
        </div>
        <div>
            <p class="m-1 text-center bg-primary-600 text-white rounded-lg w-full" v-for="(item, key) in modelValue">{{ item[row.trackByName] }}</p>
        </div>
    </div>
    <div v-if="view === 'table'">
        <p class="m-1 text-center bg-primary-600 text-white rounded-lg w-full" v-for="(item, key) in modelValue">{{ item[row.trackByName] }}</p>
    </div>
</template>

<script>
import { defineComponent } from "vue";
import JetInputError from "@/Jetstream/InputError.vue";
import Multiselect from "@suadelabs/vue3-multiselect";
import "@suadelabs/vue3-multiselect/dist/vue3-multiselect.css";

export default defineComponent({
    components: {
        JetInputError,
        Multiselect,
    },
    data() {
        return {
            value: "",
            records: [],
            isLoading: false,
        };
    },
    beforeUpdate() {
        if (this.row.default) {
            this.value = this.row.default;
        }
    },
    mounted() {
        let _this = this;
        if(this.modelValue && this.modelValue.length){
            let ids = [];
            for (let i = 0; i < this.modelValue.length; i++) {
                ids.push(this.modelValue[i].id);
            }
            axios
                .post(route("select"), {
                    model_type: this.row.model,
                    model_id: ids,
                })
                .then((response) => {
                    _this.value = response.data.data;
                    _this.isLoading = false;
                });
        }
        this.isLoading = true;

        if (this.row.model !== null) {
            axios
                .post(route("select"), {
                    model_type: this.row.model,
                })
                .then((response) => {
                    this.records = response.data.data.data;
                    this.isLoading = false;
                });
        }
    },
    watch: {
        value(oldValue, newValue) {
            this.$emit("update:modelValue", this.value);
            this.$emit("change");
        },
    },
    methods: {
        asyncFind(query, key = null) {
            this.isLoading = true;
            let _this = this;
            if (!key) {
                key = this.row.trackByName;
            }
            axios
                .post(route("select"), {
                    model_type: this.row.model,
                    query: true,
                    key: key,
                    value: query,
                })
                .then((response) => {
                    _this.records = response.data.data.data;
                    _this.isLoading = false;
                });
        },
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
});
</script>
