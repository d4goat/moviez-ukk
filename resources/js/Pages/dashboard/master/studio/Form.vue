<template>
    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" id="form-studio">
        <div class="card bg-component text-bodydark1">
            <!-- Header -->
            <div class="card-header flex justify-between items-center my-3">
                <h2> {{ selected ? 'Edit' : 'Add' }} Studio </h2>
                <button type="button" class="btn btn-md btn-danger" @click="$emit('close')">
                    <i class="fa-solid fa-circle-xmark"></i> Batal
                </button>
            </div>

            <!-- Body -->
             <div class="card-body">
                <div class="row">
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="name" class="form-label">Name</label>
                        <Field name="name" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" v-model="studio.name"
                            placeholder="Insert Studio Name"
                            type="text" autocomplete="off" />
                        <ErrorMessage name="name" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="cinema_id" class="form-label">Cinema</label>
                        <Field name="cinema_id" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" v-model="studio.cinema_id"
                            placeholder="Select Cinema"
                            type="text" autocomplete="off">
                            <select2 :options="cinemas" v-model="studio.cinema_id" class="form-select-solid" placeholder="Select Cinema"></select2>
                        </Field>
                        <ErrorMessage name="cinema_id" class="text-red-500" />
                    </div>
                </div>
             </div>

             <!-- Footer -->
              <div class="card-footer flex justify-end my-3">
                  <button class="btn btn-md btn-primary ms-auto" type="submit">Submit</button>
              </div>
        </div>
    </VForm>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import * as Yup from 'yup'
import axios from '@/libs/axios';
import { Studio } from '@/types';
import { toast } from 'vue3-toastify';
import { useCinema } from '@/services';
import { block, unblock } from '@/libs/utils';

const props = defineProps({
    selected: {
        type: String,
        default: null
    }
})

const emit = defineEmits(['close', 'refresh'])

const studio = ref<Studio>({} as Studio)
const formRef = ref()

const formSchema = Yup.object().shape({
    name: Yup.string().required('Name cannot be empty'),
    cinema_id: Yup.string().required('Cinema cannot be empty'),
})

function edit() {
    block(document.getElementById('form-studio'))

    axios.get(`/master/studio/${props.selected}`)
    .then(({ data }: any) => {
        studio.value = data.data
    })
    .catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    })
    .finally(() => unblock(document.getElementById('form-studio')))
}

function submit(){
    const formData = new FormData()

    formData.append('name', studio.value.name)
    formData.append('cinema_id', studio.value.cinema_id)
    
    if(props.selected){
        formData.append('_method', 'PUT')
    }

    block(document.getElementById('form-studio'))

    axios({
        method: 'post',
        url: props.selected ? `/master/studio/${props.selected}` : '/master/studio/store',
        data: formData,
        headers: { 'Content-Type': 'multipart/form-data' }
    })
    .then(() => {
        toast.success('Data saved successfully')
        formRef.value.resetForm()
        emit('close')
        emit('refresh')
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-studio')))
}

const cinema = useCinema()
const cinemas = computed(() => 
    cinema.data.value?.map((item: any) => ({
        id: item.id,
        text: item.name
    }))
) 

onMounted(() => {
    if(props.selected) edit()
})
</script>