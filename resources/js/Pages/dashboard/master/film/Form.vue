<template>
    <VForm @submit="submit" :validation-schema="formSchema" ref="formRef" id="form-film">
        <div class="card bg-component shadow-3 shadow-white text-bodydark1">
            <div class="card-header flex justify-between items-center my-3">
                <h2> {{ selected ? 'Edit' : 'Tambah' }} Film </h2>
                <button type="button" class="btn btn-md btn-danger" @click="$emit('close')">
                    <i class="fa-solid fa-circle-xmark"></i> Batal
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Title</label>
                        <Field autocomplete="off" name="title" type="text" placeholder="Masukkan Film Title"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.title" />
                        <ErrorMessage name="title" class="text-red-500" />
                    </div>
                    <!-- End:Input -->

                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Description</label>
                        <Field autocomplete="off" name="description" type="text" placeholder="Masukkan Film Description"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.description" />
                        <ErrorMessage name="description" class="text-red-500" />
                    </div>
                    <!-- End:Input -->

                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Duration</label>
                        <Field autocomplete="off" name="duration" oninput="this.value = this.value.replace(/[^\d,]/g, '')" type="text" placeholder="Masukkan Durasi Film"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.duration" />
                        <ErrorMessage name="duration" class="text-red-500" />
                    </div>
                    <!-- End:Input -->

                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Producer</label>
                        <Field autocomplete="off" name="producer" type="text" placeholder="Masukkan Film Producer"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.producer" />
                        <ErrorMessage name="producer" class="text-red-500" />
                    </div>
                    <!-- End:Input -->

                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Director</label>
                        <Field autocomplete="off" name="director" type="text" placeholder="Masukkan Film Director"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.director" />
                        <ErrorMessage name="director" class="text-red-500" />
                    </div>
                    <!-- End:Input -->

                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Writer</label>
                        <Field autocomplete="off" name="writer" type="text" placeholder="Masukkan Film Writer"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.writer" />
                        <ErrorMessage name="writer" class="text-red-500" />
                    </div>
                    <!-- End:Input -->

                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Release Date</label>
                        <Field autocomplete="off" name="release_date" type="text"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.release_date">
                            <date-picker v-model="film.release_date" class="rounded py-2.5" :config="{ enableTime: true, format: 'Y:m:d H:i'}"></date-picker>
                        </Field>
                        <ErrorMessage name="release_date" class="text-red-500" />
                    </div>
                    <!-- End:Input -->

                    
                    <!-- Begin:Input -->
                    <div class="col-md-4 flex flex-col mb-3">
                        <label class="form-label">Trailer</label>
                        <Field autocomplete="off" name="trailer" type="text" placeholder="Masukkan Film Trailer"
                        class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                        v-model="film.trailer" />
                        <ErrorMessage name="trailer" class="text-red-500" />
                    </div>
                    <!-- End:Input -->
                    <!-- Begin:Input -->
                    <div class="col-md-12 flex flex-col mb-3">
                        <label class="form-label">Poster</label>
                        <Field autocomplete="off" name="poster" type="text" placeholder="Masukkan Film Poster"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-2.5"
                            v-model="film.poster">
                        <file-upload :files="poster" :accepted-file-types="fileTypes" v-on:updatefiles="(file) => (poster = file)"></file-upload>
                        </Field>
                        <ErrorMessage name="poster" class="text-red-500" />
                    </div>
                    <!-- End:Input -->
                </div>
            </div>
            <div class="card-footer flex">
                <button type="submit" class="btn btn-md btn-primary ms-auto" >Submit</button>
            </div>
        </div>
    </VForm>
</template>

<script setup lang="ts">
import { onMounted, ref } from 'vue';
import * as Yup from 'yup'
import type { Film } from '@/types'
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { unblock, block } from '@/libs/utils';

const props = defineProps({
    selected: {
        type: String,
        default: null
    }
})

const film = ref<Film>({} as Film)
const fileTypes = ref(['image/jpg', 'image/png', 'image/jpeg']);
const poster = ref<any>([])

const emit = defineEmits(['close', 'refresh'])

const formRef = ref()

const formSchema = Yup.object().shape({
    title: Yup.string().required('Title cannot be empty'),
    description: Yup.string().required('Description cannot be empty'),
    duration: Yup.string().required('Duration cannot be empty'),
    producer: Yup.string().required('Producer cannot be empty'),
    director: Yup.string().required('Director cannot be empty'),
    writer: Yup.string().required('Writer cannot be empty'),
    poster: Yup.string().nullable(),
    trailer: Yup.string().nullable(),
    release_date: Yup.string().nullable(),
})

function getEdit() {
    block(document.getElementById('form-film'))

    axios.get(`/master/film/${props.selected}`)
        .then(({ data }: any) => {
            film.value = data.data
            poster.value = data.data.poster ? ['/storage/' + data.data.poster] : []
        })
        .catch((error: any) => {
            console.error(error.response.data.message)
            toast.error(error.response.data.message)
        })
        .finally(() => unblock(document.getElementById('form-film')))
}

function submit() {
    const formData = new FormData()

    formData.append('title', film.value.title)
    formData.append('description', film.value.description)
    formData.append('duration', film.value.duration)
    formData.append('producer', film.value.producer)
    formData.append('director', film.value.director)
    formData.append('writer', film.value.writer)
    formData.append('release_date', film.value.release_date)

    if (poster.value.length) {
        formData.append('poster', poster?.value[0].file)
    }

    if (film.value?.trailer) {
        formData.append('trailer', film.value.trailer)
    }

    if (props.selected) {
        formData.append('_method', 'PUT')
    }

    block(document.getElementById('form-film'))

    axios({
        method: 'post',
        url: props.selected ? `/master/film/${props.selected}` : '/master/film/store',
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(() => {
        toast.success('Success create data film')
        formRef.value.resetForm()
        emit('close')
        emit('refresh')
    }).catch((error: any) => {
        toast.error(error.response.data.message)
        console.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-film')))
}

onMounted(() => {
    if (props.selected) getEdit()
})
</script>