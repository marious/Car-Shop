<template>
    <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="4">
        <a-select
            v-model:value="filters.model_id"
            :placeholder="__('Select Model')"
            :allowClear="true"
            style="width: 100%"
            optionFilterProp="title"
            show-search
            @change="emit('handleChange')"
        >
            <a-select-option
                v-for="model in carModels"
                :key="model.id"
                :title="model.name"
                :value="model.id"
            >
                {{ model.name }}
            </a-select-option>
        </a-select>
    </a-col>
</template>

<script setup>
const props = defineProps({
    filters: Object,
    carModels: Object
})

const emit = defineEmits(['handleChange'])
</script>

