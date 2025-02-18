<template>
    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" id="form-show_time">
        <div class="card bg-component text-bodydark">
            <!-- Header -->
            <div class="card-header flex justify-between items-center my-2">
                <h2> {{ selected ? 'Edit' : 'Add' }} Show Time</h2>
                <button type="button" class="btn btn-md bg-red-600 hover:bg-red-700 text-white" @click="$emit('close')">
                    <i class="la la-times-circle"></i>
                    Cancel
                </button>
            </div>

            <!-- Body -->
             <div class="card-body">
                <div class="row">
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Film</label>
                        <Field name='film_id' v-model="show_time.film_id"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5" placeholder="Select Film">
                            <select2 :options="films" v-model="show_time.film_id" class="form-select-solid" placeholder="Select Film" ></select2>
                        </Field>
                        <ErrorMessage name="film_id" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Studio</label>
                        <Field name='studio_id' v-model="show_time.studio_id"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5" placeholder="Select Film">
                            <select2 :options="studios" v-model="show_time.studio_id" class="form-select-solid" placeholder="Select Film" ></select2>
                        </Field>
                        <ErrorMessage name="studio_id" class="text-red-500" />
                    </div>
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Start Time</label>
                        <Field name="start_time" autocomplete="off" v-model="show_time.start_time" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5" placeholder="Insert Start Time">
                            <date-picker v-model="show_time.start_time" class="rounded py-2.5" :config="{ enableTime: true, noCalendar: true, dateFormat: 'H:i'}"></date-picker>
                        </Field>
                        <ErrorMessage name="start_time" class="text-red-500" />
                    </div>
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">End Time</label>
                        <Field name="end_time" autocomplete="off" v-model="show_time.end_time" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5" placeholder="Insert End Time">
                            <date-picker v-model="show_time.end_time" class="rounded py-2.5" :config="{ enableTime: true, noCalendar: true, dateFormat: 'H:i'}"></date-picker>
                        </Field>
                        <ErrorMessage name="end_time" class="text-red-500" />
                    </div>
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Price</label>
                        <Field name="price" autocomplete="off" oninput="this.value = this.value.replace(/[^\d]/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');" v-model="show_time.price" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5" placeholder="Insert Price" />
                        <ErrorMessage name="price" class="text-red-500" />
                    </div>
                </div>
             </div>

             <!-- Footer -->
              <div class="card-footer flex justify-end my-3">
                <button type="submit" class="btn btn-md btn-primary">
                    Submit
                </button>
              </div>
        </div>
    </VForm>
</template>

<script setup lang="ts">
import axios from '@/libs/axios';
import { ref, onMounted, computed } from 'vue';
import * as Yup from 'yup'
import { block, unblock } from '@/libs/utils';
import { ShowTime } from '@/types';
import { toast } from 'vue3-toastify';
import { useFilm, useStudio } from '@/services';

const props = defineProps({
    selected: {
        type: String,
        default: null
    },
    film_id: {
        type: Number,
        default: null
    }
})

const emit = defineEmits(['close', 'refresh'])

const show_time = ref<ShowTime>({
    film_id: props.film_id
} as ShowTime)
const formRef = ref()
const formSchema = Yup.object().shape({
    film_id: Yup.number().required('Film cannot be empty'),
    studio_id: Yup.number().required('Studio cannot be empty'),
    start_time: Yup.string().required('Start Time cannot be empty'),
    end_time: Yup.string().required('End Time cannot be empty'),
    price: Yup.string().required('Price cannot be empty'),
})

function getEdit(){
    block(document.getElementById('form-show_time'))

    axios.get(`/master/show-time/${props.selected}`)
    .then(({data}: any) => {
        show_time.value = data.data
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-show_time')))
}

function submit (){
    const formData = new FormData()

    formData.append('film_id', show_time.value.film_id)
    formData.append('studio_id', show_time.value.studio_id)
    formData.append('start_time', show_time.value.start_time)
    formData.append('end_time', show_time.value.end_time)
    formData.append('price', show_time.value.price)

    if(props.selected){
        formData.append('_method', 'PUT')
    }

    block(document.getElementById('form-show_time'))

    axios({
        method: 'post',
        url: props.selected ? `/master/show-time/${props.selected}` : '/master/show-time/store',
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(() => {
        toast.success('Data saved successfully')
        formRef.value.resetForm()
        emit('close')
        emit('refresh')
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-show_time')))
}

const film = useFilm()
const films = computed(() =>
    film.data.value?.map((item: any) => ({
        id: item.id,
        text: item.title
    }))
)

const studio = useStudio()
const studios = computed(() =>
    studio.data.value?.map((item: any) => ({
        id: item.id,
        text: item.name
    }))
)

onMounted(() => {
    if(props.selected) getEdit()
})
</script>
