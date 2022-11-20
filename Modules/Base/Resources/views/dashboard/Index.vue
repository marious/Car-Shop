<script setup>
import { Head } from '@inertiajs/inertia-vue3'
import { computed, ref, onMounted } from "vue";
import { useMainStore } from "@/Stores/main";
import Chart from 'primevue/chart';
import SectionMain from '@/Components/SectionMain.vue'
import {
    mdiAccountMultiple,
    mdiCartOutline,
    mdiChartTimelineVariant,
    mdiMonitorCellphone,
    mdiReload,
    mdiGithub,
    mdiChartPie,
} from "@mdi/js";


const props = defineProps({
    quotationEntered: Array,
    accidentEntered: Array,
    isAdmin: Boolean,
});



const basicData = ref({
    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October',
        'November', 'December'],
    datasets: [
        {
            label: 'Quotations',
            backgroundColor: '#42A5F5',
            data: props.quotationEntered,
        },
        {
            label: 'Accident Report',
            backgroundColor: '#FFA726',
            data: props.accidentEntered
        }
    ]
})

</script>
<script>
import ResourceTableLayout from '@@/Layouts/ResourceTableLayout.vue';

export default {
    layout: ResourceTableLayout
}
</script>

<template>
    <SectionMain>
        <Head title="Dashboard" />
        <div class="grid grid-cols-1 gap-6 lg:grid-cols-3 mb-6">
           <h1 class="text-xl">Welcome In MK System</h1>
        </div>
        <div v-if="isAdmin">
            <div class="card">
                <Chart type="bar" :data="basicData" :options="basicOptions" />
            </div>
        </div>

    </SectionMain>
</template>
