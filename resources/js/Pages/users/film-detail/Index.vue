<template>
    <main class="pt-21">
        <div v-if="!isLoading" class="flex flex-col gap-4">
            <TransitionRoot appear :show="isOpen" as="template">
                <Dialog as="div" @close="isOpen = false" class="relative z-10">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                        enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100"
                        leave-to="opacity-0">
                        <div class="fixed inset-0 bg-[#171717a2]" />
                    </TransitionChild>
                    <div class="fixed inset-0">
                        <div class="flex min-h-full items-center justify-center p-4">
                            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                                enter-to="opacity-100 scale-100" leave="duration-200 ease-in"
                                leave-from="opacity-100 scale-100" leave-to="opacity-0 scale-95">
                                <DialogPanel
                                    class="w-full max-w-5xl transform overflow-hidden rounded-2xl bg-[#222222] p-6 text-left align-middle shadow-xl transition-all">
                                    <DialogTitle as="h3"
                                        class="text-lg font-medium border-b flex justify-between border-stone-600 leading-6 text-white pb-2.5">
                                        <span>{{ data.title }} Trailer</span>
                                        <X @click="isOpen = false" color="#57534e" class="cursor-pointer" />
                                    </DialogTitle>
                                    <div class="mt-4 flex justify-center">
                                        <iframe :src="data.trailer" width="1000" class="rounded-xl" height="500" frameborder="0"></iframe>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
            <div class="col-md-12"></div>
            <div class="flex space-x-10 mx-4">
                <img :src="data.poster" :alt="data.title" class="h-72 w-48 rounded-2xl">
                <div class="flex flex-col gap-4 my-3 w-full">
                    <div class="flex flex-col gap-1">
                        <span class="text-title-md font-medium"> {{ data.title }} </span>
                        <span class="text-sm font-medium"><i class="fa-regular fa-clock mr-1"></i> {{ data.duration }}
                            Minutes</span>
                    </div>
                    <div class="flex flex-col mt-4 gap-4">
                        <router-link
                            :to="{ name: 'landing.playing-at', params: { uuid: data.uuid }, query: { title: data.title } }"
                            type="button"
                            class="hover:bg-cinema bg-cyan-600 transition-colors duration-300 py-2 rounded-md text-white text-center font-medium w-1/6">Playing
                            At</router-link>
                        <button @click="isOpen = true" type="button"
                            class="hover:bg-cinema bg-cyan-600 transition-colors duration-300 text-center py-2 rounded-md text-white font-medium w-1/6">Trailer</button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col mx-4 space-y-6">
                <span class="text-wrap">{{ data.description }} </span>
                <div class="flex flex-col">
                    <span class="font-semibold">Producer : <span class="font-normal"> {{ data.producer }} </span>
                    </span>
                    <span class="font-semibold">Director : <span class="font-normal"> {{ data.director }} </span>
                    </span>
                    <span class="font-semibold">Writter : <span class="font-normal"> {{ data.writer }} </span>
                    </span>
                    <div class="flex flex-row flex-wrap font-semibold">
                        <span>Cast:</span>
                        <span class="ml-2 font-normal" v-for="(cast, index) in data.casts" :key="cast.uuid">
                            {{ cast.cast_name }}<span v-if="index < data.casts.length - 1">,</span>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div v-else class="animate-pulse">
            <div class="flex flex-col gap-4">
                <div class="col-md-12"></div>
                <div class="flex space-x-10 mx-4">
                    <div class="h-72 w-56 bg-zinc-800 rounded-2xl"></div>
                    <div class="flex flex-col gap-4 my-3 w-full">
                        <div class="flex flex-col gap-1">
                            <div class="h-3 w-1/3 bg-zinc-800 rounded"></div>
                            <div class="h-3 w-1/5 bg-zinc-800 rounded"></div>
                        </div>
                        <div class="flex flex-col mt-4 gap-4">
                            <div class="bg-zinc-800 py-3 rounded-sm w-1/6"></div>
                            <div class="bg-zinc-800 py-3 rounded-sm w-1/6"></div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col mx-4 space-y-6">
                    <div class="h-4 w-1/2 bg-zinc-800 rounded"></div>
                    <div class="flex flex-col space-y-4">
                        <div class="h-4 w-1/2 bg-zinc-800 rounded"></div>
                        <div class="h-4 w-1/4 bg-zinc-800 rounded"></div>
                        <div class="h-4 w-1/4 bg-zinc-800 rounded"></div>
                        <div class="h-4 w-1/3 bg-zinc-800 rounded"></div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { useQuery } from '@tanstack/vue-query';
import { ref, onMounted } from 'vue';
import { useRoute } from 'vue-router';
import axios from '@/libs/axios';
import { ElMessage } from 'element-plus';
import { ApiResponse, Film } from '@/types';
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'
import { X } from 'lucide-vue-next';

const isOpen = ref(false)
const route = useRoute();

const { data, refetch, isLoading } = useQuery({
    queryKey: ["film", route.params.uuid],
    queryFn: async (): Promise<Film> => await axios.get<ApiResponse<Film>>(`/master/film/${route.params.uuid}`).then(res => res.data.data),
    onError: (err: any) => {
        ElMessage.error(err.response.data.message)
        console.error(err.response.data.message)
    }
})

onMounted(() => refetch())
</script>
