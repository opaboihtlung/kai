<!-- <template>
    <q-page class="container" padding>
       <div class="row q-col-gutter-sm">
           <div class="col-xs-12 col-sm-4">
               <div class="column q-pa-sm bg-white">
                   <div class="text-center">
                       <q-icon size="32px" name="o_account_circle"/>
                       <div class="text-weight-medium text-dark">{{ user?.full_name }}</div>
                       <div class="text-weight-medium text-grey-7 q-ma-none">{{ user?.designation }}</div>
                   </div>

                   <q-list class="q-pa-none" separator>
                       <q-item>
                           <q-item-section>
                               <q-item-label class="text-dark text-lg">Active Sessions</q-item-label>
                           </q-item-section>
                       </q-item>
                       <q-item v-for="item in current_sessions" :key="item.id" class="q-pl-none">
                           <q-item-section avatar>
                               <q-icon name="error_outline" color="warning"/>
                           </q-item-section>
                           <q-item-section>
                               <q-item-label>{{ formatDateTime(item?.signin_at) }}</q-item-label>
                           </q-item-section>
                           <q-item-section side>
                               <q-item-label style="font-style: italic; font-size: 13px;">Sign out</q-item-label>
                               <q-btn @click="logout(item)" round icon="logout"/>
                           </q-item-section>
                       </q-item>
                   </q-list>
               </div>
               <KaiCalendar class="full-width"/>
           </div>
           <div class="col-xs-12 col-sm-8 row q-col-gutter-sm">
            <Link :href="route('dashboard.totalofficial')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-primary q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ total_users }}</div>
                            <q-icon size="24px" name="people_outline"/>
                        </div>
                    <div class="text-md text-grey-2">No of officials</div>
                </div>
            </Link>

            <Link :href="route('dashboard.present')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-positive q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ count_attendances }}</div>
                            <q-icon size="24px" name="o_group_add"/>
                        </div>
                    <div class="text-md text-grey-2">Present on Today's</div>
                </div>
            </Link>

            <Link :href="route('dashboard.absent')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-negative q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ total_users - count_attendances }}</div>
                            <q-icon size="24px" name="o_group_remove"/>
                        </div>
                    <div class="text-md text-grey-2">Absent on Today's</div>
                </div>
            </Link>
            <Link :href="route('dashboard.leave')" class="col-xs-12 col-sm-3 custom-link">
                <div class="bg-blue q-pa-sm shadow-default text-white card">
                    <div class="flex justify-between items-center">
                        <div class="text-xl text-bold ">{{ noOfLeave  }}</div>
                            <q-icon size="24px" name="event_busy"/>
                        </div>
                    <div class="text-md text-grey-2">Leave on Today's</div>
                </div>
            </Link>

               <div class="col-xs-12">
                   <div class="q-pa-sm row">
                       <div class="text-lg text-bold text-dark">Leave on Today's</div>
                       <q-space></q-space>
                       <q-input v-model="state.search"
                                autofocus
                                outlined
                                dense
                                @keyup.enter="handleSearch"
                                bg-color="white"
                                placeholder="Type name...."
                        >
                            <template #append>
                                <q-icon name="o_search"/>
                            </template>
                        </q-input>
                   </div>
                   <q-list>
                        <div v-for="item in absentUsersWithLeave.data" :key="item" class="flex justify-between items-center shadow-default q-mt-sm bg-white q-pa-sm">
                            <div>
                                <div class="flex items-center q-gutter-sm">
                                    <q-icon class="q-pa-sm" name="fiber_manual_record" color="blue"/>
                                <div class="q-ml-sm">
                            <div class="text-bold text-weight-medium">{{ item.full_name }}</div>
                        <div class="text-grey-7 text-weight-medium">
                            {{ item.designation }}
                        </div>
                        </div>
                        </div>
                        </div>
                            <div>
                                <q-chip :color="item.leaveType === 'Absent' || !item.leaveType ? 'negative' : 'blue'" text-color="white" :label="item.leaveType || 'Absent'"/>
                            </div>
                        </div>
                        <div class="flex q-gutter-sm">
                            <q-btn color="primary" @click="navigate(absentUsersWithLeave.prev_page_url)" :disable="!Boolean(absentUsersWithLeave.prev_page_url)" round flat icon="o_chevron_left"/>
                            <q-btn color="primary" @click="navigate(absentUsersWithLeave.next_page_url)" :disable="!Boolean(absentUsersWithLeave.next_page_url)" round flat icon="o_chevron_right"/>
                        </div>
                     </q-list>

               </div>
           </div>
       </div>
   </q-page>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { useQuasar } from "quasar";
import { router, Link } from "@inertiajs/vue3";
import utils from "@/Util/utils";
import KaiCalendar from "@/Components/KaiCalendar.vue";
import {reactive} from "vue";

defineOptions({
   layout: MainLayout
})

const props = defineProps(['user', 'devices', 'attendances', 'current_sessions', 'total_users', 'absentUsersWithLeave', 'noOfLeave','search', 'count_attendances'])
const q = useQuasar();
const { formatSignoutTime, formatDateTime } = utils();
const navigate = async url => {
    if (url) {
        const response = await router.get(url, {}, { preserveState: true });
        props.absentUsersWithLeave = response.props.absentUsersWithLeave;
    }
}
const state=reactive({
    search:props?.search,

    selected:null
})
const handleSearch=val=>{
    router.get(route('dashboard.leave'), {
        office_ids: state.offices?.map(item => item.value),
        ...state
    })
}
const itemApprove = item => {
   q.dialog({
       title: 'Confirmation',
       message: 'Do you want to approve?',
       ok: 'Yes',
       cancel: 'No'
   })
   .onOk(() => {
       router.post(route('device.approve', item.id), {}, {
           onStart: params => q.loading.show(),
           onFinish: params => q.loading.hide()
       })
   })
}

const itemReject = item => {
   q.dialog({
       title: 'Confirmation',
       message: 'Do you want to reject?',
       ok: 'Yes',
       cancel: 'No'
   })
   .onOk(() => {
       router.post(route('device.reject', item.id), {}, {
           onStart: params => q.loading.show(),
           onFinish: params => q.loading.hide()
       })
   })
}

const logout = item => {
   q.dialog({
       title: 'Confirmation',
       message: 'Do you want to sign out this session?',
       ok: 'Yes',
       cancel: 'No'
   })
   .onOk(() => {
       router.delete(route('attendance.signout', item.id), {
           onStart: params => q.loading.show(),
           onFinish: params => q.loading.hide()
       })
   })
}
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
</style> -->
<template>
    <q-page class="container" padding>
       <div class="row q-col-gutter-sm">

           <div class="col-xs-12 col-sm-8 row q-col-gutter-sm">

               <div class="col-xs-12">
                   <div class="q-pa-sm row">
                       <div class="text-lg text-bold text-dark">Leave on Today's</div>
                       <q-space></q-space>
                       <q-input v-model="state.search"
                                autofocus
                                outlined
                                dense
                                @keyup.enter="handleSearch"
                                bg-color="white"
                                placeholder="Type name...."
                        >
                            <template #append>
                                <q-icon name="o_search"/>
                            </template>
                        </q-input>
                   </div>
                   <q-list>
                        <div v-for="item in absentUsersWithLeave.data" :key="item" class="flex justify-between items-center shadow-default q-mt-sm bg-white q-pa-sm">
                            <div>
                                <div class="flex items-center q-gutter-sm">
                                    <q-icon class="q-pa-sm" name="fiber_manual_record" color="blue"/>
                                <div class="q-ml-sm">
                            <div class="text-bold text-weight-medium">{{ item.full_name }}</div>
                        <div class="text-grey-7 text-weight-medium">
                            {{ item.designation }}
                        </div>
                        </div>
                        </div>
                        </div>
                            <div>
                                <q-chip :color="item.leaveType === 'Absent' || !item.leaveType ? 'negative' : 'blue'" text-color="white" :label="item.leaveType || 'Absent'"/>
                            </div>
                        </div>
                        <div class="flex q-gutter-sm">
                            <q-btn color="primary" @click="navigate(absentUsersWithLeave.prev_page_url)" :disable="!Boolean(absentUsersWithLeave.prev_page_url)" round flat icon="o_chevron_left"/>
                            <q-btn color="primary" @click="navigate(absentUsersWithLeave.next_page_url)" :disable="!Boolean(absentUsersWithLeave.next_page_url)" round flat icon="o_chevron_right"/>
                        </div>
                     </q-list>

               </div>
           </div>
       </div>
   </q-page>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import { router, Link } from "@inertiajs/vue3";
import {reactive} from "vue";

defineOptions({
   layout: MainLayout
})

const props = defineProps(['absentUsersWithLeave','search',])
const navigate = async url => {
    if (url) {
        const response = await router.get(url, {}, { preserveState: true });
        props.absentUsersWithLeave = response.props.absentUsersWithLeave;
    }
}
const state=reactive({
    search:props?.search,

    selected:null
})
const handleSearch=val=>{
    router.get(route('dashboard.leave'), {
        office_ids: state.offices?.map(item => item.value),
        ...state
    })
}

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
