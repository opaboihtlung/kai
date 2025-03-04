<template>
    <!-- {{ state.list }} -->
  <q-list class="full-height">
    <q-item dense>
      <q-item-section>
        <q-item-label class="text-weight-medium">Total Leave for today</q-item-label>
      </q-item-section>
    </q-item>
    <q-item v-for="(attendance, index) in state.list" :key="index">
      <q-item-section avatar>
        <q-avatar text-color="white" size="md" color="blue">
          {{ attendance?.user?.full_name[0].toUpperCase() }}
        </q-avatar>
      </q-item-section>
      <q-item-section>
        <q-item-label>{{ attendance?.user?.full_name }}  ({{ attendance?.leaveType }})</q-item-label>
        <q-item-label caption>{{ attendance?.office?.name }}</q-item-label>
      </q-item-section>
    </q-item>
  </q-list>
</template>

<script setup>
import { onMounted, reactive } from 'vue';
import { useQuasar } from 'quasar';
import axios from 'axios';
// const props =  defineProps ({
//     list: Object
//  })
const q = useQuasar();
const state = reactive({
    list: []
});

onMounted(() => {
    axios.get(route('statistic.leave'))
        .then(res => {
            const { list } = res.data;
            const uniqueList = Array.from(new Map(list.map(item => [item.user.id, item])).values());
            state.list = uniqueList;
            // state.list = list;
        })
        .catch(err => {
            console.log(err);
        });
});
</script>
