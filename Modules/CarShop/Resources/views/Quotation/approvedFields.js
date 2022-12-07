import {translations} from "$/Mixins/translations";

const __ = translations.methods.__;

const fields = () => {

    const addEditUrl = 'quotations';
    const hashableColumns = [];
    const multiDimensalObjectColumns = {};

    const initData = {};

    const columns = [
        {
            title: '#',
            dataIndex: 'id',
        },
        {
            title: __('Customer Name'),
            dataIndex: 'customer_name',
        },
        {
            title: __('Company'),
            dataIndex: 'company_id',
        },
        {
            title: __('Brand'),
            dataIndex: 'brand_id'
        },
        {
            title: __('Model'),
            dataIndex: 'model_id',
        },
        {
            title: __('Car Shop'),
            dataIndex: 'car_shop_id',
        },
        {
            title: __('Policy Number'),
            dataIndex: 'policy_num',
        },
        {
            title: __('Policy Year'),
            dataIndex: 'policy_year',
        },
        {
            title: __('Approved At'),
            dataIndex: 'approved_at',
        },
        {
            title: __('User'),
            dataIndex: 'user_id',
        },
        {
            title: __('Actions'),
            dataIndex: 'action',
        }
    ];


    const filterableColumns = [
        {
            key: "customer_name",
            value: __('Customer Name')
        },
        {
            key: 'policy_num',
            value: __('Policy Number'),
        },
        {
            key: 'policy_year',
            value: __('Policy Year'),
        }
    ];

    return {
        addEditUrl,
        initData,
        filterableColumns,
        hashableColumns,
        multiDimensalObjectColumns,
        columns,
    }
}

export default fields;
