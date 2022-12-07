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
          title: __('User'),
          dataIndex: 'user_id'
        },
        {
            title: __('Created At'),
            dataIndex: 'created_at',
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
