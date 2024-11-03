<template>
    <VForm class="w-full" :validation-schema="formSchema" @submit="submit" id="form-security">
        <div class="card-header flex flex-col pb-3 border-b border-gray-700">
            <span class="font-medium text-gray-300">Update Password</span>
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

        return {
            formData,
            formSchema
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
        toggleOldPassword(ev) {
            const type = document.querySelector("[name=old_password]").type;

            if (type === 'password') {
                document.querySelector("[name=old_password]").type = 'text';
                ev.target.classList.add("bi-eye");
                ev.target.classList.remove("bi-eye-slash");
            } else {
                document.querySelector("[name=old_password]").type = 'password';
                ev.target.classList.remove("bi-eye");
                ev.target.classList.add("bi-eye-slash");
            }
        },
        togglePassword(ev) {
            const type = document.querySelector("[name=password]").type;

            if (type === 'password') {
                document.querySelector("[name=password]").type = 'text';
                ev.target.classList.add("bi-eye");
                ev.target.classList.remove("bi-eye-slash");
            } else {
                document.querySelector("[name=password]").type = 'password';
                ev.target.classList.remove("bi-eye");
                ev.target.classList.add("bi-eye-slash");
            }
        },
        toggleConfirmPassword(ev) {
            const type = document.querySelector("[name=password_confirmation]").type;

            if (type === 'password') {
                document.querySelector("[name=password_confirmation]").type = 'text';
                ev.target.classList.add("bi-eye");
                ev.target.classList.remove("bi-eye-slash");
            } else {
                document.querySelector("[name=password_confirmation]").type = 'password';
                ev.target.classList.remove("bi-eye");
                ev.target.classList.add("bi-eye-slash");
            }
        }
    }
})
</script>