<template>
    <div>
        <div class="text-lg text-weight-medium">Your Attendance Record (Total)</div>
        <Doughnut v-if="!loading" :data="data" :options="options" />
    </div>
</template>
<script setup>
import {onMounted,ref, reactive} from "vue";
import { Chart as ChartJS, ArcElement, Tooltip, Legend } from 'chart.js'
import { Doughnut } from 'vue-chartjs'
import { usePage } from "@inertiajs/vue3";

const page= usePage();

ChartJS.register(ArcElement, Tooltip, Legend)

const loading = ref(true);
const options = {
    responsive: true,
}
// user_id
const data = reactive({
    labels: ['Present', 'Late'],
    datasets: [
        {
            backgroundColor: ['#41B883', '#f68c43'],
            data: []
        }
    ]
})
onMounted(()=>{
    loading.value = true;
    console.log(page.props.user.id);

    axios.get(route('statistic.userattendance', page.props.user.id))
    .then(res=>{
        const {count_present,count_late}=res.data
        const temp = [count_present, count_late];
        data.datasets[0].data.push(...temp)
        loading.value = false;
    })
    .catch(err=>{
        console.log(err)
    })

})
</script>
