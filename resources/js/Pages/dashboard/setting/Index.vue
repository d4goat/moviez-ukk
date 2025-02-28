<template>
    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" id="form-setting">
        <div class="card bg-component text-bodydark1">
            <!-- Header -->
            <div class="card-header flex items-center my-3">
                <h2 class="text-xl">Edit Setting</h2>
            </div>

            <!-- Body -->
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="name" class="form-label">Name</label>
                        <Field class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" name="name"
                            v-model="setting.name" placeholder="Insert setting Name" autocomplete="off"
                            type="text" />
                        <ErrorMessage name="name" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="description" class="form-label">Description</label>
                        <Field class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]"
                            name="description" v-model="setting.description" placeholder="Insert setting description"
                            autocomplete="off" type="text" />
                        <ErrorMessage name="description" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="email" class="form-label">Email</label>
                        <Field class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" name="email"
                            v-model="setting.email" placeholder="Insert setting email" autocomplete="off"
                            type="email" />
                        <ErrorMessage name="email" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="phone" class="form-label">Phone</label>
                        <Field oninput="this.value = this.value.replace(/[^\d,]/g, '')"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" name="phone"
                            v-model="setting.phone" placeholder="Insert setting phone" autocomplete="off"
                            type="text" />
                        <ErrorMessage name="phone" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="logo" class="form-label">Logo</label>
                        <Field class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]" name="logo"
                            v-model="setting.logo" placeholder="Insert setting logo" autocomplete="off"
                            type="text">
                            <file-upload :files="logo" :accepted-file-types="fileTypes"
                                v-on:updatefiles="(file) => (logo = file)"></file-upload>
                        </Field>
                        <ErrorMessage name="logo" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label name="image" class="form-label">Image</label>
                        <Field name="photo" class="card" v-model="setting.image" type="file">
                            <FileUploadPrime accept="image/*" name="image" choose-label="Choose" severity="secondary" class="p-button-outlined"
                                ref="filupload" @select="upload" multiple>
                                <template #empty>
                                    <span>Drag and drop files to here to upload</span>
                                </template>
                            </FileUploadPrime>
                        </Field>
                    </div>
                </div>
            </div>

            <div class="card-footer flex">
                <button type="submit" class="btn btn-md btn-primary my-3 ms-auto">Submit</button>
            </div>
        </div>
    </VForm>
</template>

<script setup lang="ts">
import { useMutation, useQuery } from '@tanstack/vue-query';
import { defineComponent, ref } from 'vue';
import axios from '@/libs/axios';
import * as Yup from 'yup'
import { block, unblock } from '@/libs/utils';
import { toast } from 'vue3-toastify';

interface Setting {
    name: string;
    description: string;
    logo: string;
    image: string;
    email: string;
    phone: number;
}

const setting = ref<Setting>({} as Setting);
const formRef = ref<any>(null)
const fileupload = ref()

const upload = (event: any) => {
    if (event.files && event.files.length > 0) {
        image.value = event.files;
    }
}

const formSchema = Yup.object().shape({
    name: Yup.string().required('Name cannot be null'),
    description: Yup.string().required('Description cannot be null'),
    logo: Yup.string().required('Logo cannot be null'),
    email: Yup.string().email().required('Email cannot be null'),
    phone: Yup.string().matches(/^08[0-9]\d{9,11}$/, 'Invalid Phone Number').required('Phone cannot be null'),
})

const fileTypes = ref(['image/jpg', 'image/png', 'image/jpeg']);
const logo = ref<any>([])
const image = ref<any>([])

function submit() {
    const formData = new FormData()

    formData.append('name', setting.value.name)
    formData.append('description', setting.value.description)
    formData.append('email', setting.value.email)
    formData.append('phone', setting.value.phone)

    if(logo.value.length) formData.append('logo', logo.value[0].file)

    if(image.value.length) {
        image.value.forEach((image: any) => {
            console.log(image)
            formData.append('image[]', image) // Tambahkan setiap file ke FormData
        })
    }


    block(document.getElementById('form-setting'))

    axios({
        method: 'post',
        url: '/setting/update',
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    }).then(() => {
        toast.success('Data saved successfully')
        formRef.value.resetForm()
        edit.refetch()
    }).catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    }).finally(() => unblock(document.getElementById('form-setting')))
}

const edit = useQuery({
    queryKey: ['setting', 'edit'],
    queryFn: async () => axios.get('/setting'),
    onSuccess: (data: any) => {
        setting.value = data.data
        unblock(document.getElementById('form-setting'))
    },
    onError: (err: any) => {
        console.error(err.response.data.message)
        toast.error(err.response.data.message)
    },
})
</script>
