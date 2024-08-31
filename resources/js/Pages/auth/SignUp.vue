<script setup lang="ts">
import { ref } from 'vue';
import axios from '@/libs/axios';
import type { User } from '@/types';
import * as Yup from "yup";
import { toast } from 'vue3-toastify';
import { block, unblock } from '@/libs/utils';

const user = ref<User>({} as User);
const formRef = ref()

const formSchema = Yup.object().shape({
    name: Yup.string().required(),
    email: Yup.string().email('Invalid Email').required().label('Email'),
    phone: Yup.string().matches(/^08[0-9]\d{8,11}$/, 'Invalid nomor telepon').required(),
    password: Yup.string().min(8, 'Password minimal harus diisi 8 karakter').required().label('Password'),
    passwordConfirmation: Yup.string().oneOf([Yup.ref('password')], 'Passwords harus sesuai').required().label('Password Confirmation'),
})

function submit () {
    const formData = new FormData();
    formData.append('name', user.value.name);
    formData.append('phone', user.value.phone);
    formData.append('email', user.value.email);

    if(user.value?.password){
        formData.append('password', user.value.password);
        formData.append('password_confirmation', user.value.passwordConfirmation);
    }

    block(document.getElementById('form-register'));

    axios({
        method: 'post',
        url: 'auth/register',
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(() => {
        unblock(document.getElementById('form-register'));
        toast.success("Registrasi berhasil!");
        formRef.value.resetForm();
    })
    .catch((error: any) => {
        formRef.value.setErrors(error.response.data.errors);
        toast.error(error.response.data.message);
    })
    .finally(() => {
        unblock(document.getElementById('form-register'));
    })
}


</script>

<template>
    <main>
        <div class="h-screen w-full">
            <img src="/images/bg-2.jpg" class="absolute md:pl-36 inset-0 w-full h-full object-cover" alt="">
            <div class="w-[43%] h-full bg-gray-200 z-10 absolute top-0 left-0 p-6 items-center justify-center">
                <div class="w-full h-full flex items-center justify-center">
                    <div class="w-full max-w-md flex flex-col border-[1px] border-gray-700 rounded-xl p-6 space-y-4">
                        <!-- begin:title -->
                        <h2 class="text-xl font-semibold mb-7 text-center">Registrasi</h2>
                        <!-- end:title -->

                        <VForm @submit="submit" :validation-schema="formSchema" ref="formRef" class="flex flex-col gap-5">
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Nama</label>
                                <!-- end:title:input -->
                                 <div class="flex flex-col">
                                     <Field  name="name" type="text" autocomplete="off" v-model="user.name" class="border p-2 rounded bg-transparent" placeholder="Masukkan Nama" />
                                     <ErrorMessage name="name" class="text-red-500" />
                                </div>
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Email</label>
                                <!-- end:title:input -->
                                 <div class="flex flex-col">
                                     <Field  name="email" type="text" autocomplete="off" v-model="user.email" class="border p-2 rounded bg-transparent" placeholder="Masukkan Email" />
                                     <ErrorMessage name="email" class="text-red-500" />
                                </div>
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">No Telepon</label>
                                <!-- end:title:input -->
                                 <div class="flex flex-col">
                                     <Field  name="phone" type="text" autocomplete="off" v-model="user.phone" class="border p-2 rounded bg-transparent" placeholder="Masukkan No Telepon" />
                                     <ErrorMessage name="phone" class="text-red-500" />
                                </div>
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Password</label>
                                <!-- end:title:input -->
                                 <div class="flex flex-col">
                                     <Field  name="password" type="password" autocomplete="off" v-model="user.password" class="border p-2 rounded bg-transparent" placeholder="Masukkan Password" />
                                     <ErrorMessage name="password" class="text-red-500" />
                                </div>
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Konfirmasi Password</label>
                                <!-- end:title:input -->
                                 <div class="flex flex-col">
                                     <Field  name="passwordConfirmation" type="password" autocomplete="off" v-model="user.passwordConfirmation" class="border p-2 rounded bg-transparent" placeholder="Masukkan Konfirmasi Password" />
                                     <ErrorMessage name="passwordConfirmation" class="text-red-500" />
                                </div>
                            </div>
                            <!-- end:input -->

                            <div class="flex w-full justify-center mt-3">
                                <button type="submit" class="bg-sky-600 p-4 rounded-lg text-white text-semibold text-md">Registrasi</button>
                            </div>
                        </VForm>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>