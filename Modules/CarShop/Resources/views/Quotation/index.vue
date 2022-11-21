<template>
    <div class="px-6 pt-2 mx-auto">
        <SectionTitleLineWithButton
            :icon="mdiBallotOutline"
            title="Quotation Requests"
            main
        >
        </SectionTitleLineWithButton>
    </div>
    <div class="px-6 pt-6 mx-auto">
        <div
            class="bg-white dark:bg-gray-800 dark:border-gray-600 rounded-lg border"
        >

            <a-card class="page-content-container">
                <a-row :gutter="[15, 15]">
                    <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="6">
                        <a-input-group compact>
                            <a-select
                                style="width: 35%"
                                v-model:value="crudVariables.table.searchColumn"
                                placeholder=""
                            >
                                <a-select-option
                                    v-for="filterableColumn in filterableColumns"
                                    :key="filterableColumn.key"
                                >
                                    {{ filterableColumn.value }}
                                </a-select-option>
                            </a-select>
                            <a-input-search
                                style="width: 65%"
                                v-model:value="crudVariables.table.searchString"
                                show-search
                                @change="crudVariables.onTableSearch"
                                @search="crudVariables.onTableSearch"
                                :loading="crudVariables.table.filterLoading"
                            />
                        </a-input-group>
                    </a-col>

                    <Companies :filters="filters" :companies="companies" @handleChange="setUrlData"/>
                    <CarBrands :filters="filters" :brands="brands" @handleChange="setUrlData"/>
                    <CarModels :filters="filters" :carModels="carModels" @handleChange="setUrlData"/>
                    <CarShop :filters="filters" :carShops="carShops" @handleChange="setUrlData"/>

                    <a-col :xs="24" :sm="24" :md="8" :lg="6" :xl="6">
                        <DateRangePicker
                            @dateTimeChanged="
						(changedDateTime) => {(rangDates = changedDateTime)}
					"
                        />
                    </a-col>
                </a-row>
            </a-card>

            <a-row>
                <a-col :span="24">
                    <div class="table-responsive">
                        <a-table
                            :columns="columns"
                            :row-key="(record) => record.xid"
                            :data-source="crudVariables.table.data"
                            :pagination="crudVariables.table.pagination"
                            :loading="crudVariables.table.loading"
                            @change="crudVariables.handleTableChange"
                            bordered
                        >
                            <template #bodyCell="{column, text, record}">
                                <template v-if="column.dataIndex === 'company_id'">
                                    {{ record.company ? record.company.name.en : "-" }}
                                </template>

                                <template v-if="column.dataIndex === 'brand_id'">
                                    {{ record.brand ? record.brand.name.en : "-" }}
                                </template>

                                <template v-if="column.dataIndex === 'model_id'">
                                    {{ record.model ? record.model.name.en : "-" }}
                                </template>
                                <template v-if="column.dataIndex === 'car_shop_id'">
                                    {{ record.car_shop ? record.car_shop.name.en : "-" }}
                                </template>
                                <template v-if="column.dataIndex === 'user_id'">
                                    {{ record.user ? record.user.name : "-" }}
                                </template>

                                <template v-if="column.dataIndex === 'created_at'">
                                    {{ formatDate(record.create_at, 'YYYY-MM-DD') }}
                                </template>

                                <template v-if="column.dataIndex === 'action'">
                                    <Link
                                        class="inline-flex items-center justify-center text-sm font-normal filament-tables-link text-warning-700 hover:text-warning-600 filament-tables-link-action"
                                        :href="route('quotations.show', record.id)"
                                    >
                                        <i
                                            class="bx bx-show text-[16px]"
                                        ></i>
                                        <div class="table_tooltip">
                                            View
                                        </div>
                                    </Link>


                                </template>
                            </template>

                        </a-table>
                    </div>
                </a-col>
            </a-row>

        </div>
    </div>
</template>

<script setup>
import fields from './fields';
import crud from './crud';
import common from "./common";
import {onMounted, ref, watch} from "vue";
import DateRangePicker from "./DateRangePicker.vue";
import '../../../../../public/assets/css/antd.css';
import CarBrands from "./Components/CarBrands.vue";
import Companies from "./Components/Companies.vue";
import CarModels from "./Components/CarModels.vue";
import CarShop from "./Components/CarShop.vue";
import SectionTitleLineWithButton from "@/Components/SectionTitleLineWithButton.vue";


const {
    addEditUrl,
    initData,
    columns,
    filterableColumns,
    hashableColumns,
    multiDimensalObjectColumns,
} = fields();

const crudVariables = crud();
const {formatDate} = common();

const searchDateRangePicker = ref(null);

const filters = ref({
    company_id: undefined,
});

const rangDates = ref([]);

const companies = ref([]);
const brands = ref([]);
const carModels = ref([]);
const carShops = ref([]);

onMounted(() => {
    getInitialData();
    setUrlData();

    crudVariables.initData.value = {...initData};
    crudVariables.formData.value = {...initData};
    crudVariables.hashableColumns.value = [...hashableColumns];
    crudVariables.multiDimensalObjectColumns.value = {
        ...multiDimensalObjectColumns,
    };
});

const setUrlData = () => {
    crudVariables.tableUrl.value = {
        url:
            'quotationsdata?fields=customer_name,created_at,company_id,company{id,name},policy_num,policy_year,approved_at,brand_id,brand{id,name},' +
            'model_id,model{id,name},carShop{id,name},user{name}',
        filters,
        extraFilters: {
            dates: rangDates.value
        },
    };
    crudVariables.table.filterableColumns = filterableColumns;
    crudVariables.fetch({
        page: 1,
    });
};

const getInitialData = () => {
    const companiesPromise = axios.get(route('api.companies.index') + '?limit=1000');
    const brandsPromise = axios.get(route('api.car-brands.index') + '?limit=1000');
    const modelsPromise = axios.get(route('api.car-models.index') + '?limit=1000');
    const carShopsPromise = axios.get(route('api.car-shops.index') + '?limit=1000');

    Promise.all([companiesPromise, brandsPromise, modelsPromise, carShopsPromise]).then(
        ([companiesResponse, brandsResponse, modelsResponse, carShopsResponse]) => {
            companies.value = companiesResponse.data.data;
            brands.value = brandsResponse.data.data;
            carModels.value = modelsResponse.data.data;
            carShops.value = carShopsResponse.data.data;
        }
    );
};
watch(filters.dates, (newVal, oldVal) => {
    setUrlData();
});

</script>

<script>
import ResourceTableLayout from "@@/Layouts/ResourceTableLayout.vue";

export default {
    layout: ResourceTableLayout,
};
</script>

<style>
[type='text']:focus, [type='email']:focus, [type='url']:focus, [type='password']:focus, [type='number']:focus,
[type='date']:focus, [type='datetime-local']:focus, [type='month']:focus, [type='search']:focus, [type='tel']:focus,
[type='time']:focus, [type='week']:focus, [multiple]:focus, textarea:focus, select:focus {
    box-shadow: none !important;
}
</style>
