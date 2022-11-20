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
            title: 'Customer Name',
            dataIndex: 'customer_name',
        },
        {
            title: 'Company',
            dataIndex: 'company_id',
        },

        {
            title: 'Brand',
            dataIndex: 'brand_id'
        },
        {
            title: 'Model',
            dataIndex: 'model_id',
        },
        {
            title: 'Created At',
            dataIndex: 'created_at',
        },
        {
            title: 'Actions',
            dataIndex: 'action',
        }
    ];


    const filterableColumns = [
        {
            key: "customer_name",
            value: "Customer Name"
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
