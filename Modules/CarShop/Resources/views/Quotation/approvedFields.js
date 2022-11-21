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
            title: 'Car Shop',
            dataIndex: 'car_shop_id',
        },
        {
            title: 'Policy Number',
            dataIndex: 'policy_num',
        },
        {
            title: 'Policy Year',
            dataIndex: 'policy_year',
        },
        {
            title: 'Approved At',
            dataIndex: 'approved_at',
        },
        {
            title: 'User',
            dataIndex: 'user_id',
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
        },
        {
            key: 'policy_num',
            value: 'Policy Number',
        },
        {
            key: 'policy_year',
            value: 'Policy Year',
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
