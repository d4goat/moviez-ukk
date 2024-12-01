<template>
    <div class="flex justify-center min-h-screen w-full items-center">
        <div class="w-full max-w-md lg:max-w-lg flex flex-col justify-center rounded-xl p-6">
            <div class="font-semibold text-center">
                <span class="text-cinema text-4xl">{{ setting?.name }}</span>
            </div>

            <div class="flex flex-col space-y-6 mt-10">
                <div class="space-y-4 flex flex-col">
                    <span class="text-xl font-medium text-gray-200">Forgot Your Password?</span>
                    <Message size="small" severity="secondary" variant="simple">Enter your email address and we'll send you the otp to reset password</Message>
                </div>
                <FloatLabel variant="on">
                    <InputText id="email" class="w-full p-3" v-model="email" autocomplete="off" />
                    <label for="email">Email</label>
                </FloatLabel>
                <button class="p-2.5 rounded-lg font-medium mt-6 bg-cinema/80">
                    Send OTP
                </button>
                <span class="text-center">Remember password? <router-link class="underline text-cinema" to="/sign-in">Sign-In</router-link></span>
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

const { data: setting = {} } = useSetting()

const email = ref()

</script>