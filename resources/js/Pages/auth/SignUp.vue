<script setup lang="ts">
import { ref } from 'vue';
import axios from '@/libs/axios';
import type { User } from '@/types';
import * as Yup from "yup";
import { toast } from 'vue3-toastify';
import { block, unblock } from '@/libs/utils';
import { useRouter } from 'vue-router';
import { useSetting } from '@/services';
import { useMutation } from '@tanstack/vue-query';

const user = ref<User>({} as User);
const formRef = ref()
const router = useRouter()
const isLoading = ref(false)
const otpCode = ref(['', '', '', '', '', ''])

const { data: setting = {} } = useSetting()

const show = ref(false)
const showConfirm = ref(false)

const activeTab = ref(1)

const formSchema = Yup.object().shape({
  name: Yup.string().required(),
  email: Yup.string().email('Invalid Email').required().label('Email'),
  phone: Yup.string().matches(/^08[0-9]\d{8,11}$/, 'Invalid nomor telepon').required(),
  password: Yup.string().min(8, 'Password minimal harus diisi 8 karakter').required().label('Password'),
  passwordConfirmation: Yup.string().oneOf([Yup.ref('password')], 'Passwords harus sesuai').required().label('Password Confirmation'),
  otp: Yup.string().length(6, 'Kode OTP harus 6 digit').matches(/^[0-9]+$/, 'OTP hanya boleh berisi angka').required().label('OTP'),
})

const { mutate: sendOtp } = useMutation({
  mutationKey: ['send-otp'],
  mutationFn: () => {
    const data = new FormData()
    data.append('name', user.value.name)
    data.append('email', user.value.email)
    data.append('phone', user.value.phone)

    if (user.value?.password) {
      data.append('password', user.value.password)
      data.append('password_confirmation', user.value.passwordConfirmation)
    }

    return axios.post("/auth/send-otp", data)
  },
  onMutate: () => block(document.getElementById('form-register')),
  onSuccess: () => {
    unblock(document.getElementById('form-register'))
    toast.success("Kode verifikasi berhasil dikirim ke nomor telepon yang anda masukkan")
    activeTab.value = 3
  },
  onError: (err: any) => {
    toast.error(err.response.data.message)
    console.error(err.response.data.message)
    unblock(document.getElementById('form-register'))
  }
})

const { mutate: verifyOtp } = useMutation({
  mutationKey: ['verify-otp'],
  mutationFn: () => {
    const data = new FormData()
    data.append('otp', otpCode.value.join(''))
    data.append('email', user.value.email)

    return axios.post("/auth/register", data)
  },
  onMutate: () => block(document.getElementById('form-register')),
  onSuccess: () => {
    unblock(document.getElementById('form-register'))
    toast.success("Registrasi berhasil")
    router.push({ name: 'sign-in' })
  },
  onError: (err: any) => {
    toast.error(err.response.data.message)
    console.error(err.response.data.message)
    unblock(document.getElementById('form-register'))
  }
})

const nextInput = (event: Event, index: number) => {
  const input = event.target as HTMLInputElement
  if (input.value.length === 1 && index !== otpCode.value.length - 1) {
    const nextInput = document.querySelectorAll<HTMLInputElement>('#index')[index + 1];
    if (nextInput) nextInput.focus();
  }
}

function togglePassword() {
  const passwordField = document.querySelector(["input[name='password']"]);
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    show.value = true
  } else {
    passwordField.type = 'password';
    show.value = false
  }
}

function togglePasswordConfirmation() {
  const passwordField = document.querySelector(["input[name='passwordConfirmation']"]);
  if (passwordField.type === 'password') {
    passwordField.type = 'text';
    showConfirm.value = true
  } else {
    passwordField.type = 'password';
    showConfirm.value = false
  }
}

</script>

<template>
  <VForm :validation-schema="formSchema" ref="formRef" id="form-register"
    class="w-full h-full min-h-screen flex justify-center items-center p-4">
    <div class="w-full max-w-sm md:max-w-md lg:max-w-lg flex flex-col justify-center md:space-y-2 sm:space-y-6">
      <!-- begin:title -->
      <div v-if="activeTab !== 3" class="font-medium text-center flex flex-col mb-3">
        <span class="text-lg sm:text-xl">Registration</span>
        <i class="text-2xl sm:text-3xl text-cinema">{{ setting?.name }}</i>
      </div>
      <!-- end:title -->
      <div class="flex flex-col gap-4">
        <TransitionGroup enter-active-class="transition duration-300 ease-out"
          enter-from-class="transform opacity-0 absolute translate-x-4"
          enter-to-class="transform opacity-100 translate-x-0" leave-active-class="transition duration-300 ease-in"
          leave-from-class="transform opacity-100 translate-x-0"
          leave-to-class="transform opacity-0 absolute translate-x-4">
          <div v-if="activeTab === 1">
            <div class="flex flex-col gap-2 mb-3">
              <label class="text-sm sm:text-base font-poppins">Name</label>
              <div class="flex flex-col">
                <Field name="name" type="text" autocomplete="off" v-model="user.name"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm"
                  placeholder="Chris John, etc.." />
                <ErrorMessage name="name" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <div class="flex flex-col gap-2 mb-3">
              <label class="text-sm sm:text-base font-medium">Email</label>
              <div class="flex flex-col">
                <Field name="email" type="text" autocomplete="off" v-model="user.email"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm"
                  placeholder="chris@jhon.com, etc.." />
                <ErrorMessage name="email" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <div class="flex flex-col gap-2 mb-3">
              <label class="text-sm sm:text-base font-medium">Phone Number</label>
              <div class="flex flex-col">
                <Field name="phone" type="text" oninput="this.value = this.value.replace(/[^\d,]/g, '')"
                  autocomplete="off" v-model="user.phone"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm"
                  placeholder="0812345678, etc.." />
                <ErrorMessage name="phone" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
          </div>
          <div v-if="activeTab === 2">
            <div class="flex flex-col gap-2 mb-3">
              <label class="text-sm sm:text-base font-medium">Password</label>
              <div class="flex flex-col relative">
                <div class="flex flex-col relative">
                  <Field name="password" type="password" autocomplete="off" v-model="user.password"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm"
                  placeholder="Insert Password.." />
                  
                  <span class="absolute right-0 top-4 flex pr-3 cursor-pointer">
                    <i :class="['fa-regular text-lg sm:text-xl', show ? 'fa-eye' : 'fa-eye-slash']" @click="togglePassword"></i>
                  </span>
                </div>
                  <ErrorMessage name="password" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <div class="flex flex-col gap-2 mb-3">
              <label class="text-sm sm:text-base font-medium">Password Confirmation</label>
              <div class="flex flex-col relative">
                <div class="flex flex-col relative">
                  <Field name="passwordConfirmation" type="password" autocomplete="off"
                  v-model="user.passwordConfirmation"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm"
                  placeholder="Insert Password Confirmation.." />

                  <span class="absolute right-0 top-4 flex pr-3 cursor-pointer">
                    <i :class="['fa-regular text-lg sm:text-xl', showConfirm ? 'fa-eye' : 'fa-eye-slash']" @click="togglePasswordConfirmation"></i>
                  </span>
                </div>
                <ErrorMessage name="passwordConfirmation" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
          </div>
          <div v-if="activeTab === 3">
            <div class="flex flex-col gap-4 mb-5">
              <div class="flex flex-col text-center">
                <label class="text-2xl mb-2 font-semibold">Register Account</label>
                <label class="text-sm">We are sending the OTP into your email</label>
                <label for="" class="text-sm">to validate your registration</label>
              </div>
              <div class="flex flex-row justify-center gap-4">
                <input v-for="(i, index) in otpCode" :key="i" type="text" v-model="otpCode[index]"
                @input="nextInput($event, index)" id="index"
                class="text-center text-white bg-[#232323] rounded w-13 h-13 text-lg" maxlength="1">
              </div>
            </div>
          </div>
        </TransitionGroup>
        <div :class="['flex w-full', activeTab === 2 ? 'justify-between' : 'justify-end']">
          <button v-show="activeTab !== 3" type='button'
            class="bg-cinema py-2.5 px-4 w-full sm:w-2/4 md:w-1/4 rounded-lg text-white font-semibold text-sm sm:text-sm"
            @click="activeTab = activeTab === 1 ? 2 : 1">{{ activeTab === 1 ? 'Next' : 'Previous' }}
          </button>
          <button v-show="activeTab === 2" type="submit" @click="sendOtp" :disabled="isLoading || !user"
            :class="isLoading ? 'flex p-2 justify-center' : 'block'"
            class="bg-cinema py-2.5 px-4 w-full sm:w-2/4 md:w-1/4 rounded-lg text-white font-semibold text-sm sm:text-sm">
            <svg v-if="isLoading" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span v-if="!isLoading">Send OTP</span>
          </button>
          <button v-show="activeTab === 3" type="submit" @click="verifyOtp" :disabled="isLoading || !user || !otpCode"
            :class="isLoading ? 'flex p-2 justify-center' : 'block'"
            class="bg-cinema py-2.5 px-4 w-full sm:w-2/4 md:w-1/4 rounded-lg text-white font-semibold text-sm sm:text-sm">
            <svg v-if="isLoading" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none"
              viewBox="0 0 24 24">
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span v-if="!isLoading">Register</span>
          </button>
        </div>
        <div class="flex w-full justify-center text-center sm:text-base">
          <span>Already have an account? <router-link :to="{ name: 'sign-in' }" class="text-cinema">Login
              Now</router-link></span>
        </div>
      </div>
    </div>
  </VForm>
</template>