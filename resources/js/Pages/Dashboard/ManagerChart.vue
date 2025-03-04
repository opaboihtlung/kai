<template>
    <q-page class="container" padding>
        <div class="col q-row-gutter-sm">
            <div class="col-xs-12 col-sm-6">
                <div class="q-pa-sm bg-white full-height shadow-default">
                    <UserChart/>
                </div>
            </div>
        </div>
    </q-page>
</template>
<script setup>
import UserChart from "@/Components/UserChart.vue";
import MainLayout from "@/Layouts/MainLayout.vue";
import {useQuasar} from "quasar";

defineOptions({
    layout:MainLayout
})
</script>
