<template>
    <VForm class="w-full" :validation-schema="formSchema" @submit="submit" id="form-security">
        <!-- Header -->
        <div class="card-header flex flex-col pb-3 border-b border-gray-700">
            <span class="font-medium text-gray-300">Update Password</span>
        </div>

        <!-- Body -->
        <div class="card-body flex flex-col space-y-6 my-3">
            <!-- Input Begin -->
            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <label name="old_password" class="form-label font-medium">Old Password</label>
                    <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]"
                        name="old_password" v-model="formData.old_password" placeholder="Insert old password"
                        autocomplete="off" type="password" />
                    <span class="absolute right-10 flex items-center pr-3 cursor-pointer">
                        <i :class="['fa-regular text-lg sm:text-xl', showOld ? 'fa-eye' : 'fa-eye-slash']" @click="toggleOldPassword"></i>
                    </span>
                </div>
                <ErrorMessage name="old_password" class="text-red-500 text-end" />
            </div>
            <!-- Input End -->

            <!-- Input Begin -->
            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <label name="password" class="form-label font-medium">New Password</label>
                    <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]"
                        name="password" v-model="formData.password" placeholder="Insert new password"
                        autocomplete="off" type="password" />
                    <span class="absolute right-10 flex items-center pr-3 cursor-pointer">
                        <i :class="['fa-regular text-lg sm:text-xl', show ? 'fa-eye' : 'fa-eye-slash']" @click="togglePassword"></i>
                    </span>
                </div>
                <ErrorMessage name="password" class="text-red-500 text-end" />
            </div>
            <!-- Input End -->

            <!-- Input Begin -->
            <div class="flex flex-col gap-2">
                <div class="flex justify-between items-center">
                    <label name="password_confrimation" class="form-label font-medium">New Password Confirmation</label>
                    <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]"
                        name="password_confirmation" v-model="formData.password_confirmation" placeholder="Insert new password confrimation"
                        autocomplete="off" type="password_confirmation" />
                    <span class="absolute right-10 flex items-center pr-3 cursor-pointer">
                        <i :class="['fa-regular text-lg sm:text-xl', showConfirm ? 'fa-eye' : 'fa-eye-slash']" @click="togglePasswordConfirmation"></i>
                    </span>
                </div>
                <ErrorMessage name="password_confirmation" class="text-red-500 text-end" />
            </div>
            <!-- Input End -->
        </div>
        
        <div class="card-footer flex py-3 border-t border-gray-700">
            <button type="submit" class="btn btn-md text-white bg-cyan-600 hover:bg-cyan-700 shadow-3 shadow-cyan-300/60 ms-auto">Save Password</button>
        </div>
    </VForm>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { block, unblock } from '@/libs/utils';
import * as yup from 'yup';

export default defineComponent({
    setup() {
        const formData = ref<any>({})
        const formSchema = yup.object().shape({
            old_password: yup.string().required('Field password lama harus diisi'),
            password: yup.string().min(8, 'Password minimal harus diisi 8 karakter').required('Field password baru harus diisi'),
            password_confirmation: yup.string().oneOf([yup.ref('password')], 'Passwords harus sesuai').required('Field konfirmasi password harus diisi'),
        })

        const showOld = ref(false)
        const show = ref(false)
        const showConfirm = ref(false)

        return {
            formData,
            formSchema,
            showOld,
            show,
            showConfirm
        }
    },
    methods: {
        submit() {
            block(document.getElementById('form-security'))
            axios.post('/master/users/update/keamanan', this.formData).then((res: any) => {
                toast.success(res.data.message)
                this.formData = {}
            }).catch((err: any) => {
                toast.error(err.response.data.message)
                console.error(err.response.data.message)
            }).finally(() => unblock(document.getElementById('form-security')))
        },
        toggleOldPassword() {
            const oldPasswordField = document.querySelector(["input[name='old_password']"]);
            if (oldPasswordField.type === 'password') {
                oldPasswordField.type = 'text';
                this.showOld = true
            } else {
                oldPasswordField.type = 'password';
                this.showOld = false
            }
        },
        togglePassword() {
            const passwordField = document.querySelector(["input[name='password']"]);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.show = true
            } else {
                passwordField.type = 'password';
                this.show = false
            }
        },
        togglePasswordConfirmation() {
            const passwordField = document.querySelector(["input[name='password_confirmation']"]);
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                this.showConfirm = true
            } else {
                passwordField.type = 'password';
                this.showConfirm = false
            }
        },
    }
})
</script>
