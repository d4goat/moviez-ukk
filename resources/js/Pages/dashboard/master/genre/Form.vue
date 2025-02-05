<template>
    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" id="form-genre">
        <div class="card bg-dark-bg text-bodydark1">
            <div class="card-header border-b border-gray-400 flex justify-between items-center my-3">
                <h2> {{ selected ? 'Edit' : 'Add' }} Genre </h2>
                <button type="button" class="btn btn-md bg-red-600 hover:bg-red-700 text-white" @click="$emit('close')">
                    <i class="la la-times-circle"></i> Batal
                </button>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-md-6 flex flex-col">
                        <label class="form-label">Name</label>
                        <Field autocomplete="off" name="name" type="text" placeholder="Masukkan Genre Name"
                        class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                        v-model="genre.name" />
                    <ErrorMessage name="name" class="text-red-500" />
                </div>
                <div class="mb-3 col-md-6 flex flex-col">
                    <label class="form-label">Description</label>
                    <Field autocomplete="off" name="description" type="text" placeholder="Masukkan Genre Description"
                        class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                        v-model="genre.description" />
                        <ErrorMessage name="description" class="text-red-500" />
                    </div>
                </div>
            </div>
            <div class="card-footer flex">
                <button type="submit" class="btn btn-md btn-primary ms-auto">Submit</button>
            </div>
        </div>
    </VForm>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import * as Yup from 'yup'
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { unblock, block } from '@/libs/utils';
import type { Genre } from '@/types';

const props = defineProps({
    selected: {
        type: String,
        default: null
    }
})

const emit = defineEmits(['close', 'refresh'])

const genre = ref<Genre>({} as Genre)
const formRef = ref()

const formSchema = Yup.object().shape({
    name: Yup.string().required('Name cannot be empty'),
    description: Yup.string().required('Description cannot be empty'),
})

function getEdit(){
    block(document.getElementById('form-genre'))
    axios.get(`/master/genre/${props.selected}`)
    .then(({data} : any) => {
        genre.value = data.data
    }).catch((error : any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-genre')))
}

function submit (){
    const formData = new FormData()

    formData.append('name', genre.value.name)
    formData.append('description', genre.value.description)

    if(props.selected){
        formData.append('_method', 'PUT')
    }

    block(document.getElementById('form-genre'))

    axios({
        method: 'post',
        url: props.selected ? `/master/genre/${props.selected}` : '/master/genre/store',
        data: formData,
        headers: { 'Content-Type': 'multipart/form-data' }
    }).then(() => {
        toast.success('Data saved successfully')
        formRef.value.resetForm()
        emit('close')
        emit('refresh')
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-genre')))
}

onMounted(() => {
    if(props.selected) getEdit()
})
</script>
