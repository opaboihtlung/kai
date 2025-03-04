
<template>
    <q-page class="container" padding>
        <div class="row q-col-gutter-sm">
            <div v-show="$q.screen.gt.sm" class="col-xs-12 col-sm-2">

                <div class="column full-height justify-between text-center   q-pa-sm bg-white shadow-default">
                    <div class="column items-center justify-center">
                        <q-avatar color="warning">A</q-avatar>
                        <div class="text-weight-medium text-dark text-lg">{{ user?.full_name }}</div>
                        <div class="text-weight-medium text-grey-7 q-ma-none">{{user?.designation}}</div>
                        <div class="text-weight-medium text-grey-7 q-ma-none">{{user?.mobile}}</div>
                        <div class="text-weight-medium text-grey-7 q-ma-none">{{state?.lat}}</div>
                        <div class="text-weight-medium text-grey-7 q-ma-none">{{state?.lng}}</div>
                    </div>


                    <!-- <q-btn class="q-mt-xl" color="primary" label="Logout" flat   icon="logout"/> -->
                </div>
            </div>
            <div class="col-xs-12 col-sm-10">
                <div class="row q-col-gutter-md">
                    <Link :href="route('office.index2')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-primary q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ count_office  }}</div>
                            <q-icon size="32px" name="o_apartment"/>
                        </div>
                    <div class="text-md text-grey-2">Total Registered Office</div>
                </div>
            </Link>
                <Link :href="route('user.active2')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-secondary q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ count_user  }}</div>
                            <q-icon size="32px" name="o_group"/>
                        </div>
                    <div class="text-md text-grey-2">Total Registered Users</div>
                </div>
            </Link>
                <Link :href="route('dashboard.admin')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-warning q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ count_attendance  }}</div>
                            <q-icon size="32px" name="event_busy"/>
                        </div>
                    <div class="text-md">Total Attendance for this week</div>
                </div>
            </Link>

                <Link :href="route('dashboard.adminTotalLeave')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-blue q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ count_leave  }}</div>
                            <q-icon size="32px" name="event_busy"/>
                        </div>
                    <div class="text-md">Total Leave for Today</div>
                </div>
            </Link>
                    <div class="col-xs-12 col-sm-6">
                        <div class="bg-white q-pa-sm shadow-default">
                            <div class="flex justify-between items-center">
                                <OfficePercent/>

                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 ">
                        <div style="height: 100%" class="bg-white q-pa-sm  shadow-default">
                            <LeaveList/>
<!--                            <AttendancePercent :present="count_present" :late="count_late" :absent="absent"/>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br/>
        <div class="col q-row-gutter-sm">
            <div class="col-xs-12 col-sm-6">
                <div class="q-pa-sm bg-white full-height shadow-default">
                    <OfficeChart/>
                </div>
            </div>
            <br/>
            <div class="col-xs-12 col-sm-6">
                <div class="q-pa-sm bg-white full-height shadow-default">
                    <OfficeChart2/>
                </div>
            </div>

            <br/>
            <div class="row-xs-12 row-sm-6">
                <div class="q-pa-sm bg-white shadow-default">
                    <DistrictChart style="max-width: 500px; max-height: 300px;"/>
                </div>
            </div>
        </div>
    </q-page>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import DistrictChart from "@/Components/DistrictChart.vue";
import OfficeChart from "@/Components/OfficeChart.vue";
import AttendancePercent from "@/Components/AttendancePercent.vue";
import OfficePercent from "@/Components/OfficePercent.vue";
import {computed, onMounted, reactive} from "vue";
import {usePage} from "@inertiajs/vue3";
import LeaveList from "@/Components/LeaveList.vue";
import {router, Link} from "@inertiajs/vue3";
import OfficeChart2 from "@/Components/OfficeChart2.vue";

defineOptions({
    layout:MainLayout
})
const props=defineProps(['count_user','count_office','count_attendance','count_leave'])
const state=reactive({
    lat:'',
    lng:''
})
const absent=computed(()=>props.count_user-(props.count_present+props.count_late))

const user=computed(()=>usePage().props?.auth?.user)

onMounted(()=>{
    navigator.geolocation.getCurrentPosition(function(location) {
        state.lat=location.coords.latitude;
        state.lng = location.coords.longitude;
    })
})
</script>
<style>
     .custom-link {
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .custom-link .card {
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .custom-link:hover .card {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        filter: brightness(1.1);
    }

</style>
