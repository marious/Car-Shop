<template>
    <a-col :xs="24" :sm="24" :md="8" :lg="5" :xl="3">
        <a-select
            v-model:value="filters.car_shop_id"
            :placeholder="__('Select Car Shop')"
            :allowClear="true"
            style="width: 100%"
            optionFilterProp="title"
            show-search
            @change="emit('handleChange')"
        >
            <a-select-option
                v-for="carShop in carShops"
                :key="carShop.id"
                :title="carShop.name"
                :value="carShop.id"
            >
                {{ carShop.name }}
            </a-select-option>
        </a-select>
    </a-col>
</template>

<script setup>
const props = defineProps({
    filters: Object,
    carShops: Object
})

const emit = defineEmits(['handleChange'])
</script>

