<template>
    <q-page class="container" padding>
        <div class="flex justify-between items-center">
    <div>
        <div class="text-title">Late List</div>
        <div class="text-caption text-grey-7">List of Late Attendance (3 days late in current week).</div>
    </div>
    <q-btn @click="exportLateAttendance" label="Export to Excel" color="primary" />
</div>
        <q-tabs
            class="q-mt-sm"
            stretch
            shrink
            v-model="state.tab"
            align="start"
            @update:model-value="handleNavigation"
        >


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

            <!-- <q-item-section>Reason: {{ item?.reason }}</q-item-section> -->
            <q-chip square>{{ item?.user?.designation }}</q-chip>

            <q-chip side>{{ item?.user?.mobile}}</q-chip>
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
const exportLateAttendance = () => {
    const url = route('export.late.attendance') + `?search=${state.search}`;
    window.open(url, '_blank');
};
const q = useQuasar();
const state=reactive({
    search:props?.search,
    tab: route().current(),
    selected:null
})

const handleSearch=e=>{
    router.get(route('list.late'), {
        search: state.search
    });

}

const handleNavigation=(value)=>{
    router.get(route(value))
}
</script>
