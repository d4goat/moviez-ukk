<template>
    <VForm @submit="submit" :validation-schema="formSchema" ref="formRef" id="form-user">
        <div class="card bg-dark-bg text-bodydark1">
            <div class="card-header align-items-center border-b border-white flex justify-between my-3">
                <h2> {{ selected ? 'Edit' : 'Tambah' }} User </h2>
                <button type="button" class="btn btn-md bg-red-600 hover:bg-red-700 text-white" @click="$emit('close')">
                    <i class="la la-times-circle"></i> Batal
                </button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Nama</label>
                        <Field
                            autocomplete="off"
                            name="name"
                            type="text"
                            placeholder="Masukkan Nama Anda"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-3"
                            v-model="user.name"
                        />
                        <ErrorMessage name="name" class="text-red-500"/>
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Email</label>
                        <Field
                            autocomplete="off"
                            name="email"
                            type="text"
                            placeholder="Masukkan Email Anda"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-3"
                            v-model="user.email"
                        />
                        <ErrorMessage name="email" class="text-red-500"/>
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Phone</label>
                        <Field
                            autocomplete="off"
                            name="phone"
                            type="text"
                            placeholder="Masukkan No Telepon Anda"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-3"
                            v-model="user.phone"
                        />
                         <ErrorMessage name="phone" class="text-red-500" />
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Password</label>
                        <Field
                            autocomplete="off"
                            name="password"
                            type="password"
                            placeholder="Masukkan Password Anda"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-3"
                            v-model="user.password"
                        />
                        <ErrorMessage name="password" class="text-red-500"/>
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Konfirmasi Password</label>
                        <Field
                            autocomplete="off"
                            name="passwordConfirmation"
                            type="password"
                            placeholder="Masukkan Konfirmasi Password Anda"
                            class="bg-[#232323] border-none  focus:ring-[#7C7C7C] rounded-xl p-3"
                            v-model="user.passwordConfirmation"
                        />
                        <ErrorMessage name="passwordConfirmation" class="text-red-500"/>
                    </div>
                    <div class="col-md-6 flex flex-col mb-3">
                        <label class="form-label">Role</label>
                        <Field v-model="user.role_id" autocomplete="off" name="role" type="text" class="bg-[#232323] border-none focus:ring-[#7c7c7c] rounded-xl p-3">
                            <Select :options="role" style="--p-select-background: #222222" option-value="id" option-label="name" name="role_id" v-model="user.role_id" placeholder="Select Role" />
                        </Field>
                        <ErrorMessage name="role_id" class="text-red-500" />
                    </div>
                </div>
            </div>
            <div class="card-footer flex">
                <button type="submit" class="btn btn-md my-3 ms-auto bg-blue-600 hover:bg-blue-700 text-white">Submit</button>
            </div>
        </div>
    </VForm>
</template>

<script setup lang="ts">
import { computed, ref, onMounted } from 'vue';
import * as Yup from 'yup'
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { unblock, block } from '@/libs/utils';
import type { User } from '@/types';
import { useQuery } from '@tanstack/vue-query';
import { ElMessage } from 'element-plus';

const props = defineProps({
    selected: {
        type: String,
        default: null
    }
})

interface Role {
    id: number,
    uuid: string,
    full_name: string,
    name: string,
    guard_name: string
}

const user = ref<User>({} as User)
const emit = defineEmits(["close", "refresh"])

const formRef = ref()

const formSchema = Yup.object().shape({
    name: Yup.string().required('Nama tidak boleh kosong'),
    email: Yup.string().email().required('Email tidak boleh kosong'),
    phone: Yup.string().matches(/^08[0-9]\d{8,11}$/, 'Invalid nomor telepon').required(),
    password: Yup.string().min(8, 'Password minimal harus diisi 8 karakter').required().label('Password'),
    passwordConfirmation: Yup.string().oneOf([Yup.ref('password')], 'Passwords harus sesuai').required().label('Password Confirmation'),
})

function getEdit(){
    block(document.getElementById('form-user'))

    axios.get(`/master/users/${props.selected}`)
    .then(({data}: any) => {
        user.value = data.data
        user.value.role_id = data.data.role.id
    })
    .catch((error: any) => {
        toast.error(error.response.data.message)
    })
    .finally(() => {
        unblock(document.getElementById('form-user'));
    })
}

function submit (){
    block(document.getElementById('form-user'));

    const formData = new FormData()

    formData.append('name', user.value.name);
    formData.append('email', user.value.email);
    formData.append('phone', user.value.phone);
    formData.append('role_id', user.value.role_id);

    if(user.value?.password){
        formData.append('password', user.value.password)
        formData.append('password_confirmation', user.value.passwordConfirmation)
    }

    if(props.selected){
        formData.append('_method', 'PUT')
    }

    axios({
        method: 'post',
        url: props.selected ? `/master/users/${props.selected}` : '/master/users/store',
        data: formData,
        headers: {
            "Content-Type" : "multipart/form-data"
        }
    })
    .then(() => {
        toast.success("Success create data user")
        formRef.value.resetForm()
        emit("close");
        emit("refresh");
    })
    .catch((error: any) => {
        console.error(error.response.data.message)
        toast.error(error.response.data.message)
    })
    .finally(() => {
        unblock(document.getElementById('form-user'))
    })
}

const { data: role } = useQuery({
    queryKey: ['role'],
    queryFn: async () => axios.get('/master/role').then((res: any) => res.data),
    onError: (err: any) => ElMessage.error(err.response.data.message)
})

const roles = computed(() =>
    role.value?.map((item: Role) => ({
        id: item.id,
        text: item.name
    }))
)

onMounted(() => {
    if(props.selected){
        getEdit()
    }
})
</script>
