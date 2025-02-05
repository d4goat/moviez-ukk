<template>
    <VForm @submit="submit" class="w-full" id="form-user" :validation-schema="formSchema">
        <div class="card-header flex flex-col pb-3 border-b border-gray-700">
            <span class="font-medium">Personal Information</span>
            <span class="text-sm text-gray-300">Update Profile</span>
        </div>
        <div class="card-body flex flex-col space-y-6 my-3">
            <div class="flex flex-col gap-2">
                <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]" name="name"
                    v-model="users.name" placeholder="Insert Name" autocomplete="off" type="text">
                    <FloatLabel variant="in">
                        <InputText v-model="users.name" style="background-color: #19191c;" class="w-full" id="name" />
                        <label for="name">Name</label>
                    </FloatLabel>
                </Field>
                <ErrorMessage name="name" class="text-red-500" />
            </div>
            <div class="flex flex-col gap-2">
                <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]" name="email"
                    v-model="users.email" placeholder="Insert Email" autocomplete="off" type="text">
                    <FloatLabel variant="in">
                        <InputText v-model="users.email" style="background-color: #19191c;" class="w-full" id="email" />
                        <label for="email">Email</label>
                    </FloatLabel>
                </Field>
                <ErrorMessage name="email" class="text-red-500" />
            </div>
            <div class="flex flex-col gap-2">
                <Field class="bg-dropdown border-none col-md-9 focus:ring-[#7C7C7C] rounded-xl p-[12px]" name="phone"
                    v-model="users.phone" placeholder="Insert Phone" autocomplete="off" type="text">
                    <FloatLabel variant="in">
                        <InputText v-model="users.phone" style="background-color: #19191c;" class="w-full" id="phone" />
                        <label for="phone">Phone</label>
                    </FloatLabel>
                </Field>
                <ErrorMessage name="phone" class="text-red-500" />
            </div>
            <div class="">
                <Field name="photo" class="card" v-model="users.photo" type="file">
                    <FileUpload accept="image/*" choose-label="Choose" severity="secondary" class="p-button-outlined"
                        ref="filupload" @select="upload">
                        <template #empty>
                            <span>Drag and drop files to here to upload</span>
                        </template>
                    </FileUpload>
                </Field>
                <ErrorMessage name="photo" class="text-red-500" />
            </div>
        </div>
        <div class="card-footer flex pt-3 border-t border-gray-700">
            <Button type="submit" label="Save Profile" class="ml-auto" variant="outlined" />
        </div>
    </VForm>
</template>

<script lang="ts">
import { ref, defineComponent } from 'vue';
import * as yup from 'yup';
import { useMutation } from '@tanstack/vue-query';
import { block, unblock } from '@/libs/utils';
import { useAuthStore, User } from '@/stores/auth';
import { toast } from 'vue3-toastify';
import axios from '@/libs/axios';
import FileUpload from "primevue/fileupload"

export default defineComponent({
    components: {
        FileUpload
    },
    setup() {

        const { user, setAuth } = useAuthStore()
        const users = ref<User>({} as User)
        const photo = ref<Array<File | String>>(user.photo ? [user.photo] : [])
        const fileTypes = ref(['image/jpg', 'image/png', 'image/jpeg']);
        const fileupload = ref()

        const upload = (event: any) => {
            console.log(event.files)
            if (event.files && event.files[0]) {
                photo.value = event.files[0];
            }
        }

        const formSchema = yup.object().shape({
            name: yup.string().required('Field nama harus diisi'),
            email: yup.string().email('Invalid Email').required('Field email harus diisi'),
            phone: yup.string().matches(/^08[0-9]\d{8,11}$/, 'Invalid Phone Number').required('Field nomor telepon harus diisi'),
        })

        return {
            photo,
            fileTypes,
            formSchema,
            user,
            users,
            setAuth,
            fileupload, upload
        }
    },
    methods: {
        submit() {
            const data = new FormData()
            
            data.append('name', this.users.name)
            data.append('email', this.users.email)
            data.append('phone', this.users.phone)  

            console.log(this.photo)

            if (this.photo) {
                data.append('photo', this.photo)
            }

            block(document.getElementById('form-user') as HTMLFormElement)

            axios.post('/master/users/update/akun', data).then((res: any) => {
                toast.success(res.data.message)
                this.setAuth(res.data.data)
            }).catch((err: any) => {
                toast.error(err.response.data.message)
                console.error(err.response.data.message)
            }).finally(() => unblock(document.getElementById('form-user') as HTMLFormElement))
        }
    },
    mounted() {
        this.users = this.user
        console.log(this.users)
    }
})
</script>