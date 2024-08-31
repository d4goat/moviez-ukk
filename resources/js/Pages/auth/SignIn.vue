<script setup lang=ts>
import { ref } from 'vue';
import axios from '@/libs/axios';
import { User } from '@/types';
import { block, unblock } from '@/libs/utils';
import * as Yup from "yup";
import { toast } from 'vue3-toastify';
import { useAuthStore } from '@/stores/auth';

const formRef = ref()
const user = ref<User>({} as User);
const store = useAuthStore()
const showPw = ref(false)

const formSchema = Yup.object().shape({
    email: Yup.string().email('Invalid Email').required().label('Email'),
    password: Yup.string().min(8, 'Password minimal harus diisi 8 karakter').required().label('Password'),
})

function submit() {
    block(document.getElementById('form-login'));

    axios.post("/auth/login", user.value)
        .then((response: any) => {
            unblock(document.getElementById('form-login'));
            store.setAuth(response.data.user, response.data.token);
            toast.success("Login berhasil!");
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
    <div class="h-screen w-full">
        <img src="/images/bg-2.jpg" class="absolute md:pl-36 inset-0 w-full h-full object-cover" alt="">
        <div class="w-[43%] h-full bg-gray-200 z-10 absolute top-0 left-0 p-6 items-center justify-center">
            <div class="w-full h-full flex justify-center items-center">
                <div class="w-full max-w-md flex flex-col border-[1px] border-gray-700 rounded-xl p-6 space-y-4">
                    <h2 class="text-2xl font-bold text-center mb-7">Login</h2>
                    <!-- begin:form -->
                    <VForm :validation-schema="formSchema" ref="formRef" @submit="submit" class="flex flex-col gap-5">
                        <!-- begin:input -->
                        <div class="flex flex-col gap-3">
                            <label class="text-sm font-semibold">Email</label>
                            <div class="flex flex-col gap-2">
                                <Field autocomplete="off" class="bg-transparent border-[1px] border-gray-700 rounded-md p-2" name="email"
                                    type="email" placeholder="Masukkan Email Anda" v-model="user.email" />
                                <ErrorMessage class="text-red-500" name="email" />
                            </div>
                        </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <label class="text-sm font-semibold">Password</label>
                                <div class="relative flex flex-col gap-2">
                                    <div class="flex relative flex-col">
                                        <Field autocomplete="off" class="bg-transparent border-[1px] border-gray-700 rounded-md p-2"
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
                               <button type="submit" class="bg-sky-700 py-3 px-6 rounded-lg text-white text-semibold text-sm">Login</button>
                            </div>
                    </VForm>
                </div>
            </div>
        </div>
    </div>
</template>