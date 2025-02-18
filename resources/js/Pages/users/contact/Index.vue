<template>
    <main class="pt-21 pb-10">
        <div class="grid grid-cols-1 min-h-screen">
            <VForm :validation-schema="formSchema" ref="formRef" class="flex justify-center items-center"
                @submit="handleSubmit">
                <div
                    class="w-full lg:max-w-3xl max-w-md flex flex-col justify-center bg-border shadow-lg rounded-2xl space-y-8 p-8">
                    <div class="font-medium text-center mb-4 flex flex-col">
                        <h1 class="text-2xl text-gray-300 font-semibold tracking-tight sm:text-3xl">Sent your feedback
                        </h1>
                        <p class="text-sm">We really appriciate your feedback to improve our services</p>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex flex-col gap-2">
                            <Field autocomplete="off"
                                class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
                                name="name" type="text" placeholder="john doe, etc..." v-model="form.name">
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-user" />
                                    </InputGroupAddon>
                                    <FloatLabel variant="in">
                                        <InputText id="name" v-model="form.name" class="w-full" autocomplete="off" />
                                        <label for="name">Name</label>
                                    </FloatLabel>
                                </InputGroup>
                            </Field>
                            <ErrorMessage class="text-red-500 text-sm" name="name" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <Field autocomplete="off"
                                class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
                                name="email" type="email" placeholder="matix@cineplex.co, etc..." v-model="form.email">
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-at" />
                                    </InputGroupAddon>
                                    <FloatLabel variant="in">
                                        <InputText id="email" v-model="form.email" class="w-full" autocomplete="off" />
                                        <label for="email">Email</label>
                                    </FloatLabel>
                                </InputGroup>
                            </Field>
                            <ErrorMessage class="text-red-500 text-sm" name="email" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <Field autocomplete="off"
                                class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
                                name="type" type="text" placeholder="Select Type of Feedback" v-model="form.type">
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-clipboard" />
                                    </InputGroupAddon>
                                    <FloatLabel variant="in">
                                        <Select v-model="form.type" id="type" :options="options" option-label="name" option-value="name" class="w-full" style="--p-select-background: #222222"/>
                                        <label for="type">Type</label>
                                    </FloatLabel>
                                </InputGroup>
                            </Field>
                            <ErrorMessage class="text-red-500 text-sm" name="type" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <Field autocomplete="off"
                                class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
                                name="subject" type="text" placeholder="Select Type of Feedback" v-model="form.subject">
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-inbox" />
                                    </InputGroupAddon>
                                    <FloatLabel variant="in">
                                        <InputText id="subject" v-model="form.subject" class="w-full" autocomplete="off" />
                                        <label for="subject">Subject</label>
                                    </FloatLabel>
                                </InputGroup>
                            </Field>
                            <ErrorMessage class="text-red-500 text-sm" name="subject" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <Field autocomplete="off"
                                class="w-full bg-[#232323] border-none focus:border-2 focus:border-[#7C7C7C] focus:ring-2 focus:ring-[#7C7C7C] rounded-xl p-3 text-sm sm:text-base"
                                name="message" type="text" placeholder="Input your message" v-model="form.message">
                                <InputGroup>
                                    <InputGroupAddon>
                                        <i class="pi pi-envelope"/>
                                    </InputGroupAddon>
                                    <Textarea v-model="form.message" placeholder="Message" rows="4" class="w-full" />
                                    <!-- <FloatLabel variant="on">
                                        <label for="message">Message</label>
                                    </FloatLabel> -->
                                </InputGroup>
                            </Field>
                            <ErrorMessage class="text-red-500 text-sm" name="message" />
                        </div>
                        <Button type="submit" label="Submit" variant="outlined" class="w-full" :loading="isLoading" />
                    </div>
                </div>
            </VForm>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useMutation } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { useAuthStore } from '@/stores/auth';
import { ElMessage } from 'element-plus';
import { block, unblock } from '@/libs/utils';
import * as Yup from 'yup'
import Textarea from 'primevue/textarea';

interface Form {
    name: string;
    email: string;
    subject: string;
    message: string;
    type: string
}

const form = ref<Form>({} as Form)
const formRef = ref<any>(null)
const formSchema = Yup.object().shape({
    email: Yup.string().email('Invalid Email').required().label('Email'),
    name: Yup.string().required('Name field cannot be empty'),
    subject: Yup.string().required('Subject field cannot be empty'),
    message: Yup.string().required('Message field cannot be empty')
})

const options = ref([
    {name: 'Suggestion', code: 'Suggestion'},
    {name: 'Complaint', code: 'Complaint'},
    {name: 'Other...', code: 'Other...'},
])

const { user, isAuthenticated } = useAuthStore()

const { mutate: handleSubmit, isLoading } = useMutation({
    mutationKey: ['send-message'],
    mutationFn: (data: Form) => axios.post('/contact-us', data),
    onMutate: () => block(document.getElementById('form-contact')),
    onError: (err: any) => {
        console.error(err.response.data.message),
            ElMessage.error(err.response.data.message)
    },
    onSuccess: (res: any) => ElMessage.success(res.data.message),
    onSettled: () => unblock(document.getElementById('form-contact'))
})

onMounted(() => {
    if(isAuthenticated){
        form.value.email = user.email,
        form.value.name = user.name
    }
})
</script>
