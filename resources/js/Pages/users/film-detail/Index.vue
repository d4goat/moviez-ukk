<template>
    <main class="pt-21">
        <div v-if="!isLoading" class="flex flex-col gap-4">
            <div class="col-md-12"></div>
            <div class="flex space-x-10 mx-4">
                <img :src="data.poster" alt="" class="h-72 w-48 rounded-2xl">
                <div class="flex flex-col gap-4 my-3 w-full">
                    <div class="flex flex-col gap-1">
                        <span class="text-title-md font-medium"> {{ data.title }} </span>
                        <span class="text-sm font-medium"><i class="fa-regular fa-clock mr-1"></i> {{ data.duration }}
                            Minutes</span>
                    </div>
                    <div class="flex flex-col mt-4 gap-4">
                        <button type="button" class="bg-cinema py-2 rounded-md text-white font-medium w-1/6">Playing At</button>
                        <button type="button" class="bg-cinema py-2 rounded-md text-white font-medium w-1/6">Trailer</button>
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
                    <div class="flex flex-row font-semibold">
                        Cast : <span class="ml-2 font-normal" v-for="(cast, index) in data.casts" :key="cast.uuid">
                            {{ cast.cast_name }}{{ index < data.casts.length - 1 ? ', ' : '.' }} </span>
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
import { toast } from 'vue3-toastify';

const route = useRoute();

const { data, refetch, isLoading } = useQuery({
    queryKey: ["film", route.params.uuid],
    queryFn: async () => await axios.get(`/master/film/${route.params.uuid}`).then((res: any) => res.data.data),
    onError: (err: any) => {
        toast.error(err.response.data.message)
        console.error(err.response.data.message)
    }
})

onMounted(() => refetch())
</script>