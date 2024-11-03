<template>
    <VForm @submit="submit" class="w-full" id="form-user" :validation-schema="formSchema">
        <div class="card-header flex flex-col pb-3 border-b border-gray-700">
            <span class="font-medium">Personal Information</span>
            <span class="text-sm text-gray-300">Update Profile</span>
        </div>
        <div class="card-body flex flex-col space-y-6 my-3">
            <div class="form-group flex space-x-3 justify-between">
                <label name="photo" class="form-label font-medium">Photo Profile</label>
                <div class="col-md-10">
                    <Field name="photo"
                        class="bg-[#232323] col-md-6 border-none  focus:ring-[#7C7C7C] rounded-xl p-[11px]"
                        v-model="user.photo" type="file">
                        <file-upload :files="photo" :accepted-file-types="fileTypes"
                            v-on:updatefiles="(file) => (photo = file)"></file-upload>
                    </Field>
                </div>
                <ErrorMessage name="photo" class="text-red-500" />
            </div>
            <div class="flex justify-between items-center">
                <label name="name" class="form-label font-medium">Nama</label>
                <Field class="bg-dropdown border-none col-md-10 focus:ring-[#7C7C7C] rounded-xl p-[12px]" name="name"
                    v-model="user.name" placeholder="Masukkan nama anda" autocomplete="off" type="text" />
                <ErrorMessage name="name" class="text-red-500" />
            </div>
            <div class="flex justify-between items-center">
                <label name="email" class="form-label font-medium">Email</label>
                <Field class="bg-dropdown border-none col-md-10 focus:ring-[#7C7C7C] rounded-xl p-[12px]" name="email"
                    v-model="user.email" placeholder="Masukkan email anda" autocomplete="off" type="text" />
                <ErrorMessage name="email" class="text-red-500" />
            </div>
            <div class="flex justify-between items-center">
                <label for="phone" name="phone" class="form-label font-medium">No Telepon</label>
                <Field class="bg-dropdown border-none col-md-10 focus:ring-[#7C7C7C] rounded-xl p-[12px]" name="phone"
                    v-model="user.phone" oninput="this.value = this.value.replace(/[^\d,]/g, '')"
                    placeholder="Masukkan phone anda" autocomplete="off" type="text" />
                <ErrorMessage name="phone" class="text-red-500" />
            </div>
        </div>
        <div class="card-footer flex pt-3 border-t border-gray-700">
            <button type="submit" class="btn btn-md text-white bg-cyan-600 hover:bg-cyan-700 shadow-3 shadow-cyan-300/60 ms-auto">Save</button>
        </div>
    </VForm>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import * as yup from 'yup';
import { useMutation } from '@tanstack/vue-query';
import { block, unblock } from '@/libs/utils';
import { useAuthStore } from '@/stores/auth';
import { toast } from 'vue3-toastify';
import axios from '@/libs/axios';

export default defineComponent({
    setup() {
        const photo = ref([])
        const fileTypes = ref(['image/jpg', 'image/png', 'image/jpeg']);

        const formSchema = yup.object().shape({
            name: yup.string().required('Field nama harus diisi'),
            email: yup.string().email('Invalid Email').required('Field email harus diisi'),
            phone: yup.string().matches(/^08[0-9]\d{8,11}$/, 'Invalid Phone Number').required('Field nomor telepon harus diisi'),
        })

        const { user, setAuth } = useAuthStore()
        
        return {
            photo,
            fileTypes,
            formSchema,
            user,
            setAuth
        }
    },
    methods: {
        submit(){
            const data = new FormData(document.getElementById('form-user') as HTMLFormElement)

            if(this.photo.length > 0){
                data.append('photo', this.photo[0].file)
            }

            block(document.getElementById('form-user') as HTMLFormElement)

            axios.post('/master/users/update/akun', data).then((res: any) => {
                toast.success(res.data.message)
                this.setAuth(res.data.data)
            }).catch((err: any) => {
                toast.error(err.response.data.message)
                console.error(err.response.data.message)
            }).finally(() => unblock(document.getElementById('form-user') as HTMLFormElement))
        }
    }
})
</script>