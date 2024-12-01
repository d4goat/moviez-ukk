<script setup lang="ts">
import { ref } from 'vue';
import axios from '@/libs/axios';
import { User } from '@/types';
import { block, unblock } from '@/libs/utils';
import * as Yup from "yup";
import { toast } from 'vue3-toastify';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';
import { useMutation } from '@tanstack/vue-query';

const formRef = ref()
const user = ref<User>({} as User);
const store = useAuthStore()
const showPw = ref(false)
const router = useRouter()

const formSchema = Yup.object().shape({
    email: Yup.string().email('Invalid Email').required().label('Email'),
    password: Yup.string().min(8, 'Password minimal harus diisi 8 karakter').required().label('Password'),
})

const { mutate: login, isLoading, isSuccess } = useMutation(
  (data: any) => axios.post("/auth/login", data),
  {
    onMutate: () => {
      block(document.getElementById('form-login'));
    },
    onSuccess: async (res: any) => {
      toast.success("Login berhasil!");
      store.setAuth(res.data.user, res.data.token);
      if(res.data.user.role.id === 1){
        router.push('/admin/dashboard')
      }  else {
        router.push('/landing/dashboard')
      }
    },
    onError: (err: any) => {
      toast.error(err.response.data.message);
    },
    onSettled: () => {
      unblock(document.getElementById('form-login'));
    }
  }
)

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
    <VForm :validation-schema="formSchema" ref="formRef" id="form-login" @submit="login" class="flex justify-center bg-[#171717] items-center min-h-screen w-full p-4">
        <div class="w-full max-w-md lg:max-w-lg flex flex-col justify-center rounded-xl space-y-6 p-6">
          <div class="font-medium text-center mb-4 flex flex-col">
            <span class="text-2xl sm:text-3xl">Login</span>
            <i class="text-3xl sm:text-4xl text-cinema">Cinema51</i>
          </div>
          <!-- begin:form -->
          <div class="flex flex-col gap-6">
            <!-- begin:input -->
            <div class="flex flex-col gap-2">
              <label class="text-base sm:text-lg font-poppins">Email</label>
              <div class="flex flex-col gap-1">
                <Field autocomplete="off" class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base" name="email"
                  type="email" placeholder="matix@cineplex.co, etc..." v-model="user.email" />
                <ErrorMessage class="text-red-500 text-sm" name="email" />
              </div>
            </div>
            <!-- end:input -->
            <!-- begin:input -->
            <div class="flex flex-col gap-2">
              <label class="text-base sm:text-lg font-poppins">Password</label>
              <div class="relative flex flex-col gap-1">
                <div class="flex relative flex-col">
                  <Field autocomplete="off" class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
                    name="password" type="password" placeholder="Insert Password..."
                    v-model="user.password" />
                  <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer">
                    <i class="fa-regular text-lg sm:text-xl" :class="{ 'fa-eye' : showPw, 'fa-eye-slash' : !showPw}" @click="togglePass"></i>
                  </span>                                    
                </div>
                <ErrorMessage class="text-red-500 text-sm" name="password" />
              </div>
            </div>
            <!-- end:input -->
            <div class="flex w-full justify-center mt-4">
              <button type="submit" 
                :disable="isLoading"
                class="bg-cinema py-2.5 w-full sm:w-1/3 rounded-lg text-white text-md sm:text-base" :class="isLoading ? 'flex p-2 justify-center' : 'block'">
                <svg v-if="isLoading" class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                  <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
              </svg>
                <span v-if="!isLoading">Login</span>
              </button>
            </div>
            <div class="flex w-full justify-center text-center text-sm sm:text-base">
              <span>Don't have an account yet? <router-link :to="{name: 'sign-up'}" class="text-cinema"><br> Register Now</router-link></span>
            </div>
          </div>
        </div>
      </VForm>
</template>