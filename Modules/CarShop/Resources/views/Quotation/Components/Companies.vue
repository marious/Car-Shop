<template>
    <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="4">
        <a-select
            v-model:value="filters.company_id"
            :placeholder="__('Select Company')"
            :allowClear="true"
            style="width: 100%"
            optionFilterProp="title"
            show-search
            @change="emit('handleChange')"
        >
            <a-select-option
                v-for="company in companies"
                :key="company.id"
                :title="company.name"
                :value="company.id"
            >
                {{ company.name }}
            </a-select-option>
        </a-select>
    </a-col>
</template>

<script setup>
const props = defineProps({
   companies: Object,
   filters: Object,
});
const emit = defineEmits(['handleChange']);
</script>
