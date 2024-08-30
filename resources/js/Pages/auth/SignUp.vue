<script setup lang="ts">
import { ref } from 'vue';
import axios from '@/libs/axios';

interface formData {
    name: string;
    email: string;
    phone: string;
    password: string;
    password_confirmation: string;
    photo?: File;
}

const formData = ref<formData>({})
</script>

<template>
    <main>
        <div class="h-screen w-full">
            <img src="/images/bg-2.jpg" class="absolute md:pl-36 inset-0 w-full h-full object-cover" alt="">
            <div class="w-[43%] h-full bg-gray-200 z-10 absolute top-0 left-0 p-6 items-center justify-center">
                <div class="w-full h-full flex items-center justify-center">
                    <div class="w-full max-w-md flex flex-col border-[1px] border-gray-700 rounded-xl p-6 space-y-4">
                        <!-- begin:title -->
                        <h2 class="text-xl font-semibold mb-7 text-center">Registrasi</h2>
                        <!-- end:title -->

                        <VForm class="flex flex-col gap-5">
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Nama</label>
                                <!-- end:title:input -->
                                <Field  name="name" type="text" class="border p-2 rounded bg-transparent" placeholder="Enter your name" />
                                <ErrorMessage name="name" class="text-red-500" />
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Nama</label>
                                <!-- end:title:input -->
                                <Field  name="name" type="text" class="border p-2 rounded bg-transparent" placeholder="Enter your name" />
                                <ErrorMessage name="name" class="text-red-500" />
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Nama</label>
                                <!-- end:title:input -->
                                <Field  name="name" type="text" class="border p-2 rounded bg-transparent" placeholder="Enter your name" />
                                <ErrorMessage name="name" class="text-red-500" />
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Nama</label>
                                <!-- end:title:input -->
                                <Field  name="name" type="text" class="border p-2 rounded bg-transparent" placeholder="Enter your name" />
                                <ErrorMessage name="name" class="text-red-500" />
                            </div>
                            <!-- end:input -->
                            <!-- begin:input -->
                            <div class="flex flex-col gap-3">
                                <!-- begin:title:input -->
                                <label class="text-lg font-medium">Nama</label>
                                <!-- end:title:input -->
                                <Field  name="name" type="text" class="border p-2 rounded bg-transparent" placeholder="Enter your name" />
                                <ErrorMessage name="name" class="text-red-500" />
                            </div>
                            <!-- end:input -->

                            <div class="flex w-full justify-center mt-3">
                                <button type="submit" class="bg-sky-600 p-4 rounded-lg text-white texxt-semibold text-md">Registrasi</button>
                            </div>
                        </VForm>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>