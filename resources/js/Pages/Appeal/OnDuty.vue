<template>
    <q-page class="container" padding>
      <div class="flex justify-between">
        <div>
          <q-card>
            <q-card-section>
              <div class="text-h6">Appeal</div>
            </q-card-section>

            <q-card-section>
              <div class="row q-gutter-md">
                <div class="col">
                  <q-input
                    label="Start Date"
                    v-model="startDate"
                    readonly
                    @click="showStartDate = true"
                  />
                  <q-date v-model="startDate" v-if="showStartDate" @input="showStartDate = false" />
                  <div v-if="errors.startDate" class="text-negative">{{ errors.startDate }}</div>
                </div>

                <div class="col">
                  <q-input
                    label="End Date"
                    v-model="endDate"
                    readonly
                    @click="showEndDate = true"
                  />
                  <q-date v-model="endDate" v-if="showEndDate" @input="showEndDate = false" />
                  <div v-if="errors.endDate" class="text-negative">{{ errors.endDate }}</div>
                </div>
              </div>

              <q-input
                label="Reason"
                v-model="reason"
                type="textarea"
                autogrow
                required
              />
              <div v-if="errors.reason" class="text-negative">{{ errors.reason }}</div>
            </q-card-section>

            <q-card-actions align="right">
              <q-btn label="Submit" color="primary" @click="submitAppeal" />
              <q-btn label="Cancel" color="negative" flat @click="resetForm" />
            </q-card-actions>
          </q-card>
        </div>
      </div>
    </q-page>
  </template>

  <script setup>
  import { ref } from 'vue';
  import axios from 'axios';
  import MainLayout from "@/Layouts/MainLayout.vue";
  import { Notify } from 'quasar';

  defineOptions({
    layout: MainLayout,
  });

  const showStartDate = ref(false);
  const showEndDate = ref(false);
  const startDate = ref('');
  const endDate = ref('');
  const reason = ref('');
  const errors = ref({});

  const resetForm = () => {
    startDate.value = '';
    endDate.value = '';
    reason.value = '';
    errors.value = {};
  };
  const reset = () => {
  showStartDate.value = false; 
  showEndDate.value = false;
};

  const validateFields = () => {
    errors.value = {};

    if (!startDate.value) {
      errors.value.startDate = 'Start Date is required.';
    }
    if (!endDate.value) {
      errors.value.endDate = 'End Date is required.';
    }
    if (!reason.value) {
      errors.value.reason = 'Reason field is required.';
    }
    return Object.keys(errors.value).length === 0;
  };

  const submitAppeal = async () => {
    if (!validateFields()) {
      return;
    }

    const data = {
      start_date: startDate.value,
      end_date: endDate.value,
      reason: reason.value,
    };

    try {
      const response = await axios.post('/appeal_onDutyweb', data);

      if (response.data.status === 200) {
        Notify.create({
          color: 'positive',
          message: response.data.message,
          position: 'top'
        });
        resetForm();
        reset();
      } else if (response.data.status === 409) {
        Notify.create({
          color: 'negative',
          message: response.data.message,
          position: 'top'
        });
      } else if (response.data.status === 429) {
        const errorMessages = response.data.errors;
        Notify.create({
          color: 'negative',
          message: 'Validation errors occurred: ' + Object.values(errorMessages).flat().join(', '),
          position: 'top'
        });
      }

      console.log(response.data.message);
    } catch (error) {
      console.error(error);
      Notify.create({
        color: 'red',
        message: 'An error occurred. Please try again later.',
      });
    }
  };
  </script>

  <style scoped>
  .text-negative {
    color: red;
  }
  </style>
