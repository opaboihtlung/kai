<template>
    <div class="q-pa-sm">
        <div class="text-lg text-weight-medium">Office wise report (Today)</div>
        <Bar v-if="!loading" :data="data" :options="options"/>
    </div>
</template>

<script setup>
import {onMounted, reactive, ref} from "vue";
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js'
import {Bar} from 'vue-chartjs'

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend)

const loading = ref(true);
const data = reactive({
    labels: [],
    datasets: []
})

const options = {
    responsive: true,
    scales: {
        x: {
            stacked: true, // Enable stacking for x-axis
        },
        y: {
            stacked: true, // Enable stacking for y-axis
        }
    }
}

onMounted(() => {
    loading.value = true;
    axios.get(route('statistic.office2'))
    .then(res => {
        const {offices} = res.data;

        const presentData = {
            label: 'Present',
            borderWidth: 2,
            borderColor: '#369',
            backgroundColor: '#4dc4ad',
            borderRadius: 16,
            data: []
        }

        const absentData = {
            label: 'Absent',
            borderWidth: 2,
            borderColor: '#5b111b',
            backgroundColor: '#9d4f5b',
            borderRadius: 16,
            data: []
        }

        const lateData = {
            label: 'Late',
            borderWidth: 2,
            borderColor: '#369',
            backgroundColor: '#f68c43',
            borderRadius: 16,
            data: []
        }

        let presents = [];
        let lates = [];
        let absents = [];

        offices.forEach((office) => {
            data.labels.push(office.name);

            let presentCount = office.attendances.reduce((acc, val) => {
                return acc + (val.type === 'present' ? 1 : 0);
            }, 0);
            presents.push(presentCount);

            let lateCount = office.attendances.reduce((acc, val) => {
                return acc + (val.type === 'late' ? 1 : 0);
            }, 0);
            lates.push(lateCount);

            absents.push(Number(office.users_count) - (Number(lateCount) + Number(presentCount)));
        });

        presentData.data = presents;
        lateData.data = lates;
        absentData.data = absents;

        data.datasets.push(presentData);
        data.datasets.push(lateData);
        data.datasets.push(absentData);

        loading.value = false;
    })
    .catch(err => {
        console.log(err);
    })
})
</script>

<style scoped>
.late {
    background-color: #bf6262;
}

.present {
    background-color: #7cb342;
}
</style>
