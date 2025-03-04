<template>
    <q-date :event-color="eventColorFn" :events="eventFn" minimal  @navigation="navigate" class="q-mt-sm" flat/>
</template>
<script setup>

import {onMounted, reactive} from "vue";
import {date} from "quasar";

const state=reactive({
    events: [],
    holidays:[
        '2024/01/01',
        '2024/01/02',
        '2024/01/11',
        '2024/01/26',
        '2024/02/20',
        '2024/03/01',
        '2024/03/25',
        '2024/03/29',
        '2024/04/11',
        '2024/05/23',
        '2024/06/15',
        '2024/06/17',
        '2024/07/06',
        '2024/07/17',
        '2024/08/15',
        '2024/09/16',
        '2024/10/02',
        '2024/10/12',
        '2024/10/31',
        '2024/11/15',
        '2024/12/24',
        '2024/12/25',
        '2024/12/26',
        '2024/12/31',

    ],
    attendances : []
})

const eventColorFn=val=>{
    const attendance=state.attendances.find(item=>{
        return date.formatDate(item?.signin_at, 'YYYY/MM/DD') === val;
    })
    const isHoliday = state.holidays.includes(val);
    if (attendance) {
        return attendance.type==='present'?'positive':'warning'
    }else if(isHoliday){
        return 'red';
    }

    else{
        return false;
    }
}
const navigate=view=>{
    const {year, month} = view;
    fetchUserAttendances(year,month)
}
// const eventFn=val=>{
//     const currDate=date.extractDate(val,'YYYY/MM/DD')
//     if (currDate.getDay() === 6 || currDate.getDay()===0) {
//         state.holidays.push(currDate)
//         return false;
//     }
//     if (currDate.getTime() > Date.now()) {
//         return false;
//     }
//     return true;

// }
const eventFn = val => {
    const currDate = date.extractDate(val, 'YYYY/MM/DD');
    if (currDate.getDay() === 6 || currDate.getDay() === 0) {
        return true;
    }
    const isHoliday = state.holidays.includes(val);
    if (isHoliday) {
        return true;
    }
    if (currDate.getTime() > Date.now()) {
        return false;
    }
    return true;
};

onMounted(()=>{
   fetchUserAttendances()
})
const fetchUserAttendances=(year,month)=>{
    axios.get(route('misc.attendances'),{
        params:{
            year,month
        }
    }).then(res=>{
            const {list} = res.data;
            state.attendances = list;
            state.events = list.map(item=>date.formatDate(item?.signin_at,'YYYY/MM/DD'));
        })
        .catch(err=>console.log(err))
}
</script>
