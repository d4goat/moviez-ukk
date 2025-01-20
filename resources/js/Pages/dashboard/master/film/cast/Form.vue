<template>
    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" id="form-cast">
        <div class="card bg-component text-bodydark">
            <!-- Header -->
             <div class="card-header flex justify-between items-center my-3">
                <h2> {{ selected ? 'Edit' : 'Add' }} Film Cast </h2>
                <button type="button" class="btn btn-md bg-red-600 hover:bg-red-700" @click="$emit('close')">
                    <i class="fa-solid fa-circle-xmark"></i> Cancel
                </button>
             </div>

             <!-- Body -->
              <div class="card-body">
                <div class="row">
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Cast Name</label>
                        <Field name="cast_name" v-model="cast.cast_name" autocomplete="off" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5" placeholder="Insert Cast Name" />
                        <ErrorMessage name="cast_name" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Film</label>
                        <Field name="film_id" v-model="cast.film_id" class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5" placeholder="Select Film">
                            <select2 class="form-select-solid" placeholder="Select FIlm" :options="films" v-model="cast.film_id" ></select2>
                        </Field>
                        <ErrorMessage name="film_id" class="text-red-500" />
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
import axios from '@/libs/axios';
import { useFilm } from '@/services';
import * as Yup from 'yup'
import { block, unblock } from '@/libs/utils';
import { toast } from 'vue3-toastify';
import { FilmCast } from '@/types';

const props = defineProps({
    selected: {
        type: String,
        default: null
    }
})

const emit = defineEmits(['close', 'refresh'])

const cast = ref<FilmCast>({} as FilmCast)

const formSchema = Yup.object().shape({
    cast_name: Yup.string().required('Name cannot be empty'),
    film_id: Yup.string().required('Film cannot be empty'),
})

const formRef = ref()

function getEdit(){
    block(document.getElementById('form-cast'))

    axios.get(`/master/film-cast/${props.selected}`)
    .then(({data}: any) => {
        cast.value = data.data
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-cast')))
}

function submit(){
    const formData = new FormData()

    formData.append('cast_name', cast.value.cast_name)
    formData.append('film_id', cast.value.film_id)

    if(props.selected){
        formData.append('_method', 'PUT')
    }

    block(document.getElementById('form-cast'))

    axios({
        method: 'post',
        url: props.selected ? `/master/film-cast/${props.selected}` : '/master/film-cast/store',
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(() => {
        toast.success('Data saved successfully')
        formRef.value.resetForm()
        emit('close')
        emit('refresh')
    }).catch((error: any) => [
        console.error(error.response.data.message),
        toast.error(error.response.data.message)
    ]).finally(() => unblock(document.getElementById('form-cast')))
}

const film = useFilm()
const films = computed(() => 
    film.data.value?.map((item: any) => ({
        id: item.id,
        text: item.title
    }))
)

onMounted(() => {
    if(props.selected){
       getEdit() 
    }
})
</script>