<template>
    <main class="pt-19">
        <TransitionRoot appear :show="!isLoading" as="div">
            <div class="flex flex-col mx-4 space-y-4 py-4">
                <TransitionChild 
                    as="div"
                    enter="transform transition-all delay-300 ease-out duration-1000"
                    enter-from="opacity-0 translate-y-12"
                    enter-to="opacity-100 translate-y-0"
                    leave="transform transition-all duration-500 ease-in"
                    leave-from="opacity-100 translate-y-0"
                    leave-to="opacity-0 translate-y-12"
                    class="flex flex-col space-y-5"
                >
                    <div class="p-2 rounded-3xl border md:w-1/6 sm:w-1/5 w-1/4 flex justify-center">
                        <span class="lg:text-xl text-xs font-semibold">Coming Soon Movie</span>
                    </div>
                    <div class="flex space-x-7">
                        <div v-for="(films, index) in data" :key="films.uuid" class="flex flex-col space-y-3" :style="{
                            transition: 'all 0.7s ease',
                            transitionDelay: `${600 + (index * 100)}ms`
                        }"
                        data-aos="fade-up"
                        data-aos-mirror="true"
                        data-aos-anchor-placement="top-center"
                        >
                            <img :src="films?.poster" class="h-64 w-45 object-cover rounded-2xl" alt="">
                            <span class="text-center">{{ films.title }}</span>
                        </div>
                    </div>
            </TransitionChild>
            </div>
        </TransitionRoot>
        <div v-if="isLoading" class="animate-pulse flex flex-col gap-5 py-4">
            <!-- ANIMATE SHOWING -->
            <div class="flex flex-col mx-4 space-y-4">
                <!-- HEADER -->
                <div class="p-3 rounded-3xl md:w-1/6 sm:w-1/5 w-1/4 bg-zinc-800 grid grid-cols-10">
                    <div class="h-2.5 bg-zinc-700 rounded col-span-10"></div>
                </div>

                <!-- BODY -->
                <div class="flex w-full">
                    <div class="flex flex-col gap-2 items-center mr-5" v-for="i in 3" :key="i">
                        <div class="h-64 w-45 bg-zinc-700 rounded-2xl"></div>
                        <div class="h-2.5 w-36 bg-zinc-700 rounded-2xl"></div>
                    </div>
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
import { TransitionRoot, TransitionChild } from '@headlessui/vue';
import AOS from 'aos'

const { data, isLoading } = useQuery({
    queryKey: ['film', 'coming-soon'],
    queryFn: async () => await axios.get('/master/film/coming-soon').then((res: any) => res.data.data),
    onError: (err: any) => console.error(err.response.data.message)
})

onMounted(() => AOS.init({duration: 100, once: false, mirror: true, anchorPlacement: 'top-center',}))

</script>