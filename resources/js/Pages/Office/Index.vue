<template>
    <q-page class="container" padding>
      <div class="flex justify-between items-center">
        <div>
          <div class="text-title">Master Data</div>
          <div class="text-caption text-grey-7">
            Edit of master data must be done carefully to avoid application disruption.
          </div>
        </div>

        <div class="flex q-gutter-sm">

          <q-btn
            @click="showDialog = true"
            class="sized-btn q-mr-sm"
            color="primary"
            label="Set Grace Period for All Offices"
          />
          <q-btn
            @click="$inertia.get(route('office.create'))"
            class="sized-btn"
            color="primary"
            label="New Office"
          />
        </div>
      </div>

      <q-dialog v-model="showDialog" persistent>
        <q-card style="min-width: 400px">
          <q-card-section class="row items-center">
            <div class="text-h6">Set Grace Period</div>
          </q-card-section>

          <q-card-section>
            <q-input
              v-model="gracePeriod"
              type="number"
              label="Grace Period (minutes)"
              filled
            />
          </q-card-section>

          <q-card-actions align="right">
            <q-btn flat label="Cancel" color="negative" @click="showDialog = false" />
            <q-btn flat label="Save" color="primary" @click="saveGracePeriod" />
          </q-card-actions>
        </q-card>
      </q-dialog>

      <br />

      <q-tabs
        stretch
        shrink
        v-model="state.tab"
        align="start"
        @update:model-value="handleNavigation"
      >
        <q-tab name="office.index" label="Offices" />
        <q-tab name="district.index" label="Districts" />
        <q-space />
        <q-input
          v-model="state.search"
          outlined
          dense
          @keyup.enter="handleSearch"
          bg-color="white"
          placeholder="Enter office name"
        >
          <template #append>
            <q-icon name="o_search" />
          </template>
        </q-input>
      </q-tabs>

      <br />

      <q-list separator class="bg-white shadow-default">
        <q-item v-for="(item, index) in list?.data" :key="index">
          <q-item-section avatar>
            <QRCodeVue3
              :width="50"
              :height="50"
              :value="item?.qr_code?.code"
            />
          </q-item-section>
          <q-item-section>
            <q-item-label>{{ item.name }}</q-item-label>
            <q-item-label caption>{{ item.district?.name }}</q-item-label>
          </q-item-section>
          <q-item-section side>
            <q-btn
              @click="$inertia.get(route('office.edit', item?.id))"
              icon="o_chevron_right"
            />
          </q-item-section>
        </q-item>
      </q-list>

      <div class="flex q-gutter-sm justify-center q-mt-md">
        <q-btn
          :disable="!list?.prev_page_url"
          @click="$inertia.get(list?.prev_page_url)"
          flat
          round
          icon="o_chevron_left"
        />
        <q-btn
          :disable="!list?.next_page_url"
          @click="$inertia.get(list?.next_page_url)"
          flat
          round
          icon="o_chevron_right"
        />
      </div>
    </q-page>
  </template>

  <script setup>
  import MainLayout from "@/Layouts/MainLayout.vue";
  import { reactive, ref } from "vue";
  import { router } from "@inertiajs/vue3";
  import { useQuasar } from "quasar";
  import QRCodeVue3 from "qrcode-vue3";

  defineOptions({
    layout: MainLayout,
  });

  const props = defineProps(["list", "search"]);

  const q = useQuasar();

  const state = reactive({
    search: props?.search,
    tab: route().current(),
  });

  const showDialog = ref(false);
  const gracePeriod = ref(null);

  const handleSearch = () => {
    router.get(route("office.index"), {
      search: state.search,
    });
  };

  const handleNavigation = (value) => {
    router.get(route(value));
  };

  const saveGracePeriod = () => {
  if (gracePeriod.value) {
    q.loading.show({
      message: "Saving grace period...",
    }); // Start loading spinner

    // Make an API call to save grace period
    router.post(route("office.graceperiod"), { grace_period: gracePeriod.value }, {
      onSuccess: () => {
        q.notify({
          type: "positive",
          message: `Grace period of ${gracePeriod.value} minutes set successfully for all Offices.`,
        });
        showDialog.value = false;
      },
      onError: (errors) => {
        q.notify({
          type: "negative",
          message: "Failed to set grace period. Please try again.",
        });
      },
      onFinish: () => {
        q.loading.hide();
      },
    });
  } else {
    q.notify({
      type: "negative",
      message: "Please enter a valid grace period.",
    });
  }
};
  </script>
