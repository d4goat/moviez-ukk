<template>
    <div class="flex justify-center min-h-screen w-full items-center">
        <div class="w-full max-w-md lg:max-w-lg flex flex-col bg-border  justify-center rounded-xl p-8">
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
                <InputGroup>
                    <InputGroupAddon>
                        <i class="pi pi-at"></i>
                    </InputGroupAddon>
                    <FloatLabel variant="in">
                        <InputText id="email" class="w-full" v-model="email" autocomplete="off" />
                        <label for="email">Email</label>
                    </FloatLabel>
                </InputGroup>
                <Button label="Send OTP" type="button" class="w-full" @click="() => forgotPassword()" variant="outlined" :loading="isLoading" />
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
                    <InputText v-for="(item, index) in otpCode" :key="index" v-model="otpCode[index]" type="text"
                        @input="nextInput($event, index)" @keydown="prevInput($event, index)" id="index"
                        class="text-center text-white  rounded h-10 w-10 text-lg mb-5" maxlength="1" />
                </div>
                <Button label="Verify OTP" variant="outlined" class="w-full" @click="() => verifyOtp()" :loading="isLoadingVerify" />
            </div>
            <VForm v-if="activeTab === 3" :validation-schema="formSchema" class="flex flex-col space-y-6">
                <div class="space-y-1 flex flex-col items-center">
                    <span class="text-2xl font-medium text-gray-200">Set New Password</span>
                    <!-- <Message variant="simple" severity="secondary" size="small">Password at least must be 8 character
                    </Message> -->
                </div>
                <div>
                    <Field name="password" v-model="password">
                        <InputGroup>
                            <InputGroupAddon>
                                <i class="pi pi-lock"></i>
                            </InputGroupAddon>
                            <FloatLabel variant="in">
                                <Password v-model="password" toggle-mask minlength="8" :feedback="false" class="w-full" input-class="w-full" input-id="password" />
                                <label for="password">Password</label>
                            </FloatLabel>
                        </InputGroup>
                        <ErrorMessage name="password" class="text-red-500" />
                    </Field>
                </div>
                <div>
                    <Field name="password_confirmation" v-model="password_confirmation" class="flex flex-col space-y-3">
                        <InputGroup>
                            <InputGroupAddon>
                                <i class="pi pi-lock"></i>
                            </InputGroupAddon>
                                <FloatLabel variant="in">
                                <Password v-model="password_confirmation" toggle-mask minlength="8" :feedback="false" class="w-full" input-class="w-full" input-id="password_confirmation" />
                                <label for="password_confirmation">Password Confirmation</label>
                            </FloatLabel>
                        </InputGroup>
                        <ErrorMessage name="password_confirmation" class="text-red-500" />
                    </Field>
                </div>
                <Button label="Update Password" type="submit" @click="() => updatePassword()" :loading="isLoadingUpdate" class="w-full" variant="outlined" />
            </VForm>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { useMutation } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { useRouter } from 'vue-router';
import { useSetting } from '@/services';
import { ElMessage } from 'element-plus';
import { useDarkModeStore } from '@/stores/darkMode';
import { Key, MailOpen, Lock, ArrowRight } from 'lucide-vue-next';
import * as Yup from "yup"

const formSchema = Yup.object().shape({
    password: Yup.string().min(8, 'Password must be contain at least 8 character').required().label('Password'),
    password_confirmation: Yup.string().oneOf([Yup.ref('password')], 'Password confirmation must be match').required().label('Password Confirmation'),
})

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
    onError: (err: any) => ElMessage.error(err.response.data.message)
})

const nextInput = (event: Event, index: number) => {
    const input = event.target as HTMLInputElement
    if (input.value.length === 1 && index !== otpCode.value.length - 1) {
        const nextInput = document.querySelectorAll<HTMLInputElement>('#index')[index + 1]
        if (nextInput) nextInput.focus()
    }
}

const prevInput = (event: KeyboardEvent, index: number) => {
    if(event.key === "Backspace" && index > 0 && !otpCode.value[index]) {
      const prevInput = document.querySelectorAll("#index")[index - 1] as HTMLInputElement
      if(prevInput) prevInput.focus()
    }
}

</script>
