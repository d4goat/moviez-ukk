<template>
    <main class="pt-19">
        <div class="flex flex-col mx-4 space-y-4">
            <div class="p-2 rounded-3xl border md:w-1/6 sm:w-1/5 w-1/4 flex justify-center">
                <span class="lg:text-xl text-xs font-semibold">Coming Soon Movie</span>
            </div>
            <div class="flex space-x-7">
                <div v-for="(films, index) in data" :key="films.uuid" class="flex flex-col space-y-3" :style="{
                    transition: 'all 0.7s ease',
                    transitionDelay: `${600 + (index * 100)}ms`
                }">
                    <img :src="films?.poster" class="h-64 w-45 object-cover rounded-2xl" alt="">
                    <span class="text-center">{{ films.title }}</span>
                </div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import axios from '@/libs/axios';
import { block, unblock } from '@/libs/utils';

const { data } = useQuery({
    queryKey: ['film', 'coming-soon'],
    queryFn: async () => await axios.get('/master/film/coming-soon').then((res: any) => res.data.data),
    onError: (err: any) => console.error(err.response.data.message)
})


</script>