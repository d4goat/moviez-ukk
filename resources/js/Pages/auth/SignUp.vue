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

interface Users extends User{
  passwordConfirmation: string
}

const user = ref<Users>({} as Users);
const formRef = ref()
const router = useRouter()
const otpCode = ref(['', '', '', '', '', ''])

const steps = [
  { label: "Personal Info", icon: 'pi pi-user' },
  { label: "Password", icon: 'pi pi-lock' },
  { label: "OTP Verification", icon: 'pi pi-key' },
]

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

const { mutate: sendOtp, isLoading: isLoadingSendOtp } = useMutation({
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

const { mutate: verifyOtp, isLoading: isLoadingVerifyOtp } = useMutation({
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

const prevInput = (event: KeyboardEvent, index: number) => {
  if (event.key === 'Backspace' && index > 0) {
    const prevInput = document.querySelectorAll('#index')[index - 1] as HTMLInputElement;
    if (prevInput) prevInput.focus();
  }
}
</script>

<template>
  <VForm :validation-schema="formSchema" ref="formRef" id="form-register"
    class="w-full h-full min-h-screen flex justify-center items-center p-4">
    <div class="w-full max-w-sm md:max-w-md lg:max-w-lg flex flex-col justify-center bg-border p-8 rounded-xl space-y-8">
      <!-- begin:title -->
      <div v-if="activeTab == 3" class="text-center">
        <h2 class="text-2xl font-semibold">Verify Your Email</h2>
        <p class="text-sm">We've sent a verification code to your email</p>
      </div>
      <div v-else class="font-medium text-center flex flex-col mb-3">
        <h1 class="text-2xl font-semibold tracking-tight">Create Account</h1>
        <p class="text-lg">Welcome to <i class="text-cinema">{{ setting?.name }}</i></p>
      </div>
      <Steps class="mb-3" :model="steps" :active-step="activeTab - 1" />
      <!-- end:title -->
      <div class="flex flex-col gap-6">
          <div v-if="activeTab === 1" class="flex flex-col gap-6">
            <div class="flex flex-col gap-2">
              <div class="flex flex-col">
                <Field name="name" type="text" autocomplete="off" v-model="user.name"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm">
                  <FloatLabel variant="in">
                    <InputText v-model="user.name" class="w-full" autocomplete="off" id="name" />
                    <label for="name">Name</label>
                  </FloatLabel>
                </Field>
                <ErrorMessage name="name" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <div class="flex flex-col">
                <Field name="email" type="text" autocomplete="off" v-model="user.email"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm">
                  <FloatLabel variant="in">
                    <InputText v-model="user.email" autocomplete="off" class="w-full" id="email" />
                    <label for="email">Email</label>
                  </FloatLabel>  
                </Field>
                <ErrorMessage name="email" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <div class="flex flex-col gap-2">
              <div class="flex flex-col">
                <Field name="phone" type="text"
                  autocomplete="off" v-model="user.phone"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm">
                  <FloatLabel variant="in">
                    <InputText v-model="user.phone" oninput="this.value = this.value.replace(/[^\d,]/g, '')" class="w-full" autocomplete="off" id="phone" />
                    <label for="phone">Phone</label>
                  </FloatLabel>  
                </Field>
                <ErrorMessage name="phone" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
          </div>
          <div v-if="activeTab === 2">
            <div class="flex flex-col gap-2 mb-3">
              <div class="flex flex-col relative">
                <div class="flex flex-col relative">
                  <Field name="password" type="password" autocomplete="off" v-model="user.password"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm">
                  <FloatLabel variant="in">
                    <Password class="w-full" input-class="w-full" v-model="user.password" toggle-mask input-id="password" :feedback="false" />
                    <label for="password">Password</label>
                  </FloatLabel>  
                </Field>
                </div>
                  <ErrorMessage name="password" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
            <div class="flex flex-col gap-2 mb-3">
              <div class="flex flex-col relative">
                <div class="flex flex-col relative">
                  <Field name="passwordConfirmation" type="password" autocomplete="off"
                  v-model="user.passwordConfirmation"
                  class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-sm"
                  placeholder="Insert Password Confirmation..">
                  <FloatLabel variant="in">
                    <Password v-model="user.passwordConfirmation" class="w-full" input-class="w-full" toggle-mask input-id="password-confirmation" :feedback="false" />
                    <label for="password-confirmation">Password Confirmation</label>
                  </FloatLabel>  
                </Field>
                </div>
                <ErrorMessage name="passwordConfirmation" class="text-red-500 text-xs sm:text-sm mt-1" />
              </div>
            </div>
          </div>
          <div v-if="activeTab === 3">
            <div class="flex flex-col gap-4 mb-5">
              <div class="flex flex-row justify-center gap-2">
                <InputText v-for="(i, index) in otpCode" :key="index" type="text" v-model="otpCode[index]"
                @input="nextInput($event, index)" @keydown="prevInput($event, index)" id="index"
                class="text-center text-white bg-[#232323] rounded w-13 h-13 text-lg" maxlength="1" />
              </div>
            </div>
          </div>
        <div class="flex justify-between space-x-4">
          <Button
            v-if="activeTab > 1 && activeTab < 3"
            label="Previous"
            class="p-button-outlined w-1/3"
            @click="activeTab--"
          />
          <Button
            v-if="activeTab < 2"
            label="Next"
            class="p-button-outlined w-1/3 ml-auto"
            @click="activeTab++"
          />
          <Button
            v-if="activeTab === 2"
            label="Send OTP"
            class="p-button-outlined w-1/3"
            :loading="isLoadingSendOtp"
            @click="() => sendOtp()"
          />
          <Button
            v-if="activeTab === 3"
            label="Verify & Register"
            class="p-button-outlined w-full"
            :loading="isLoadingVerifyOtp"
            @click="() => verifyOtp()"
          />
        </div>
        <div class="flex w-full justify-center text-center sm:text-base">
          <span>Already have an account? <router-link :to="{ name: 'sign-in' }" class="text-cinema font-medium">Sign in</router-link></span>
        </div>
      </div>
    </div>
  </VForm>
</template>