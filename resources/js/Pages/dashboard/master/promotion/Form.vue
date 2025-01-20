<template>
    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" id="form-promotion">
        <div class="card bg-component text-bodydark1">
            <div class="card-header flex justify-between items-center my-3">
                <h2> {{ selected ? 'Edit' : 'Add' }} Promotion </h2>
                <button type='button' class="btn btn-md bg-red-600 hover:bg-red-700" @click="$emit('close')">
                    <i class="fa fa-solid fa-circle-xmark"></i> Batal
                </button>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="mb-3 col-md-6 flex flex-col">
                        <label class="form-label">Name</label>
                        <Field autocomplete="off" name="name" type="text" placeholder="Masukkan Promotion Name"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="promotion.name" />
                        <ErrorMessage name="name" class="text-red-500" />
                    </div>
                    <div class="mb-3 col-md-6 flex flex-col">
                        <label class="form-label">Description</label>
                        <Field autocomplete="off" name="description" type="text"
                            placeholder="Masukkan Promotion Description"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="promotion.description" />
                        <ErrorMessage name="description" class="text-red-500" />
                    </div>
                    <div class="mb-3 col-md-6 flex flex-col">
                        <label class="form-label">Discount</label>
                        <Field autocomplete="off" name="discount" type="text"
                            placeholder="Masukkan Promotion Discount"
                            oninput="this.value = this.value.replace(/[^\d]/g, '')"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="promotion.discount" />
                        <ErrorMessage name="discount" class="text-red-500" />
                    </div>
                    <div class="mb-3 col-md-6 flex flex-col">
                        <label class="form-label">Code</label>
                        <Field autocomplete="off" name="code" type="text"
                            placeholder="Masukkan Promotion Code"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="promotion.code" />
                        <ErrorMessage name="code" class="text-red-500" />
                    </div>
                    <div class="mb-3 col-md-6 flex flex-col">
                        <label class="form-label">Start Date</label>
                        <Field autocomplete="off" name="start_date" type="text"
                            placeholder="Masukkan Promotion Start Date"
                            class="form-control form-control-solid"
                            v-model="promotion.start_date">
                            <date-picker v-model="promotion.start_date" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px] " :config="{ enableTime: false, format: 'Y:m:d H:i'}"></date-picker>
                        </Field>
                        <ErrorMessage name="start_date" class="text-red-500" />
                    </div>
                    <div class="mb-3 col-md-6 flex flex-col">
                        <label class="form-label">End Date</label>
                        <Field autocomplete="off" name="end_date" type="text" placeholder="Masukkan Promotion End Date"
                            class="form-control form-control-solid"
                            v-model="promotion.end_date" >
                        <date-picker class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" v-model="promotion.end_date" :config="{ enableTime: false, format: 'Y:m:d H:i'}"></date-picker>
                        </Field>
                        <ErrorMessage name="end_date" class="text-red-500" />
                    </div>
                </div>
            </div>

            <div class="card-footer flex">
                <button class="btn btn-md btn-primary ms-auto my-3" type="submit">Submit</button>
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
import type { Promotion } from '@/types';

const props = defineProps({
    selected: {
        type: String,
        default: null
    }
})

const emit = defineEmits(['close', 'refresh'])

const promotion = ref<Promotion>({} as Promotion)
const formRef = ref()

const formSchema = Yup.object().shape({
    name: Yup.string().required('Name cannot be empty'),
    description: Yup.string().required('Description cannot be empty'),
    start_date: Yup.string().required('Start Date cannot be empty'),
    end_date: Yup.string().required('End Date cannot be empty'),
    code: Yup.string().required('Code cannot be empty'),
    discount: Yup.number().required('Discount cannot be empty').label('Discount'),
})

function getEdit() {
    block(document.getElementById('form-promotion'))
    axios.get(`/master/promotion/${props.selected}`)
        .then(({ data }: any) => {
            promotion.value = data.data
        }).catch((error: any) => {
            console.error(error.response.data.message)
            toast.error(error.response.data.message)
        }).finally(() => unblock(document.getElementById('form-promotion')))
}

function submit() {
    const formData = new FormData()

    formData.append('name', promotion.value.name)
    formData.append('description', promotion.value.description)
    formData.append('start_date', promotion.value.start_date)
    formData.append('end_date', promotion.value.end_date)
    formData.append('code', promotion.value.code)
    formData.append('discount', promotion.value.discount)

    block(document.getElementById('form-promotion'))

    if (props.selected) {
        formData.append('_method', 'PUT')
    }

    axios({
        method: 'post',
        url: props.selected ? `/master/promotion/${props.selected}` : '/master/promotion/store',
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
    }).finally(() => unblock(document.getElementById('form-promotion')))
}

onMounted(() => {
    if (props.selected) getEdit()
})
</script>