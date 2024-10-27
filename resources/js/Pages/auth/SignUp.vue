<script setup lang="ts">
import { ref } from 'vue';
import axios from '@/libs/axios';
import type { User } from '@/types';
import * as Yup from "yup";
import { toast } from 'vue3-toastify';
import { block, unblock } from '@/libs/utils';
import { useRouter } from 'vue-router';

const user = ref<User>({} as User);
const formRef = ref()
const router = useRouter()
const isLoading = ref(false)

const formSchema = Yup.object().shape({
    name: Yup.string().required(),
    email: Yup.string().email('Invalid Email').required().label('Email'),
    phone: Yup.string().matches(/^08[0-9]\d{8,11}$/, 'Invalid nomor telepon').required(),
    password: Yup.string().min(8, 'Password minimal harus diisi 8 karakter').required().label('Password'),
    passwordConfirmation: Yup.string().oneOf([Yup.ref('password')], 'Passwords harus sesuai').required().label('Password Confirmation'),
})

function submit () {
    block(document.getElementById('form-register'));
    const formData = new FormData();
    formData.append('name', user.value.name);
    formData.append('phone', user.value.phone);
    formData.append('email', user.value.email);

    if(user.value?.password){
        formData.append('password', user.value.password);
        formData.append('password_confirmation', user.value.passwordConfirmation);
    }
    isLoading.value = true

    axios({
        method: 'post',
        url: 'auth/register',
        data: formData,
        headers: {
            'Content-Type': 'multipart/form-data'
        }
    })
    .then(() => {
        toast.success("Registrasi berhasil!");
        formRef.value.resetForm();
        router.push('/sign-in')
        isLoading.value = false
    })
    .catch((error: any) => {
        toast.error(error.response.data.message);
    })
    .finally(() => {
        unblock(document.getElementById('form-register'));
    })
}


</script>

<template>
    <VForm @submit="submit" :validation-schema="formSchema" ref="formRef" id="form-register" class="w-full h-full min-h-screen flex justify-center bg-[#171717] items-center p-4">
        <div class="w-full max-w-sm md:max-w-md lg:max-w-lg flex flex-col justify-center md:space-y-2 sm:space-y-6">
          <!-- begin:title -->
          <div class="font-medium text-center flex flex-col mb-3">
            <span class="text-xl sm:text-2xl">Registrasi</span>
            <i class="text-3xl sm:text-4xl text-cinema">Cinema51</i>
          </div>
          <!-- end:title -->
          <div class="flex flex-col gap-[10px]">
            <!-- begin:input -->
            <div class="flex flex-col gap-2">
              <label class="text-sm sm:text-lg font-poppins">Nama</label>
              <div class="flex flex-col">
                <Field name="name" type="text" autocomplete="off" v-model="user.name" class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-2.5 sm:p-3 text-sm sm:text-sm" placeholder="Masukkan Nama" />
                <ErrorMessage name="name" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <!-- end:input -->
            <!-- begin:input -->
            <div class="flex flex-col gap-2">
              <label class="text-sm sm:text-lg font-medium">Email</label>
              <div class="flex flex-col">
                <Field name="email" type="text" autocomplete="off" v-model="user.email" class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-2.5 sm:p-3 text-sm sm:text-sm" placeholder="Masukkan Email" />
                <ErrorMessage name="email" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <!-- end:input -->
            <!-- begin:input -->
            <div class="flex flex-col gap-2">
              <label class="text-sm sm:text-lg font-medium">No Telepon</label>
              <div class="flex flex-col">
                <Field name="phone" type="text"
                oninput="this.value = this.value.replace(/[^\d,]/g, '')"
                autocomplete="off" v-model="user.phone" class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-2.5 sm:p-3 text-sm sm:text-sm" placeholder="Masukkan No Telepon" />
                <ErrorMessage name="phone" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <!-- end:input -->
            <!-- begin:input -->
            <div class="flex flex-col gap-2">
              <label class="text-sm sm:text-lg font-medium">Password</label>
              <div class="flex flex-col">
                <Field name="password" type="password" autocomplete="off" v-model="user.password" class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-2.5 sm:p-3 text-sm sm:text-sm" placeholder="Masukkan Password" />
                <ErrorMessage name="password" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <!-- end:input -->
            <!-- begin:input -->
            <div class="flex flex-col gap-2">
              <label class="text-sm sm:text-lg font-medium">Konfirmasi Password</label>
              <div class="flex flex-col">
                <Field name="passwordConfirmation" type="password" autocomplete="off" v-model="user.passwordConfirmation" class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-2.5 sm:p-3 text-sm sm:text-sm" placeholder="Masukkan Konfirmasi Password" />
                <ErrorMessage name="passwordConfirmation" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <!-- end:input -->
            <div class="flex w-full justify-center mt-6">
              <button type="submit" :disabled="isLoading" :class="isLoading ? 'flex p-2 justify-center' : 'block'" class="bg-cinema py-2.5 px-4 w-full sm:w-2/3 md:w-1/3 rounded-lg text-white font-semibold text-sm sm:text-sm">
                <svg v-if="isLoading" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
              </svg>
                <span v-if="!isLoading">Register</span>
              </button>
            </div>
            <div class="flex w-full justify-center text-center sm:text-base">
              <span>Already have an account? <router-link :to="{name: 'sign-in'}" class="text-cinema">Login Now</router-link></span>
            </div>
          </div>
        </div>
      </VForm>
</template>