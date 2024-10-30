<template>
    <div class="flex flex-col gap-5">
        <div class="flex">
            <img :src="setting?.logo" alt="background dashboard" class="object-cover h-115 w-full rounded-b-[2rem] brightness-50 contrast-[.85]">
            <div class="absolute top-1/3 start-1/2 -translate-x-1/2 -translate-y-1/2 text-center">
                <div class="flex flex-col">
                    <h1 class="text-title-xl font-semibold">Get Your Cinema Ticket</h1>
                    <h1 class="text-title-sm">Anytime, Anywhere with Cinema51</h1>
                </div>
            </div>
        </div>

        <!-- Top Rating Movie -->
        <div class="flex flex-col mx-4 space-y-4">
            <div class="p-2 rounded-3xl border w-1/6 flex justify-center">
                <span class="text-xl font-semibold">Top Rating Movie</span>
            </div>
            <div class="flex space-x-3" v-for="reviews in review" :key="reviews.uuid">
                <div class="flex flex-col space-y-3">
                    <img :src="`/storage/${reviews?.poster}`" class="h-64 object-cover rounded-2xl" alt="">
                    <span class="text-center">{{ reviews.reviews_avg_rating }}</span>
                    <span class="text-center">{{ reviews.title }}</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { Film } from '@/types';
import axios from '@/libs/axios';

const { data: review, refetch, isLoading } = useQuery({
    queryKey: ['film-top', 'top-rate-film'],
    queryFn: () => axios.get('/master/film/top-film').then((res: any) => res.data.data)
})

const { data: setting, refetch: refetchSetting } = useQuery({
    queryKey: ['setting', 'show'],
    queryFn: () => axios.get('/setting').then((res: any) => res.data)
})

onMounted(() => {
    refetch()
    refetchSetting()
})
</script>