<template>
    <main class="pt-21 font-medium">
        <div v-if="!isLoading" class="flex flex-col gap-4">
            <div class="col-md-12"></div>
            <div class="flex space-x-10 mx-4">
                <img :src="data.poster" alt="" class="h-72 w-42 rounded-2xl">
                <div class="flex flex-col gap-4 my-3">
                    <div class="flex flex-col gap-1">
                        <span class=" text-title-md"> {{ data.title }} </span>
                        <span class="text-sm"><i class="fa-regular fa-clock mr-1"></i> {{ data.duration }} Minutes</span>
                    </div>
                    <div class="flex flex-col mt-4 gap-4">
                        <button type="button" class="bg-cinema py-2 rounded-sm text-white  w-1/2">Playing At</button>
                        <button type="button" class="bg-cinema py-2 rounded-sm text-white  w-1/2">Trailer</button>
                    </div>
                </div>
            </div>
            <div class="flex flex-col mx-4 space-y-6">
                <span class=" text-wrap"> {{ data.description }} </span>
                <div class="flex flex-col">
                    <span>Producer :  {{ data.producer }} </span>
                    <span>Director :  {{ data.director }} </span>
                    <span>Writter :  {{ data.writer }} </span>
                    <div class="flex flex-row">
                        Cast : <span class="ml-2" v-for="(cast, index) in data.casts" :key="cast.uuid"> 
                            {{ cast.cast_name }}{{ index < data.casts.length - 1 ? ', ' : '.' }}
                        </span>
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