<template>
    <a-range-picker
        v-model:value="dateRangeValue"
        format="YYYY-MM-DD"
        :placeholder="['Start Date', 'End Date']"
        style="width: 100%"
        @change="emit('dateChange')"
    />
</template>

<script setup>
import {ref, onMounted} from "vue";
import common from "./common";

const props = defineProps({
    dateRange: {
        default: [],
    },
});

const emit = defineEmits(["dateChange"]);
const dateRangeValue = ref([]);
const {dayjs} = common();

onMounted(() => {
    if (props.dateRange && props.dateRange.length > 0) {
        dateRangeValue.value = [
            dayjs(props.dateRange[0]),
            dayjs(props.dateRange[1]),
        ];
    }
});

const dateTimeChanged = (newValue) => {
    if (newValue) {
        console.log('hi', emit('dateChange'));
        // emit("dateTimeChanged", [
        //     newValue[0].startOf("day").utc().format("YYYY-MM-DD HH:mm:ss"),
        //     newValue[1].endOf("day").utc().format("YYYY-MM-DD HH:mm:ss"),
        // ]);
    } else {
        emit("dateChange", []);
    }
};


const resetPicker = () => {
    dateRangeValue.value = [];
};


</script>

<!--<script>-->
<!--import {defineComponent, onMounted, ref} from "vue";-->
<!--import common from "./common";-->

<!--export default defineComponent({-->
<!--    props: {-->
<!--        dateRange: {-->
<!--            default: [],-->
<!--        },-->
<!--    },-->
<!--    emits: ["dateTimeChanged"],-->
<!--    setup(props, {emit}) {-->
<!--        const dateRangeValue = ref([]);-->
<!--        const {dayjs} = common();-->

<!--        onMounted(() => {-->
<!--            if (props.dateRange && props.dateRange.length > 0) {-->
<!--                dateRangeValue.value = [-->
<!--                    dayjs(props.dateRange[0]),-->
<!--                    dayjs(props.dateRange[1]),-->
<!--                ];-->
<!--            }-->
<!--        });-->

<!--        const dateTimeChanged = (newValue) => {-->
<!--            if (newValue) {-->
<!--                emit("dateTimeChanged", [-->
<!--                    newValue[0].startOf("day").utc().format("YYYY-MM-DD HH:mm:ss"),-->
<!--                    newValue[1].endOf("day").utc().format("YYYY-MM-DD HH:mm:ss"),-->
<!--                ]);-->
<!--            } else {-->
<!--                emit("dateTimeChanged", []);-->
<!--            }-->
<!--        };-->

<!--        const resetPicker = () => {-->
<!--            dateRangeValue.value = [];-->
<!--        };-->

<!--        return {-->
<!--            dateRangeValue,-->
<!--            dateTimeChanged,-->
<!--            resetPicker,-->
<!--        };-->
<!--    },-->
<!--});-->
<!--</script>-->

<style>
.ant-picker-cell-inner {
    text-align: center;
}
</style>
