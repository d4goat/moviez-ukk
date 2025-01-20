<script setup lang="ts">
import { ref } from 'vue';
import axios from '@/libs/axios';
import { User } from '@/types';
import { block, unblock } from '@/libs/utils';
import * as Yup from "yup";
import { toast } from 'vue3-toastify';
import { useAuthStore } from '@/stores/auth';
import { useRouter } from 'vue-router';
import { useSetting } from '@/services';
import { useMutation } from '@tanstack/vue-query';
import { Mail } from 'lucide-vue-next';

const formRef = ref()
const user = ref<User>({} as User);
const store = useAuthStore()
const showPw = ref(false)
const router = useRouter()
const { data: setting = {} } = useSetting()

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
      if (res.data.user.role.id === 1) {
        router.push('/admin/dashboard')
      } else {
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
</script>

<template>
  <VForm :validation-schema="formSchema" ref="formRef" id="form-login" @submit="login"
    class="flex justify-center items-center min-h-screen w-full p-4">
    <div class="w-full max-w-md lg:max-w-lg flex flex-col justify-center bg-border shadow-lg rounded-2xl space-y-8 p-8">
      <div class="font-medium text-center mb-4 flex flex-col">
        <h1 class="text-3xl text-gray-300 font-semibold tracking-tight sm:text-3xl">Welcome Back</h1>
        <p>Please enter your details to sign in</p>
      </div>
      <!-- begin:form -->
      <div class="flex flex-col gap-6">
        <!-- begin:input -->
        <div class="flex flex-col gap-2">
          <Field autocomplete="off"
            class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
            name="email" type="email" placeholder="matix@cineplex.co, etc..." v-model="user.email">
            <FloatLabel variant="in">
                <InputText id="email" v-model="user.email" class="w-full" autocomplete="off" />
              <label for="email">Email</label>
            </FloatLabel>
          </Field>
          <ErrorMessage class="text-red-500 text-sm" name="email" />
        </div>
        <!-- end:input -->
        <!-- begin:input -->
        <div class="flex flex-col gap-2">
          <Field autocomplete="off"
            class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
            name="password" type="password" placeholder="Insert Password..." v-model="user.password">
            <FloatLabel variant="in">
              <Password v-model="user.password" :input-class="'w-full'" size="large" class="w-full" :feedback="false" toggle-mask input-id="password" />
              <label for="password">Password</label>
            </FloatLabel>
          </Field>
          <ErrorMessage class="text-red-500 text-sm" name="password" />
        </div>
        <router-link to="/forgot-password" class="underline text-cinema w-fit ml-auto"><span>Forgot
            Password?</span></router-link>
        <!-- end:input -->
        <div class="flex w-full justify-center mt-4">
         <Button type="submit" label="Sign in" class="w-full" variant="outlined" :loading="isLoading"  />
        </div>
        <div class="flex w-full justify-center text-center text-sm sm:text-base">
          <span>Don't have an account yet? <router-link :to="{ name: 'sign-up' }" class="text-cinema font-medium">Create one now</router-link></span>
        </div>
      </div>
    </div>
  </VForm>
</template>