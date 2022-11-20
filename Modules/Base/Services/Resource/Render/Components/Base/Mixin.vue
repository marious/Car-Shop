<template></template>
<script>
import { defineComponent } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Link } from '@inertiajs/inertia-vue3';
import Filters from '@@/Components/Base/Filters.vue';
import Header from '@@/Components/Header.vue';
import Bulk from '@/Components/Base/Bulk.vue';
import List from '@@/Components/Base/Table.vue';
import Pagination from '@@/Components/Base/Pagination.vue';
import CreateModal from '@/Components/Base/Modals/Create.vue';
import ViewModal from '@/Components/Base/Modals/View.vue';
import DeleteModal from '@/Components/Base/Modals/Delete.vue';
import BulkModal from '@/Components/Base/Modals/Bulk.vue';

export default defineComponent({
    components: {
        AppLayout,
        Link,
        Filters,
        Header,
        Bulk,
        List,
        Pagination,
        CreateModal,
        ViewModal,
        DeleteModal,
        BulkModal,
    },
    props: {
        rows: Array,
        collection: Object,
    },
    mounted() {
        if (this.$attrs.desc === 'desc') {
            this.desc = false;
        } else {
            this.desc = true;
        }
        this.last_page = this.collection.last_page;
        this.filters = this.$attrs.filters;
        this.createModal = this.$attrs.create;
    },
    computed: {
        getMessage() {
            return this.$page.props.data.message;
        },
    },
    methods: {
        transItem(item, key) {
            if (
                item[key] &&
                item[key].hasOwnProperty('ar') &&
                item[key].hasOwnProperty('en')
            ) {
                if (localStorage.getItem('lang')) {
                    let lang = JSON.parse(localStorage.getItem('lang'));
                    if (lang.id === 'ar') {
                        return item[key].en;
                    } else if (lang.id === 'en') {
                        return item[key].ar;
                    }
                }
            } else {
                return item[key];
            }
        },
        trans(key) {
            return this.lang[key] ? this.lang[key] : key;
        },
        resetFilter() {
            this.reload(1);
        },
        viewItem(item) {
            axios.get(route(this.url + '.show', item.id)).then((response) => {
                this.form = this.$inertia.form(response.data.data);
                this.viewModal = true;
            });
        },
        editItem(item) {
            this.form.reset();
            axios.get(route(this.url + '.show', item.id)).then((response) => {
                this.form = this.$inertia.form(response.data.data);
                this.createModal = true;
                this.edit = true;
            });
        },
        deleteItem(item) {
            this.form = this.$inertia.form(item);
            this.deleteModal = true;
        },
        bulkAction(action) {
            this.bulkActionTitle = action;
            this.bulkModal = true;
            this.showBluk = false;
        },
        bulkAll(value) {
            if (!value) {
                this.bulk = {};
            } else {
                for (let i = 0; i < this.collection.data.length; i++) {
                    this.bulk[this.collection.data[i].id] = true;
                }
            }
        },
        applyFilters(name) {
            this.reload(1, 'filters', null, false, name);
        },
        resetFilters() {
            this.filters = [];
            this.reload();
        },
        success() {
            if (typeof this.getMessage === 'object') {
                if (this.getMessage.type === 'error') {
                    this.$toast.error(this.getMessage.message, {
                        position: 'top',
                        style: {
                            background: 'rgba(210, 45, 61, .8)',
                            'border-radius': '0.25rem',
                        },
                    });
                } else if (this.getMessage.type === 'success') {
                    this.$toast.success(this.getMessage.message, {
                        position: 'top',
                        style: {
                            background: '#7e3af2',
                            'border-radius': '0.25rem',
                        },
                    });
                }
            } else {
                this.$toast.success(this.getMessage, {
                    position: 'top',
                    style: {
                        background: '#7e3af2',
                        'border-radius': '0.25rem',
                    },
                });
            }

            this.edit = false;
            this.createModal = false;
            this.deleteModal = false;
            this.reload(1, 'orderBy', 'id', 'desc');
        },
        switchBulk(id) {
            if (this.bulk.hasOwnProperty(id)) {
                delete this.bulk[id];
            } else {
                this.bulk[id] = true;
            }
        },
    },
});
</script>
