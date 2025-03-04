<template>
    <div class="q-pa-sm">
        <div class="text-lg text-weight-medium">User-wise report(Current-Week)</div>
        <Bar v-if="!loading" :data="data" :options="options"/>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from "vue";
import axios from "axios";

import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    BarElement,
    CategoryScale,
    LinearScale
} from 'chart.js';
import { Bar } from 'vue-chartjs';

ChartJS.register(CategoryScale, LinearScale, BarElement, Title, Tooltip, Legend);

const loading = ref(true);
const data = reactive({
    labels: [],
    datasets: []
});

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
};

onMounted(() => {
    loading.value = true;

    // Get today's date
    const today = new Date();
    const dayOfWeek = today.getDay(); // Get the current day of the week (0 = Sunday, 1 = Monday, etc.)

    // Calculate the start of the week (Monday)
    const startOfWeek = new Date(today);
    startOfWeek.setDate(today.getDate() - (dayOfWeek === 0 ? 6 : dayOfWeek - 1));

    // Format the dates to 'YYYY-MM-DD'
    const from = startOfWeek.toISOString().split('T')[0]; // Start of the week (Monday)
    const to = today.toISOString().split('T')[0]; // Today's date

    axios.get(route('statistic.user'), { params: { from, to } })
        .then(res => {
            const { users } = res.data;

            const presentData = {
                label: 'Present',
                borderWidth: 2,
                borderColor: '#369',
                backgroundColor: '#4dc4ad',
                borderRadius: 16,
                data: []
            };

            // const absentData = {
            //     label: 'Absent',
            //     borderWidth: 2,
            //     borderColor: '#5b111b',
            //     backgroundColor: '#9d4f5b',
            //     borderRadius: 16,
            //     data: []
            // };

            const lateData = {
                label: 'Late',
                borderWidth: 2,
                borderColor: '#369',
                backgroundColor: '#f68c43',
                borderRadius: 16,
                data: []
            };

            users.forEach((user) => {
                data.labels.push(user.full_name);

                // Using the user data to calculate present, late, and absent counts
                let presentCount = user.present_count || 0;
                let lateCount = user.late_count || 0;
                // let absentCount = user.total_count - (presentCount + lateCount);

                presentData.data.push(presentCount);
                lateData.data.push(lateCount);
                // absentData.data.push(absentCount > 0 ? absentCount : 0);
            });

            data.datasets.push(presentData);
            data.datasets.push(lateData);
            // data.datasets.push(absentData);

            loading.value = false;
        })
        .catch(err => {
            console.error(err);
        });
});
</script>

<style scoped>
.late {
    background-color: #bf6262;
}

.present {
    background-color: #7cb342;
}
</style>
