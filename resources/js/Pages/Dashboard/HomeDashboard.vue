<template>
  <q-layout @scroll="handleScroll" style="background: #ffffff" view="hHh lpR fff">
    <q-header height-hint="90"  :class="classObject" style="background-color: transparent;">
            <q-toolbar  class="container flex justify-between items-center" style="height: 80px">
                <div class="flex items-center q-gutter-sm">
                    <q-img width="60px" src="/assets/images/logo.png" />
                </div>

                <div class="flex items-center q-gutter-md">
                    <a href="#" @click="$inertia.get(route('home'))" class="nav-link">Home</a>

                    <q-btn square @click="$inertia.get(route('login'))" class="login-btn" outline label="Login" no-caps/>
                </div>
            </q-toolbar>
        </q-header>
    <q-page-container>
      <q-page class="container">
        <!-- Flex Row -->
        <div class="col flex q-gutter-md">
          <!-- First Column -->
          <div class="row-xs-12 col-sm-6">
            <div class="bg-white q-pa-sm shadow-default">
              <div class="flex justify-between items-center">
                <OfficePercent2 />
              </div>
            </div>
          </div>
          <!-- Second Column -->
          <div class="row-xs-12 col-sm-6">
            <div class="bg-white q-pa-sm shadow-default">
              <DistrictChart2 style="max-width: 580px; max-height: 400px;" />
            </div>
          </div>
        </div>
        <br>
        <!-- Full Width Rows -->
        <div class="row flex q-gutter-md">
          <div class="col-12">
            <div class="q-pa-sm bg-white full-height shadow-default">
              <OfficeChart3 />
            </div>
          </div>
          <div class="col-12">
            <div class="q-pa-sm bg-white full-height shadow-default">
              <OfficeChart4 />
            </div>
          </div>
          <br>
        </div>
      </q-page>
    </q-page-container>

    <!-- Footer -->
    <q-footer class="bg-primary text-footer q-py-md">
      <FooterComponent />
    </q-footer>
  </q-layout>
</template>



<script setup>
import { useQuasar } from "quasar";
import OfficePercent2 from "@/Components/OfficePercent2.vue";
import FooterComponent from "@/Components/FooterComponent.vue";
import DistrictChart2 from "@/Components/DistrictChart2.vue";
import OfficeChart3 from "@/Components/OfficeChart3.vue";
import OfficeChart4 from "@/Components/OfficeChart4.vue";
import {router} from "@inertiajs/vue3";
import {computed, reactive} from "vue";
const q = useQuasar();

const state=reactive({
    isTop:true
})
const classObject=computed(()=>({
    'bg-transparent':state.isTop,
    'text-primary':state.isTop,
    'bg-white shadow-bottom-5 text-primary':!state.isTop,
}))
const handleScroll=detail=>{
    const {position} = detail;
    if (position < 10) {
        state.isTop=true
    }else {
        state.isTop=false
    }
}
</script>
<style scoped>
.login-btn{
    min-width: 100px;
}
.nav-link{
    text-decoration: none;
    width: 80px;
    color: #444444;
}
.text-footer{
    color: #686B9A;
}
</style>
