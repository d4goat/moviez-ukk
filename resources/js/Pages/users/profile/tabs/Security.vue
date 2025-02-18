<template>
    <VForm class="w-full" :validation-schema="formSchema" @submit="submit" id="form-security">
        <!-- Header -->
        <div class="card-header flex flex-col pb-3 border-b border-gray-700">
            <span class="font-medium text-gray-300">Update Password</span>
        </div>

        <!-- Body -->
        <div class="card-body flex flex-col gap-6 my-3">
            <!-- Input Begin -->
            <div class="flex flex-col gap-2">
                <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]"
                    name="old_password" v-model="formData.old_password" placeholder="Insert old password"
                    autocomplete="off" type="password">
                    <InputGroup>
                        <InputGroupAddon>
                            <i class="pi pi-lock"></i>
                        </InputGroupAddon>
                        <FloatLabel variant="in">
                            <Password v-model="formData.old_password" :input-class="'w-full'"
                            style="background-color: #19191c;" class="w-full" :feedback="false" toggle-mask
                            input-id="old_password" />
                            <label for="old_password">Old Password</label>
                        </FloatLabel>
                    </InputGroup>
                </Field>
                <ErrorMessage name="old_password" class="text-red-500" />
            </div>
            <!-- Input End -->
            <!-- Input Begin -->
            <div class="flex flex-col gap-2">
                <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]"
                    name="password" v-model="formData.password" placeholder="Insert old password"
                    autocomplete="off" type="password">
                    <InputGroup>
                        <InputGroupAddon>
                            <i class="pi pi-lock"></i>
                        </InputGroupAddon>
                        <FloatLabel variant="in">
                            <Password v-model="formData.password" :input-class="'w-full'"
                            style="background-color: #19191c;" class="w-full" :feedback="false" toggle-mask
                            input-id="password" />
                            <label for="password">Password</label>
                        </FloatLabel>
                    </InputGroup>
                </Field>
                <ErrorMessage name="password" class="text-red-500" />
            </div>
            <!-- Input End -->
            <!-- Input Begin -->
            <div class="flex flex-col gap-2">
                <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]"
                    name="password_confirmation" v-model="formData.password_confirmation" placeholder="Insert old password"
                    autocomplete="off" type="password">
                    <InputGroup>
                        <InputGroupAddon>
                            <i class="pi pi-lock"></i>
                        </InputGroupAddon>
                        <FloatLabel variant="in">
                            <Password v-model="formData.password_confirmation" :input-class="'w-full'"
                            style="background-color: #19191c;" class="w-full" :feedback="false" toggle-mask
                            input-id="password_confirmation" />
                            <label for="password_confirmation">Password Confirmation</label>
                        </FloatLabel>
                    </InputGroup>
                </Field>
                <ErrorMessage name="password_confirmation" class="text-red-500" />
            </div>
            <!-- Input End -->

        </div>

        <div class="card-footer flex py-3 border-t border-gray-700">
           <Button type="submit" label="Save Password" class="ml-auto" variant="outlined" />
        </div>
    </VForm>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import axios from '@/libs/axios';
import { block, unblock } from '@/libs/utils';
import * as yup from 'yup';
import { ElMessage } from 'element-plus';
import InputGroup from 'primevue/inputgroup';

export default defineComponent({
    setup() {
        const formData = ref<any>({})
        const formSchema = yup.object().shape({
            old_password: yup.string().required('Old Password field must be filled'),
            password: yup.string().min(8, 'Password must be contain at least 8 character').required('New Password field must be filled'),
            password_confirmation: yup.string().oneOf([yup.ref('password')], 'Password is not match').required('Confirmation Password field must be filled'),
        })

        return {
            formData,
            formSchema,
        }
    },
    methods: {
        submit() {
            block(document.getElementById('form-security'))
            axios.post('/master/users/update/keamanan', this.formData).then((res: any) => {
                ElMessage.success(res.data.message)
                this.formData = {}
                window.location.reload()
            }).catch((err: any) => {
                ElMessage.error(err.response.data.message)
                console.error(err.response.data.message)
            }).finally(() => unblock(document.getElementById('form-security')))
        }
    }
})
</script>

<style scoped>
:deep(.p-password input) {
  background-color: #19191c !important;
}
</style>
