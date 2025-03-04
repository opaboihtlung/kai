<template>
    <q-page class="container" padding>
        <div class="flex justify-between">
            <div>
                <div class="text-title">Appeal</div>
                <div class="text-caption text-grey-7">List of Appeal Attendance.</div>
            </div>

            <div>
            </div>
        </div>
        <q-tabs
            class="q-mt-sm"
            stretch
            shrink
            v-model="state.tab"
            align="start"
            @update:model-value="handleNavigation"
        >
            <q-tab name="appeal.late_reason"  label="Late-Reason"/>
            <q-tab name="appeal.left_early"  label="Left-Early"/>
            <q-tab name="appeal.on_duty"  label="On-Duty"/>

            <q-space/>
            <q-input v-model="state.search"
                     autofocus
                     outlined
                     dense
                     @keyup.enter="handleSearch"
                     bg-color="white"
                     placeholder="Enter fullname"
            >
                <template #append>
                    <q-icon name="o_search"/>
                </template>
            </q-input>
        </q-tabs>
        <br/>
        <q-list separator class="bg-white shadow-default ">
            <q-item v-for="(item,index) in list?.data"
                    :key="index">
                <q-item-section>
                    <q-item-label>{{item?.user?.full_name}}</q-item-label>
                    <div> <q-chip class="text-caption q-ml-none q-mt-none" square v-for="office in item.user.offices" :label="office?.name"/></div>
                </q-item-section>

            <q-item-section>Reason: {{ item?.reason }}</q-item-section>
            <q-chip>Date: {{ item?.start_date }} to {{ item?.end_date }}</q-chip>
                <q-item-section side>
                    <div class="flex  q-gutter-sm">
                        <!-- <div class="text-caption">{{item?.status}}</div> -->
                        <div>
                              <q-chip v-if="item.status==='Approved'" text-color="white" color="positive" label="Approved"/>
                              <q-chip v-if="item.status==='Rejected'" text-color="white" color="negative" label="Rejected"/>
                              <q-chip v-if="item.status==='Submitted'" text-color="white" color="blue" label="Submitted"/>
                          </div>
                        <!-- <q-icon size="sm" name="o_chevron_right"/> -->
                    </div>

                </q-item-section>
                <q-btn-dropdown class="q-pa-xs" dropdown-icon="more_vert" right>
                        <q-list>
                            <!-- Show "Approve" if the status is "Submitted" or "Rejected" -->
                            <q-item v-if="item.status === 'Submitted' || item.status === 'Rejected'" v-close-popup clickable @click.stop="onDutyApprove(item, 'approve')">
                                <q-item-section side>
                                    <q-item-label>Approve</q-item-label>
                                </q-item-section>
                            </q-item>

                            <!-- Show "Reject" if the status is "Submitted" or "Rejected" -->
                            <q-item v-if="item.status === 'Submitted' || item.status === 'Rejected'" v-close-popup clickable @click.stop="onDutyReject(item, 'reject')">
                                <q-item-section side>
                                    <q-item-label>Reject</q-item-label>
                                </q-item-section>
                            </q-item>
                        </q-list>
                </q-btn-dropdown>
            </q-item>
            <div class="flex q-gutter-sm">
                <q-btn :disable="!!!list.prev_page_url" @click="$inertia.get(list.prev_page_url)" flat round icon="o_chevron_left"/>
                <q-btn :disable="!!!list.next_page_url" @click="$inertia.get(list.next_page_url)" flat round icon="o_chevron_right"/>
            </div>
        </q-list>



    </q-page>
</template>
<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import {reactive} from "vue";
import {router} from '@inertiajs/vue3';
import {useQuasar} from "quasar";

defineOptions({
    layout:MainLayout
})
const props = defineProps(['list','search']);

const q = useQuasar();
const state=reactive({
    search:props?.search,
    tab: route().current(),
    selected:null
})
const onDutyApprove=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to approved?',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        router.post(route('appeal.approve2',item.id),{},{
            onStart:params => q.loading.show(),
            onFinish:params => q.loading.hide()
        })
    })
}
const onDutyReject=item=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to rejected?',
        ok:'Yes',
        cancel:'No'
    })
        .onOk(()=>{
            router.post(route('appeal.reject2',item.id),{},{
                onStart:params => q.loading.show(),
                onFinish:params => q.loading.hide()
            })
        })
}

const handleSearch=e=>{
    router.get(route('appeal.on_duty'), {
        search: state.search
    });

}

const handleNavigation=(value)=>{
    router.get(route(value))
}
</script>
