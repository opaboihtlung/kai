
<template>
    <q-page class="container" padding>
        <div class="row q-col-gutter-sm">
            <div class="col-xs-12 col-sm-4">
                <div class="column   q-pa-sm bg-white ">
                    <div class="text-center">
                        <q-icon size="32px" name="o_account_circle"/>
                        <div class="text-weight-medium text-dark">{{ user?.full_name }}</div>
                        <div class="text-weight-medium text-grey-7 q-ma-none">{{user?.designation}}</div>
                    </div>

                    <q-list class="q-pa-none" separator>
                        <q-item>
                            <q-item-section>
                                <q-item-label class="text-dark text-lg">Active Sessions</q-item-label>
                            </q-item-section>
                        </q-item>
                        <q-item v-for="item in current_sessions" :key="item.id" class="q-pl-none">
                            <q-item-section avatar><q-icon name="error_outline" color="warning"/> </q-item-section>
                            <q-item-section>
                                <q-item-label>{{formatDateTime(item?.signin_at)}}</q-item-label>
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
                        <div class="text-xl text-bold ">E-Leave</div>
                            <q-icon size="24px" name="event_busy"/>
                        </div>
                    <div class="text-md text-grey-2">Leave on Today's</div>
                </div>
            </Link>

                <div class="col-xs-12" v-if="devices?.length>0">
                    <div class="q-pa-sm  ">
                        <div class="text-lg text-bold text-dark">New Device Request</div>
                        <q-list >
                            <q-item class="shadow-default  q-mt-sm bg-warning text-white" v-for="item in devices">
                                <q-item-section>
                                    <q-item-label>{{item?.name}}</q-item-label>
                                    <q-item-label caption>{{item?.user?.full_name}}</q-item-label>
                                </q-item-section>
                                <q-item-section side>
                                    <div class="flex q-gutter-sm">
                                        <q-btn color="primary" @click="itemApprove(item)" round outline size="sm" icon="o_check"/>
                                        <q-btn color="negative" @click="itemReject(item)" round outline size="sm" icon="o_close"/>
                                    </div>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
                <div class="col-xs-12" v-if="appeal_attendances?.length>0">
                    <div class="q-pa-sm  ">
                        <div class="text-lg text-bold text-dark">OFFICE On-Duty Request</div>
                        <q-list >
                            <q-item class="shadow-default  q-mt-sm bg-warning text-white" v-for="item in appeal_attendances">
                                <q-icon class="q-pa-sm"  name="fiber_manual_record" color="black"/>
                                <q-item-section>
                                    <q-item-label>{{item?.name}}</q-item-label>
                                    <q-item-label caption :style="{ color: 'black' }">{{item?.user?.full_name}}</q-item-label>
                                    <q-item-label caption :style="{ color: 'black' }">{{item?.user?.designation}}</q-item-label>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label caption :style="{ color: 'black', }">Reason: {{item?.reason}}</q-item-label>
                                </q-item-section>
                                <q-item-section>
                                    <q-item-label caption :style="{ color: 'white', }">({{ item?.start_date}} to {{ item?.end_date }})</q-item-label>
                                </q-item-section>
                                <q-item-section side>
                                    <div class="flex q-gutter-sm">
                                        <q-btn color="primary" @click="onDutyApprove(item)" round outline size="sm" icon="o_check"/>
                                        <q-btn color="negative" @click="ondutyReject(item)" round outline size="sm" icon="o_close"/>
                                    </div>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
                <div class="col-xs-12" v-if="appeal_lateReason?.length>0">
                    <div class="q-pa-sm  ">
                        <div class="text-lg text-bold text-dark">Late Reason Request</div>
                        <q-list >
                            <q-item class="shadow-default  q-mt-sm bg-warning text-white" v-for="item in appeal_lateReason">
                                <q-icon class="q-pa-sm"  name="fiber_manual_record" color="black"/>
                                <q-item-section>
                                    <q-item-label>{{item?.name}}</q-item-label>
                                    <q-item-label caption :style="{ color: 'black' }">{{item?.user?.full_name}}</q-item-label>
                                    <q-item-label caption :style="{ color: 'black' }">{{item?.user?.designation}}</q-item-label>
                                </q-item-section>
                                <q-item-section >
                                    <q-item-label caption :style="{ color: 'black', }">Reason: {{item?.reason}}</q-item-label>
                                </q-item-section>
                                <q-item-section side>
                                    <q-item-label caption :style="{ color: 'white', }">({{item?.start_date}})</q-item-label>
                                    <q-item-label caption :style="{ color: 'black' }">
                                Signin: {{ item?.signin_time }}
                                </q-item-label>
                                </q-item-section>
                                <q-item-section side>
                                    <div class="flex q-gutter-sm">
                                        <q-btn color="primary" @click="lateReasonApprove(item)" round outline size="sm" icon="o_check"/>
                                        <q-btn color="negative" @click="lateReasonReject(item)" round outline size="sm" icon="o_close"/>
                                    </div>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
                <div class="col-xs-12" v-if="appeal_leftEarly?.length>0">
                    <div class="q-pa-sm  ">
                        <div class="text-lg text-bold text-dark">Left Early Request</div>
                        <q-list >
                            <q-item class="shadow-default  q-mt-sm bg-warning text-white" v-for="item in appeal_leftEarly">
                                <q-icon class="q-pa-sm"  name="fiber_manual_record" color="black"/>
                                <q-item-section>
                                    <q-item-label>{{item?.name}}</q-item-label>
                                    <q-item-label caption :style="{ color: 'black' }">{{item?.user?.full_name}}</q-item-label>
                                    <q-item-label caption :style="{ color: 'black' }">{{item?.user?.designation}}</q-item-label>
                                </q-item-section>
                                <q-item-section >
                                    <q-item-label caption :style="{ color: 'black', }">Reason: {{item?.reason}}</q-item-label>
                                </q-item-section>
                                <q-item-section side>
                                    <q-item-label caption :style="{ color: 'white', }">({{item?.start_date}})</q-item-label>
                                </q-item-section>
                                <q-item-section side>
                                    <div class="flex q-gutter-sm">
                                        <q-btn color="primary" @click="leftEarlyApprove(item)" round outline size="sm" icon="o_check"/>
                                        <q-btn color="negative" @click="leftEarlyReject(item)" round outline size="sm" icon="o_close"/>
                                    </div>
                                </q-item-section>
                            </q-item>
                        </q-list>
                    </div>
                </div>
                <div class="col-xs-12">
                   <div class="q-pa-sm row">
                       <div class="text-lg text-bold text-dark">Today's Attendences</div>
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

                   <q-list >
                       <div class="flex justify-between items-center shadow-default  q-mt-sm bg-white q-pa-sm" v-for="item in attendances.data">
                          <div>
                              <div class="flex items-center q-gutter-sm">
                                  <q-icon class="q-pa-sm" v-if="item.type==='present'" name="fiber_manual_record" color="positive"/>
                                  <q-icon class="q-pa-sm" v-else name="fiber_manual_record" color="warning"/>
                                  <div class="q-ml-sm">
                                      <div class="text-bold text-weight-medium">{{item?.user?.full_name}}</div>
                                      <div class="text-grey-7 text-weight-medium">Signin at: {{formatSignoutTime(item?.signin_at)}}</div>
                                  </div>
                              </div>

                          </div>
                          <!-- <div>
                            <q-chip v-if="item.type==='late'" text-color="white" color="warning" label="Late/Left Early"/>
                              <q-chip v-else color="positive" text-color="white"  label="Present"/>
                          </div> -->
                          <div>
                            <q-chip
                                v-if="item.type === 'late'"
                                text-color="white"
                                color="warning"
                                label="Late/Left Early">
                            </q-chip>
                            <q-chip
                                v-if="item.type === 'present' && (item.in_remark === 'late with approval' || item.in_remark === 'on-duty with approval' || item.in_remark==='left-early with approval')"
                                color="positive"
                                text-color="white"
                                label="Present with Approval"
                                class="q-ml-sm">
                            </q-chip>
                            <q-chip
                                v-else-if="item.type === 'present'"
                                color="positive"
                                text-color="white"
                                label="Present">
                            </q-chip>
                        </div>

                          <div class="flex q-gutter-sm items-center">
                              <q-chip v-if="!!item?.signout_at" square :label="formatSignoutTime(item?.signout_at)"/>
                              <q-btn @click="$inertia.get(route('attendance.show',item.id))" round flat icon="o_chevron_right"/>
                          </div>
                       </div>
                       <div class="flex q-gutter-sm">
                            <q-btn color="primary" @click="navigate(attendances.prev_page_url)" :disable="!Boolean(attendances.prev_page_url)" round flat icon="o_chevron_left"/>
                            <q-btn color="primary" @click="navigate(attendances.next_page_url)" :disable="!Boolean(attendances.next_page_url)" round flat icon="o_chevron_right"/>
                        </div>
                   </q-list>

               </div>
            </div>
        </div>
        <br/>
        <!-- <div class="col q-row-gutter-sm">
            <div class="col-xs-12 col-sm-6">
                <div class="q-pa-sm bg-white full-height shadow-default">
                    <UserChart/>
                </div>
            </div>
        </div> -->
    </q-page>
</template>

<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import {useQuasar} from "quasar";
import {router, Link} from "@inertiajs/vue3";
import utils from "@/Util/utils";
import KaiCalendar from "@/Components/KaiCalendar.vue";
import {reactive} from "vue";
import UserChart from "@/Components/UserChart.vue";

defineOptions({
    layout:MainLayout
})

const props=defineProps(['user','devices','attendances','current_sessions','total_users','noOfLeave', 'count_attendances','search','appeal_attendances','appeal_lateReason','appeal_leftEarly'])
const q = useQuasar();
const {formatSignoutTime, formatDateTime} = utils();

const leftEarlyApprove=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to approved?',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        router.post(route('appeal.approveleft',item.id),{},{
            onStart:params => q.loading.show(),
            onFinish:params => q.loading.hide()
        })
    })
}
const leftEarlyReject=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to rejected?',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.post(route('appeal.rejectleft',item.id),{},{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide()
            })
        })
}

const lateReasonApprove=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to approved?',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        router.post(route('appeal.approvelate',item.id),{},{
            onStart:params => q.loading.show(),
            onFinish:params => q.loading.hide()
        })
    })
}
const lateReasonReject=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to rejected?',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.post(route('appeal.rejectlate',item.id),{},{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide()
            })
        })
}
const onDutyApprove=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to approved?',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        router.post(route('appeal.approve',item.id),{},{
            onStart:params => q.loading.show(),
            onFinish:params => q.loading.hide()
        })
    })
}
const ondutyReject=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to rejected?',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.post(route('appeal.reject',item.id),{},{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide()
            })
        })
}
const itemApprove=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to approved?',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        router.post(route('device.approve',item.id),{},{
            onStart:params => q.loading.show(),
            onFinish:params => q.loading.hide()
        })
    })
}
const itemReject=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to rejected?',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.post(route('device.reject',item.id),{},{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide()
            })
        })
}
const logout=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to sign out this session?',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.delete(route('attendance.signout',item.id),{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide()
            })
        })
}
const state=reactive({
    search:props?.search,
    selected:null
})
const handleSearch=val=>{
    router.get(route('dashboard.present'), {
        office_ids: state.offices?.map(item => item.value),
        ...state
    })
}
const navigate = async url => {
    if (url) {
        const response = await router.get(url, {}, { preserveState: true });
        props.attendances = response.props.attendances;
    }
};
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
