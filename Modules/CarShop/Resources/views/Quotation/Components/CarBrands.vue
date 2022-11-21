<template>
    <a-col :xs="24" :sm="24" :md="8" :lg="5" :xl="3">
        <a-select
            v-model:value="filters.brand_id"
            :placeholder="__('Select Brand')"
            :allowClear="true"
            style="width: 100%"
            optionFilterProp="title"
            show-search
            @change="emit('handleChange')"
        >
            <a-select-option
                v-for="brand in brands"
                :key="brand.id"
                :title="brand.name"
                :value="brand.id"
            >
                {{ brand.name }}
            </a-select-option>
        </a-select>
    </a-col>
</template>

<script setup>
const props = defineProps({
    filters: Object,
    brands: Object
})

const emit = defineEmits(['handleChange'])
</script>

