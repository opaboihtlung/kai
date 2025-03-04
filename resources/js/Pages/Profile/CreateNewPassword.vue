<template>
    <q-page padding class="container-sm">
      <div class="flex justify-between">
        <div>
          <div class="text-title">Create New Password</div>
        </div>
      </div>
      <br />
      <q-form @submit="onSubmit">
        <q-input
          v-model="form.new_password"
          :type="type"
          outlined
          bg-color="white"
          label="New Password"
          :rules="[
            val => !!val || 'New Password is required',
            val => val.length >= 6 || 'Minimum character of password is 6'
          ]"
        >
          <template #append>
            <q-btn
              v-if="type === 'password'"
              @click="type = 'text'"
              round
              icon="visibility_off"
            />
            <q-btn
              v-else
              @click="type = 'password'"
              round
              icon="visibility"
            />
          </template>
        </q-input>
        <q-input
          v-model="form.confirm_password"
          :type="type"
          outlined
          bg-color="white"
          label="Confirm New Password"
          :rules="[
            val => form.new_password === val || 'Passwords must match'
          ]"
        />
        <div class="flex q-gutter-sm">
          <q-btn class="sized-btn" type="submit" color="primary" label="Save" />
          <q-btn
            class="sized-btn"
            @click="$inertia.get(route('dashboard'))"
            color="negative"
            outline
            label="Cancel"
          />
        </div>
      </q-form>
    </q-page>
  </template>

  <script setup>
  import MainLayout from "@/Layouts/MainLayout.vue";
  import { useForm } from "@inertiajs/vue3";
  import { ref } from "vue";
  import { useQuasar } from "quasar";

  defineOptions({
    layout: MainLayout,
  });

  const q = useQuasar();
  const type = ref("password");
  const form = useForm({
    new_password: "",
    confirm_password: "",
  });

  const onSubmit = () => {
    form.put(route("profile.update-create-password"), {
      onStart: () => q.loading.show(),
      onFinish: () => q.loading.hide(),
    });
  };
  </script>
