<script setup lang="ts">
import { ref, onMounted, computed } from 'vue';
import axios from '@/libs/axios';
import { useCities } from '@/services';
import * as Yup from 'yup'
import { toast } from 'vue3-toastify';
import { unblock, block } from '@/libs/utils';
import type { Cinema } from '@/types';
import { id } from 'element-plus/es/locale/index.mjs';

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
</script>

<template>
    <VForm>
        <div class="col-md-6">
            <label class="form-label required">Jabatan</label>
            <Field
                autocomplete="off"
                name="city"
                class="form-control form-control-solid"
                v-model="cinema.city"
            >
                <select2
                    class="form-select-solid"
                    placeholder="Pilih"
                    :options="cities"
                    v-model="cinema.city"
                ></select2>
            </Field>
            <div class="fv-plugins-message-container">
                <div class="fv-help-block">
                    <ErrorMessage name="city" />
                </div>
            </div>
        </div>
    </VForm>
</template>