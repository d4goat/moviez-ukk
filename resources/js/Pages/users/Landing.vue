<template>
    <div class="flex flex-col gap-5 py-4">
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
        <div class="flex flex-col mx-4 space-y-4" id="now-showing">
            <!-- HEADER -->
            <div class="p-2 rounded-3xl border md:w-1/6 sm:w-1/5 w-1/4 flex justify-center">
                <span class="lg:text-xl text-xs font-semibold">Top Rating Movie</span>
            </div>
            <div class="flex space-x-7">
                <div class="flex flex-col space-y-3"  v-for="reviews in review" :key="reviews.uuid">
                    <img :src="reviews?.poster" class="h-64 object-cover rounded-2xl" alt="">
                    <div class="text-center flex gap-3 justify-center"> <vue3starRatings :star-size="22" v-model="reviews.reviews_avg_rating" :disable-click="true" 
                        star-color="#ffea06" inactive-color="#bdbdbd" /> </div>
                    <span class="text-center">{{ reviews.title }}</span>
                </div>
            </div>
        </div>

        <!-- Now Showing Movie -->
         <div class="flex flex-col mx-4 space-y-4">
            <!-- HEADER -->
            <div class="p-2 rounded-3xl border md:w-1/6 sm:w-1/5 w-1/4 flex justify-center">
                <span class="lg:text-xl text-xs font-semibold">Now Showing</span>
            </div>

            <!-- BODY -->
            <div class="flex space-x-7">
                <div class="flex flex-col space-y-3" v-for="films in film" :key="films.uuid">
                    <img :src="films?.poster" class="h-64 object-cover rounded-2xl" alt="">
                    <div class="text-center"> {{ films.title }} </div>
                </div>
            </div>
         </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted, defineComponent } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { Film } from '@/types';
import axios from '@/libs/axios';
import vue3starRatings from "vue3-star-ratings";


defineComponent({
    components: {
        vue3starRatings
    }
})

const { data: review, refetch, isLoading } = useQuery({
    queryKey: ['film-top', 'top-rate-film'],
    queryFn: () => axios.get('/master/film/top-film').then((res: any) => res.data.data)
})

const { data: film, refetch: refetchFilm } = useQuery({
    queryKey: ['film', 'all'],
    queryFn: async ()  => await axios.get('/master/film').then((res: any) => res.data.data)
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

<style>
.cas{
    background-color: #ffea06;
}
</style>