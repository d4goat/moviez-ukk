<template>
    <div class="flex justify-center min-h-screen w-full items-center">
        <div class="w-full max-w-md lg:max-w-lg flex flex-col justify-center rounded-xl p-8">
            <div class="flex justify-center mb-10">
                <div class="bg-blue-500/20 p-3 rounded-full">
                    <Key v-if="activeTab === 1" class="text-blue-400 w-7 h-7" />
                    <MailOpen v-if="activeTab === 2" class="text-blue-400 w-7 h-7" />
                    <Lock v-if="activeTab === 3" class="text-blue-400 w-7 h-7" />
                </div>
            </div>

            <div v-if="activeTab === 1" class="flex flex-col space-y-6">
                <div class="space-y-4 flex flex-col items-center mb-3">
                    <span class="text-2xl font-medium text-gray-200">Forgot Your Password?</span>
                    <Message size="small" severity="secondary" variant="simple">No worries, we'll send you the reset
                        instructions</Message>
                </div>
                <FloatLabel variant="on">
                    <InputText id="email" class="w-full p-3" v-model="email" autocomplete="off" />
                    <label for="email">Email</label>
                </FloatLabel>
                <button type="submit" @click="() => forgotPassword()" :disable="isLoading"
                    class="bg-cinema/80 py-2 w-1/3 sm:w-full rounded-lg text-white text-md sm:text-base"
                    :class="isLoading ? 'flex p-2 justify-center' : 'block'">
                    <svg v-if="isLoading" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span v-if="!isLoading">Send OTP</span>
                </button>
                <span class="text-center">Remember password? <router-link class="underline text-cinema"
                        to="/sign-in">Sign-In</router-link></span>
            </div>
            <div v-if="activeTab === 2" class="flex flex-col space-y-6">
                <div class="space-y-1 flex flex-col text-center items-center">
                    <span class="text-2xl font-medium text-gray-200">Password Reset</span>
                    <Message variant="simple" severity="secondary" size="small">We sent a code to {{ email }}, check the email and verify the otp
                    </Message>
                </div>
                <div class="flex justify-center gap-4">
                    <input v-for="(item, index) in otpCode" :key="item" v-model="otpCode[index]" type="text"
                        @input="nextInput($event, index)" id="index"
                        class="text-center text-white bg-[#232323] rounded h-10 w-10 text-lg mb-5" maxlength="1">
                </div>
                <button type="submit" @click="() => verifyOtp()" :disable="isLoadingVerify"
                    class="bg-cinema/80 py-2.5 w-1/3 sm:w-full  rounded-lg text-white text-md sm:text-base"
                    :class="isLoadingVerify ? 'flex p-2 justify-center' : 'block'">
                    <svg v-if="isLoadingVerify" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span v-if="!isLoadingVerify">Verify OTP</span>
                </button>
            </div>
            <div v-if="activeTab === 3" class="flex flex-col space-y-6">
                <div class="space-y-1 flex flex-col items-center">
                    <span class="text-2xl font-medium text-gray-200">Set New Password</span>
                    <Message variant="simple" severity="secondary" size="small">Password at least must be 8 character
                    </Message>
                </div>
                <div class="flex flex-col space-y-3">
                    <Message variant="simple" severity="contrast">Password</Message>
                    <el-input v-model="password" class="w-full" size="large" minlength="8" type="password"
                        placeholder="Please input password" show-password />
                </div>
                <div class="flex flex-col space-y-3">
                    <Message variant="simple" severity="contrast">Password Confirmation</Message>
                    <el-input v-model="password_confirmation" class="w-full" size="large" minlength="8" type="password"
                        placeholder="Please input password confirmation" show-password />
                    <span v-if="password_confirmation && password_confirmation != password"
                        class="text-red-500 text-sm">Password confirmation must be match</span>
                </div>
                <button type="submit" @click="() => updatePassword()" :disable="isLoadingUpdate"
                    class="bg-cinema/80 py-2.5 w-1/3 sm:w-full  rounded-lg text-white text-md sm:text-base"
                    :class="isLoadingUpdate ? 'flex p-2 justify-center' : 'block'">
                    <svg v-if="isLoadingUpdate" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 24 24">
                        <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                    <span v-if="!isLoadingUpdate">Update Password</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { useMutation } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { useRouter } from 'vue-router';
import { useSetting } from '@/services';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import Password from 'primevue/password';
import Message from 'primevue/message';
import { ElMessage } from 'element-plus';
import { useDarkModeStore } from '@/stores/darkMode';
import { Key, MailOpen, Lock, ArrowRight } from 'lucide-vue-next';

const darkMode = useDarkModeStore()
const { data: setting = {} } = useSetting()
const router = useRouter()

const email = ref()
const otpCode = ref(['', '', '', '', '', ''])
const password = ref()
const password_confirmation = ref()

const activeTab = ref(1)

const { mutate: forgotPassword, isLoading } = useMutation({
    mutationFn: async () => await axios.post('/auth/send-otp-forgot', { 'email': email.value }).then((res: any) => res.data.message),
    onSuccess: (res: string) => {
        activeTab.value = 2,
            ElMessage.success(res)
    },
    onError: (err: any) => ElMessage.error(err.response.data.errors.email[0])
})

const { mutate: verifyOtp, isLoading: isLoadingVerify } = useMutation({
    mutationFn: async () => await axios.post('/auth/match-otp-forgot', { email: email.value, otp: otpCode.value.join('') }).then((res: any) => res.data.message),
    onError: (err: any) => ElMessage.error(err.response.data.errors.email[0]),
    onSuccess: (res: string) => [
        activeTab.value = 3,
        ElMessage.success(res)
    ]
})

const { mutate: updatePassword, isLoading: isLoadingUpdate } = useMutation({
    mutationFn: async () => await axios.post('/auth/update-forgot-password', { email: email.value, password: password.value, password_confirmation: password_confirmation.value }).then((res: any) => res.data.message),
    onSuccess: (res: string) => {
        ElMessage.success(res),
            setTimeout(() => {
                router.push({ name: 'sign-in' })
            }, 500)
    },
    onError: (err: any) => ElMessage.error(err.response.data.errors.password[0])
})

const nextInput = (event: Event, index: number) => {
    const input = event.target as HTMLInputElement
    if (input.value.length === 1 && index !== otpCode.value.length - 1) {
        const nextInput = document.querySelectorAll<HTMLInputElement>('#index')[index + 1]
        if (nextInput) nextInput.focus()
    }
}

</script>