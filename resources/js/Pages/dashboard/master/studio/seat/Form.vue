<template>
    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" id="form-seat">
        <div class="card bg-component text-bodydark1">
            <!-- Header -->
            <div class="card-header flex justify-between items-center my-3">
                <h2> {{ selected ? 'Edit' : 'Add' }} Seat </h2>
                <button type="button" @click="$emit('close')" class="btn btn-md btn-danger">
                    <i class="fa-solid fa-circle-xmark"></i> Cancel
                </button>
            </div>

            <!-- Body -->
             <div class="card-body">
                <div class="row">
                    <div class="col-md-6 flex flex-col">
                        <label name="seat_number" class="form-label">Seat Number</label>
                        <Field name="seat_number" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" v-model="seat.seat_number" aria-autocomplete="off" type="text" oninput="this.value = this.value.replace(/[^0-9]/g,'')" placeholder="Insert Seat Number" />
                        <ErrorMessage name="name" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col">
                        <label name="studio_id" class="form-label">Studio</label>
                        <Field name="studio_id" class="bg-[#232323] border-none focus:ring-[#7c7c7c7] rounded-xl p-[11px]" v-model="seat.studio_id"
                            placeholder="Select Studio"
                            type="text" autocomplete="off">
                            <select2 :options="studios" v-model="seat.studio_id" class="form-select-solid" placeholder="Select Studio" />
                        </Field>
                        <ErrorMessage name="studio_id" class="text-red-500" />
                    </div>
                </div>
             </div>

             <!-- Footer -->
              <div class="card-footer flex justify-end my-3">
                <button class="btn btn-md btn-primary" type="submit">Submit</button>
            </div>
        </div>
    </VForm>
</template>

<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import axios from '@/libs/axios';
import * as Yup from 'yup'
import { toast } from 'vue3-toastify';
import { block, unblock } from '@/libs/utils';
import { useStudio } from '@/services';
import { Seat } from '@/types';

const props = defineProps({
    selected: {
        default: null,
        type: String
    }
})

const emit = defineEmits(['close', 'refresh'])

const seat = ref<Seat>({} as Seat)
const formRef = ref()
const formSchema = Yup.object().shape({
    seat_number: Yup.number().required('Seat Number cannot be empty'),
    studio_id: Yup.number().required('Studio cannot be empty'),
})

function getEdit (){
    block(document.getElementById('form-seat'))

    axios.get(`/master/studio-seats/${props.selected}`)
    .then(({ data }: any) => {
        seat.value = data.data
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-seat')))
}

function submit () {
    const formData = new FormData()

    formData.append('seat_number', seat.value.seat_number)
    formData.append('studio_id', seat.value.studio_id)

    block(document.getElementById('form-seat'))

    if(props.selected) formData.append('_method', 'PUT')

    axios({
        method: 'post',
        url: props.selected ? `/master/seat/${props.selected}` : '/master/seat/store',
        data: formData,
        headers: { 'Content-Type': 'multipart/form-data' }
    }).then((res: any) => {
        toast.success(res.data.message)
        emit('refresh')
        emit('close')
        formRef.value.resetForm()
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-seat')))
}

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