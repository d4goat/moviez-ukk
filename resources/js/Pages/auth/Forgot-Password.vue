<template>
    <div class="flex justify-center min-h-screen w-full items-center">
        <div class="w-full max-w-md lg:max-w-lg flex flex-col justify-center rounded-xl p-6">
            <div class="font-semibold text-center mb-10">
                <span class="text-cinema text-4xl">{{ setting?.name }}</span>
            </div>

            <div v-if="activeTab === 1" class="flex flex-col space-y-6">
                <div class="space-y-4 flex flex-col">
                    <span class="text-xl font-medium text-gray-200">Forgot Your Password?</span>
                    <Message size="small" severity="secondary" variant="simple">Enter your email address and we'll send you the otp to reset password</Message>
                </div>
                <FloatLabel variant="on">
                    <InputText id="email" class="w-full p-3" v-model="email" autocomplete="off" />
                    <label for="email">Email</label>
                </FloatLabel>
                <button type="submit"
                @click="forgotPassword"
                :disable="isLoading"
                class="bg-cinema/80 py-2.5 w-1/3 sm:w-full  rounded-lg text-white text-md sm:text-base" :class="isLoading ? 'flex p-2 justify-center' : 'block'">
                <svg v-if="isLoading" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
              </svg>
                <span v-if="!isLoading">Send OTP</span>
              </button>
                <span class="text-center">Remember password? <router-link class="underline text-cinema" to="/sign-in">Sign-In</router-link></span>
            </div>
            <div v-else class="flex flex-col space-y-6">

            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import { useMutation } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { useSetting } from '@/services';
import InputText from 'primevue/inputtext';
import FloatLabel from 'primevue/floatlabel';
import Message from 'primevue/message';
import { ElMessage } from 'element-plus';

const { data: setting = {} } = useSetting()

const email = ref()

const activeTab = ref(1)

const { mutate: forgotPassword, isLoading } = useMutation({
    mutationFn: async () => await axios.post('/auth/send-otp-forgot', {'email': email.value}).then((res: any) => res.data.message),
    onSuccess: (res: string) => {
        activeTab.value = 2,
        ElMessage.success(res)
    },
    onError: (err: any) => ElMessage.error(err.response.data.errors.email[0])
})

</script>