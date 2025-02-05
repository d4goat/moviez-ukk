<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import axios from '@/libs/axios';
import { useCities } from '@/services';
import * as Yup from 'yup'
import { toast } from 'vue3-toastify';
import { unblock, block } from '@/libs/utils';
import type { Cinema } from '@/types';

const props = defineProps({
    selected: {
        type: String,
        default: null
    }
})

const emit = defineEmits(['close', 'refresh'])

const cinema = ref<Cinema>({} as Cinema)
const formRef = ref()

const formSchema = Yup.object().shape({
    name: Yup.string().required('Name cannot be empty'),
    city: Yup.string().required('City cannot be empty'),
    address: Yup.string().required('Address cannot be empty'),
})

function getEdit(){
    block(document.getElementById('form-cinema'))

    axios.get(`/master/cinema/${props.selected}`)
    .then(({ data } : any) => {
        cinema.value = data.data
    }).catch((error: any) =>
        toast.error(error.response.data.message)
    ).finally(() => unblock(document.getElementById('form-cinema')))
}

function submit (){
    const formData = new FormData()

    formData.append('name', cinema.value.name)
    formData.append('city', cinema.value.city)
    formData.append('address', cinema.value.address)

    block(document.getElementById('form-cinema'))

    if(props.selected){
        formData.append('_method', 'PUT')
    }

    axios({
        method: 'post',
        url: props.selected ? `/master/cinema/${props.selected}` : '/master/cinema/store',
        data: formData,
        headers: {
            "Content-Type" : "multipart/form-data"
        }
    })
    .then(() => {
        toast.success('Success create data cinema')
        formRef.value.resetForm()
        emit('close')
        emit('refresh')
    })
    .catch((error: any) => {
        toast.error(error.response.data.message)
        console.error(error.response.data.message)
    })
    .finally(() => unblock(document.getElementById('form-cinema')))
}

const city = useCities()
const cities = computed(() =>
    city.data.value?.map((item: any) => ({
        id: item.code,
        text: item.name
    }))
)

onMounted(()  => {
    if(props.selected){
        getEdit()
    }
})
</script>

<template>
    <VForm @submit="submit" :validation-schema="formSchema" ref="formRef" id="form-cinema">
        <div class="card bg-dark-bg text-bodydark1">
            <div class="card-header align-items-center flex border-b border-gray-400 justify-between my-3">
                <h2> {{ selected ? 'Edit' : 'Tambah' }} Cinema </h2>
                <button type="button" class="btn btn-md bg-red-600 hover:bg-red-700 text-white" @click="$emit('close')">
                    <i class="la la-times-circle"></i> Batal
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Name</label>
                        <Field
                            autocomplete="off"
                            name="name"
                            type="text"
                            placeholder="Masukkan Cinema Name"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-3"
                            v-model="cinema.name"
                        />
                        <ErrorMessage name="name" class="text-red-500" />
                    </div>
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label required">City</label>
                        <Field
                            autocomplete="off"
                            name="city"
                            class="form-control form-control-solid"
                            v-model="cinema.city"
                        >
                            <select2
                                class="form-select-solid"
                                placeholder="Select Cinema City"
                                :options="cities"
                                v-model="cinema.city"
                            ></select2>
                        </Field>
                        <ErrorMessage name="city" class="text-red-500" />
                    </div>
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Address</label>
                        <Field
                            autocomplete="off"
                            name="address"
                            type="text"
                            placeholder="Masukkan Cinema Address"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-3"
                            v-model="cinema.address"
                        />
                        <ErrorMessage name="address" class="text-red-500" />
                    </div>
                </div>
            </div>
            <div class="card-footer flex">
                <button type="submit" class="btn btn-md my-3 ms-auto btn-primary text-white">Submit</button>
            </div>
        </div>
    </VForm>
</template>
