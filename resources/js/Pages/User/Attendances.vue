<template>
    <q-page class="container" padding>
        <div class="flex justify-between">
            <div>
                <div class="text-title">Record of {{user?.full_name}}</div>
            </div>

            <div style="padding-right: 25%;">
  <q-icon name="radio_button_checked" color="positive" style="margin-right: 0px;"/>  - Present
  <q-icon name="radio_button_checked" color="warning" style="margin-left: 20px;"/>  - Late
  <q-icon name="radio_button_checked" color="red" style="margin-left: 20px;"/>  - Holiday
  <q-icon name="radio_button_unchecked" color="" style="margin-left: 20px;" />  - Absent
</div>
        </div>
        <br/>
        <div class="row q-col-gutter-sm">
            <div class="col-xs-12 col-sm-4">
                <div class="shadow-default bg-white q-pa-sm">
                    <div class="flex justify-between items-center">
                        <div class="text-grey-7">Full Name</div>
                        <div class="text-grey-7 text-dark">{{user?.full_name}}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-grey-7">Designation</div>
                        <div class="text-grey-7 text-dark">{{user?.designation}}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-grey-7">Mobile</div>
                        <div class="text-grey-7 text-dark">{{user?.mobile}}</div>
                    </div>
                    <div class="flex justify-between items-center">
                        <div class="text-grey-7">Current User</div>
                        <div class="text-grey-7 text-dark">{{office?.name}}</div>
                    </div>
                </div>
                <br/>
                <div class="col-xs-12 col-sm-4">
                        <div class="bg-white q-pa-sm shadow-default">
                            <div class="flex justify-between items-center">
                                <UserPercent />
                            </div>
                        </div>
                    </div>
            </div>

            <div class="col-xs-12 col-sm-8">
                <div class="shadow-default">
                    <q-date class="full-width text-lg" style="height: 450px"
                            flat
                            :events="eventFn"
                            :title="title"
                            :subtitle="subtitle"
                            v-model="state.today"
                            today-btn
                            :event-color="eventColor"
                    />
                </div>
            </div>
        </div>
    </q-page>
</template>
<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import {computed, reactive} from "vue";
import {date} from "quasar";
import UserPercent from "@/Components/UserPercent.vue";

defineOptions({
    layout:MainLayout
})

const props = defineProps(['user','office','attendances']);
const state=reactive({
    today:date.formatDate(Date.now(),'YYYY/MM/DD'),
    // events:props.attendances.map(item=>date.formatDate(item?.signin_at,'YYYY/MM/DD')),
    holidays:[
    { date: '2024/01/01', name: 'New Year\'s Day' },
    { date: '2024/01/02', name: 'New Year\'s Celebration' },
    { date: '2024/01/11', name: 'Missionary Day' },
    { date: '2024/01/26', name: 'Republic Day' },
    { date: '2024/02/20', name: 'State Day' },
    { date: '2024/03/01', name: 'Chapchar Kut' },
    { date: '2024/03/25', name: 'Holi' },
    { date: '2024/03/26', name: 'Good Friday' },
    { date: '2024/04/11', name: 'Idu\'l Fitr' },
    { date: '2024/04/21', name: 'Mahavir jayanti' },
    { date: '2024/05/23', name: 'Buddha Purnima' },
    { date: '2024/06/15', name: 'YMA Day' },
    { date: '2024/06/17', name: 'Idul\'l Zuha' },
    { date: '2024/06/30', name: 'Remna Ni' },
    { date: '2024/07/06', name: 'MHIP Day' },
    { date: '2024/07/17', name: 'Muharram' },
    { date: '2024/08/15', name: 'Independence Day' },
    { date: '2024/09/16', name: 'Id-e-Milad' },
    { date: '2024/10/02', name: 'Mahatma Gandhi\'s Birthday' },
    { date: '2024/10/12', name: 'Dussehra' },
    { date: '2024/10/31', name: 'Diwali' },
    { date: '2024/11/15', name: 'Guru Nanak\'s Birthday' },
    { date: '2024/12/24', name: 'Christmas Eve' },
    { date: '2024/12/25', name: 'Christmas Day' },
    { date: '2024/12/26', name: 'Christmas Celebration' },
    { date: '2024/12/31', name: 'New Year\'s Eve' },
    ],
})

const eventFn = val => {
    const currDate = date.extractDate(val, 'YYYY/MM/DD');
    if (currDate.getDay() === 6 || currDate.getDay() === 0) {
        return true;
    }
    const isHoliday = state.holidays.some(holiday => holiday.date === val);
    if (isHoliday) {
        return true;
    }
    if (currDate.getTime() > Date.now()) {
        return false;
    }
    return true;
};
// const eventFn=val=> props.attendances.find(item => date.formatDate(item?.signin_at, 'YYYY/MM/DD') === val);
const eventColor = val => {
    const found=props.attendances.find(item=>date.formatDate(item?.signin_at,'YYYY/MM/DD')===val);
    const isHoliday = state.holidays.some(holiday => holiday.date === val);
    if (found) {
        return found.type==='present'?'positive':'warning'
    }
    else if(isHoliday){
        return 'red';
    }
    else{
        return false
    }
};

const subtitle=computed(()=>{
    const found=props.attendances.find(item=>date.formatDate(item?.signin_at,'YYYY/MM/DD')===state.today);
    const holiday = state.holidays.find(holiday => holiday.date === state.today);
    if (holiday) {
    return holiday.date;
  }
    if (found) {
        return `Office:${found?.office?.name} Lat: ${found.lat} Lng: ${found.lng}`;
    }
    return 'NA'
})
const title = computed(() => {
    const foundAttendance = props.attendances.find(item => date.formatDate(item?.signin_at, 'YYYY/MM/DD') === state.today);


    const holiday = state.holidays.find(holiday => holiday.date === state.today);
  if (holiday) {
    return holiday.name;  // Return the holiday name if today is a holiday
  }

    if (foundAttendance) {
        return foundAttendance?.type === 'present' ? 'Present' : 'Late';
    }

    return 'Absent';
});
</script>
