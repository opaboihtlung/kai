<template>
    <q-page class="container" padding>
        <div class="flex justify-between items-center">
            <div>
                <div class="text-title">Edit User</div>
            </div>
            <div class="flex q-gutter-sm">
                <q-btn v-if="!!data?.deleted_at" :loading="state.submitting" @click="handleActivate(data)" color="positive" outline label="Activate"/>
                <q-btn v-else :loading="state.submitting" @click="handleDeactivate" color="negative" outline label="Deactivate"/>
                <q-btn :loading="state.submitting" @click="handleDelete" color="negative"  label="Delete"/>
            </div>
        </div>
        <q-separator class="q-my-md"/>
        <q-form class="row q-col-gutter-sm" @submit="submit" autocomplete="off">
            <div class="col-xs-12 col-sm-7">
                <fieldset class="row q-col-gutter-sm  q-pa-md bg-white">
                    <legend class="q-pa-sm text-white bg-dark text-lg rounded-borders text-md">Account Information</legend>
                    <div class="col-xs-12">
                        <q-input v-model="form.full_name"
                                 :error="!!form.errors?.full_name"
                                 :error-message="form.errors?.full_name?.toString()"
                                 :rules="[
                             val=>!!val || 'Full Name is required'
                         ]"
                         autocomplete="off"
                                 bg-color="white"
                                 label="Name"
                                 no-error-icon
                                 outlined
                        />
                    </div>
                    <div class="col-xs-12">
                        <q-input v-model="form.designation"
                                 bg-color="white"
                                 label="Designation"
                                 no-error-icon
                                 outlined
                                 :rules="[
                                     val=>true
                                 ]"
                                 autocomplete="off"
                        />
                    </div>
                    <div class="col-xs-12">
                        <q-input v-model="form.mobile"
                                 :error="!!form.errors?.mobile"
                                 :error-message="form.errors?.mobile?.toString()"
                                 :rules="[
                                    val=>!!val || 'Mobile is required'
                                 ]"
                                 mask="##########"
                                 bg-color="white"
                                 label="Mobile"
                                 no-error-icon
                                 outlined
                                 autocomplete="off"
                        />
                    </div>

                    <div class="col-xs-12">
                        <q-select v-model="form.role"
                                  clearable
                                  :error="!!form.errors?.role"
                                  :error-message="form.errors?.role?.toString()"
                                  :options="roles"
                                  bg-color="white"
                                  label="Role"
                                  no-error-icon
                                  outlined

                        />
                    </div>
                    <div class="col-xs-12">
                        <q-select v-model="form.offices"
                                  :error="!!form.errors?.office_id"
                                  :error-message="form.errors?.office_id?.toString()"
                                  :options="filterOptions"
                                  :rules="[
                             val=>!!val || 'Office is required'
                         ]"
                                  use-input
                                  input-debounce="0"
                                  @new-value="createValue"
                                  @filter="filterFn"
                                  multiple
                                  bg-color="white"
                                  label="Office"
                                  use-chips
                                  no-error-icon
                                  outlined
                                  autocomplete="off"
                        />
                    </div>

                    <div class="col-xs-12">
                        <q-input v-model="form.password"
                                 :type="state.toggle"
                                 :error="!!form.errors?.password"
                                 :error-message="form.errors?.password?.toString()"
                                 bg-color="white"
                                 label="Password"
                                 no-error-icon
                                 outlined
                                 autocomplete="new-password"
                        >
                            <template #append>
                                <q-btn @click="handleToggle" v-if="state.toggle==='password'" flat round icon="o_visibility_off"/>
                                <q-btn @click="handleToggle" v-else flat round icon="o_visibility"/>
                            </template>
                        </q-input>
                    </div>


                    <div class="col-xs-12">
                        <div class="flex q-gutter-sm">
                            <q-btn :loading="state.submitting" class="sized-btn" color="primary" label="Save" type="submit"/>
                            <q-btn class="sized-btn" color="negative" label="Cancel" outline
                                   @click="$inertia.replace(route('user.active'))"/>
                        </div>
                    </div>
                </fieldset>
            </div>
            <div class="col-xs-12 col-sm-5">
                <fieldset class="bg-white q-pa-md">
                    <legend class="q-pa-sm text-white bg-dark text-lg rounded-borders text-md">Devices</legend>
                    <q-list separator>
                        <q-item v-for="item in data.devices" :key="item.id">
                            <q-item-section avatar>
                                <q-icon v-if="item.active" color="positive" name="fiber_manual_record"/>
                                <q-icon v-else color="grey-4" name="fiber_manual_record"/>
                            </q-item-section>
                            <q-item-section>
                                <q-item-label>{{item?.name}}</q-item-label>
                                <q-item-label>{{item?.code}}</q-item-label>
                            </q-item-section>
                            <q-item-section side>
                                <q-toggle @update:model-value="handleDevice(item)" v-model="item.active" class="text-white" />
                            </q-item-section>
                            <q-btn flat round icon="delete" color="negative" @click="deleteDevice(item)"/>
                        </q-item>
                    </q-list>

                </fieldset>
            </div>


        </q-form>
    </q-page>
</template>
<script setup>
import MainLayout from "@/Layouts/MainLayout.vue";
import {router, useForm} from "@inertiajs/vue3";
import {reactive, ref} from "vue";
import {useQuasar} from "quasar";

defineOptions({
    layout: MainLayout
})
const props = defineProps(['roles','offices','data','current_offices','role'])
console.log(props.offices)
const state = reactive({
    submitting: false,
    toggle:'password',
})

// Reactive filter options state
const filterOptions = ref(props.offices || [])

// Function to handle adding new values
const createValue = (val, done) => {
  if (val.length > 0) {
    const modelValue = (form.value.offices || []).slice()

    val
      .split(/[,;|]+/)
      .map(v => v.trim())
      .filter(v => v.length > 0)
      .forEach(v => {
        // Check if the value is already in offices
        if (!props.offices.some(office => office.name === v)) {
          props.offices.push({ name: v })  // Add new office if not already present
        }
        if (modelValue.includes(v) === false) {
          modelValue.push(v)
        }
      })

    done(null)
    form.value.offices = modelValue
  }
}

// Function to filter the options based on the input value
const filterFn = (val, update) => {
  update(() => {
    if (val === '') {
      filterOptions.value = props.offices
    } else {
      const needle = val.toLowerCase()
      filterOptions.value = props.offices.filter(office =>
        office.label.toLowerCase().includes(needle)
      )
    }
  })
}

const q = useQuasar();
const form = useForm({
    full_name: props.data?.full_name,
    designation:props.data?.designation,
    mobile:props.data?.mobile,
    password:'',
    role:props?.role?.name,
    offices:props.current_offices
});

const handleDelete=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to delete it?',
        ok:'Yes',
        cancel:'No'
    })
    .onOk(()=>{
        router.delete(route('user.destroy',props.data.id),{
            preserveState: false,
            onStart:params => q.loading.show({message:'Deleting...'}),
            onFinish: params => q.loading.hide()
        })
    })
}
const handleDevice=item=>{
    q.loading.show();
    axios.put(route('device.toggle',item.id))
    .then(res=>{
        const{message}=res.data;
        q.notify({message,type:'positive'})
    })
    .finally(()=>q.loading.hide())
}
const handleDeactivate=e=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to Deactivate it?',
        ok:'Yes',
        cancel:'No'
    }).onOk(()=>{
            router.put(route('user.deactivate',props.data.id),{
                preserveState: false,
                onStart:params => q.loading.show({message:'Deactivating...'}),
                onFinish: params => q.loading.hide()
            })
        })
}
const handleActivate=val=>{
    q.dialog({
        title:'Confirmation',
        message:'Do you want to activate this account?',
        ok:'Yes',
        cancel:true
    }).onOk(()=>{
        router.put(route('user.activate',val.id),{},{
            preserveState:false
        })
    })
}
const handleToggle=val=>state.toggle=state.toggle==='password'?'text':'password'
const submit = e => {
    form.transform(data => ({office_ids: data?.offices?.map(item=>item.value), ...data}))
        .put(route('user.update',props.data?.id), {
            onStart: params => q.loading.show({message:'Updating...'}),
            onFinish: params => q.loading.hide()
        })
}
const deleteDevice = (item) => {
    q.dialog({
        title: 'Confirmation',
        message: 'Do you want to delete this device?',
        ok: 'Yes',
        cancel: 'No'
    }).onOk(() => {
        q.loading.show();
        axios.delete(route('device.destroy', item.id))
            .then(res => {
                sessionStorage.setItem('deleteMessage', res.data.message);
                window.location.reload();
            })
            .catch(err => {
                console.error(err);
            });
    });
};
window.addEventListener('load', () => {
    const message = sessionStorage.getItem('deleteMessage');
    if (message) {
        q.notify({
            type: 'positive',
            message: message
        });
        sessionStorage.removeItem('deleteMessage');
    }
});
</script>
