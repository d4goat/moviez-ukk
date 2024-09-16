<script setup lang="ts">
import { ref } from 'vue';
import axios from '@/libs/axios';
import { User } from '@/types';
import { block, unblock } from '@/libs/utils';
import * as Yup from "yup";
import { toast } from 'vue3-toastify';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';

const formRef = ref()
const user = ref<User>({} as User);
const store = useAuthStore()
const showPw = ref(false)
const router = useRouter()

const formSchema = Yup.object().shape({
    email: Yup.string().email('Invalid Email').required().label('Email'),
    password: Yup.string().min(8, 'Password minimal harus diisi 8 karakter').required().label('Password'),
})

function submit() {
    block(document.getElementById('form-login'));

    axios.post("/auth/login", user.value)
        .then((response: any) => {
            store.setAuth(response.data.user, response.data.token);
            toast.success("Login berhasil!");
            router.push('/')
        })
        .catch((err: any) => {
            toast.error(err.response.data.message);
        })
        .finally(() => {
            unblock(document.getElementById('form-login'));
        })
}

function togglePass(ev: MouseEvent) {
    const type = document.querySelector<HTMLInputElement>(["input[name=password]"]);


    if (type && type.type === 'password') {
        type.type = 'text';
        showPw.value = true
    } else if(type) {
        type.type = 'password';
        showPw.value = false
    }
}
</script>

<template>
    <VForm :validation-schema="formSchema" ref="formRef" id="form-login" @submit="submit" class="flex justify-center bg-[#171717] items-center w-full h-full">
        <div class="w-full h-full max-w-lg flex flex-col justify-evenly rounded-xl p-6 space-y-4">
            <div class="font-medium text-center mb-7 flex flex-col">
                <span class="text-3xl">Login</span>
                <i class="text-4xl text-cinema">Cinema51</i>
            </div>
            <!-- begin:form -->
            <div class="flex flex-col gap-4">
                <!-- begin:input -->
                <div class="flex flex-col gap-3">
                    <label class="text-xl font-semibold">Email</label>
                    <div class="flex flex-col gap-2">
                        <Field autocomplete="off" class="bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3" name="email"
                            type="email" placeholder="Masukkan Email Anda" v-model="user.email" />
                        <ErrorMessage class="text-red-500" name="email" />
                    </div>
                </div>
                    <!-- end:input -->
                    <!-- begin:input -->
                    <div class="flex flex-col gap-3">
                        <label class="text-xl font-semibold">Password</label>
                        <div class="relative flex flex-col gap-2">
                            <div class="flex relative flex-col">
                                <Field autocomplete="off" class="bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3"
                                name="password" type="password" placeholder="Masukkan Password Anda"
                                v-model="user.password" />
                                <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                                <i class="fa-regular text-xl" :class="{ 'fa-eye' : showPw, 'fa-eye-slash' : !showPw}" @click="togglePass"></i>
                            </span>                                    
                        </div>
                            <ErrorMessage class="text-red-500" name="password" />
                        </div>
                    </div>
                    <!-- end:input -->
                    <div class="flex w-full justify-center mt-3">
                       <button type="submit" class="bg-cinema py-[10px] w-1/3 rounded-lg text-white text-semibold text-md">Login</button>
                    </div>
                    <div class="flex w-full justify-center text-center text-lg">
                        <span>Don't have an account yet? <router-link :to="{name: 'register'}" class="text-cinema"><br> Register Now</router-link></span>
                    </div>
            </div>
        </div>
    </VForm>
</template>