<template>
  <main>
    <TransitionRoot appear :show="!isLoading && !isLoadingFilm" as="div">
      <div class="flex flex-col gap-5 py-4">
        <div class="flex relative">
          <TransitionChild enter="transform transition-all duration-1000 ease-out" enter-from="opacity-0"
            enter-to="opacity-100" leave="transform transition-all duration-500 ease-in" leave-from="opacity-100"
            leave-to="opacity-0" class="w-full" as="div">
              <Carousel :value="setting.photos" :responsive-options="responsiveOptions" circular :showNavigators="false" :showIndicators="false" :autoplayInterval="4000">
                <template #item="props">
                    <img :src="'/storage/' + props.data.image" alt="" class="object-cover h-150 w-full brightness-[.40] contrast-[.9] shadow-inner">
                </template>
              </Carousel>
          </TransitionChild>
          <TransitionChild as="div" enter="transform transition-all duration-1000 ease-out delay-300"
            enter-from="opacity-0 translate-y-12 scale-90" enter-to="opacity-100 translate-y-0 scale-100"
            leave="transform transition-all duration-500 ease-in" leave-from="opacity-100 translate-y-0 scale-100"
            leave-to="opacity-0 translate-y-12 scale-90"
            class="absolute top-1/3 mt-10 start-1/2 -translate-x-1/2 text-center w-full">
            <div class="flex flex-col items-center space-y-4">
              <TransitionChild as="h1" enter="transform transition-all duration-1000 ease-out"
                enter-from="opacity-0 -translate-y-8" enter-to="opacity-100 translate-y-0"
                leave="transform transition-all duration-300 ease-in" leave-from="opacity-100 translate-y-0"
                leave-to="opacity-0 -translate-y-8" class="lg:text-title-xl text-2xl font-semibold tracking-wide">
                Get Your Cinema Ticket
              </TransitionChild>

              <TransitionChild as="h1" enter="transform transition-all duration-1000 ease-out delay-200"
                enter-from="opacity-0 translate-y-8" enter-to="opacity-100 translate-y-0"
                leave="transform transition-all duration-300 ease-in" leave-from="opacity-100 translate-y-0"
                leave-to="opacity-0 translate-y-8" class="lg:text-title-sm text-sm">
                Anytime, Anywhere with {{ setting?.name }}
              </TransitionChild>
            </div>
          </TransitionChild>
        </div>

        <!-- Rest of the content with its own transition -->
        <TransitionChild as="div" enter="transform transition-all duration-700 ease-out delay-500"
          enter-from="opacity-0 translate-y-8" enter-to="opacity-100 translate-y-0"
          leave="transform transition-all duration-500 ease-in" leave-from="opacity-100 translate-y-0"
          leave-to="opacity-0 translate-y-8" class="space-y-5">
          <!-- Top Rating Movies Section -->
          <div class="flex flex-col mx-4 space-y-4">
            <Chip class="w-fit font-semibold text-xl lg:m-3" label="Top Rating Movie" />
            <div class="flex lg:flex-row flex-col flex-wrap gap-7">
              <div v-for="(reviews, index) in review" :key="reviews.uuid" class="flex flex-col space-y-3 items-center"
                :style="{
                  transition: 'all 0.7s ease',
                  transitionDelay: `${600 + (index * 100)}ms`
                }">
                <router-link :to="`/landing/film-detail/${reviews.uuid}`">
                  <img :src="reviews?.poster"
                    class="h-48 w-36 lg:h-64 lg:w-45 object-cover hover:scale-105 transition ease-in-out duration-300 rounded-2xl"
                    alt="">
                </router-link>
                <vue3starRatings :star-size="20" v-model="reviews.reviews_avg_rating" :disable-click="true"
                  star-color="#ffea06" inactive-color="#bdbdbd" />
                <span class="text-center lg:text-base text-sm">{{ reviews.title }}</span>
              </div>
            </div>
          </div>

          <!-- Now Showing Section -->
          <div id="now-showing" class="flex flex-col mx-4 space-y-4">
            <Chip class="w-fit font-semibold text-xl lg:m-3" label="Now Showing Movie" />
            <div class="flex lg:flex-row flex-col flex-wrap gap-7">
              <div v-for="(films, index) in film" :key="films.uuid" class="flex flex-col space-y-3" :style="{
                transition: 'all 0.4s ease-out',
                transitionDelay: `${100 + (index * 100)}ms`
              }" data-aos="fade-up" data-aos-mirror="true" data-aos-anchor-placement="top-center">
                <router-link :to="`/landing/film-detail/${films.uuid}`">
                  <img :src="films?.poster"
                    class="h-48 w-36 lg:h-64 lg:w-45 object-cover hover:scale-105 transition ease-in-out duration-300 rounded-2xl"
                    alt="">
                </router-link>
                <div class="text-center lg:text-base text-sm">{{ films.title }}</div>
              </div>
            </div>
          </div>
          <div id="coming-soon" class="flex flex-col mx-4 space-y-4 py-4">
            <Chip class="w-fit font-semibold text-xl lg:m-3" label="Coming Soon Movie" />
            <div class="flex lg:flex-row flex-col flex-wrap gap-7">
              <div v-for="(films, index) in data" :key="films.uuid" class="flex flex-col space-y-3" :style="{
                transition: 'all 0.7s ease',
                transitionDelay: `${200 + (index * 100)}ms`
              }" data-aos="fade-up" data-aos-mirror="true" data-aos-anchor-placement="top-center">
                <img :src="films?.poster" class="h-48 w-36 lg:h-64 lg:w-45 hover:scale-105 transition ease-in-out duration-300 object-cover rounded-2xl" alt="">
                <span class="text-center lg:text-base text-sm">{{ films.title }}</span>
              </div>
            </div>
          </div>
        </TransitionChild>
      </div>
    </TransitionRoot>
    <div v-if="isLoading" class="animate-pulse flex flex-col gap-5 py-4">
      <!-- ANIMATE SHOWING -->
      <div class="flex flex-col mx-4 space-y-4">
        <!-- HEADER -->
        <div class="rounded-3xl md:w-1/6 sm:w-1/5 w-1/4 bg-zinc-800 grid grid-cols-10">
          <div class="h-2.5 bg-zinc-700 rounded col-span-10"></div>
        </div>

        <!-- BODY
          <div class="flex w-full">
              <div class="flex flex-col gap-2 items-center mr-5" v-for="i in 3" :key="i">
                  <div class="h-48 w-36 lg:h-64 lg:w-45 bg-zinc-700 rounded-2xl"></div>
                  <div class="h-2.5 w-36 bg-zinc-700 rounded-2xl"></div>
              </div>
          </div> -->
      </div>
    </div>
    <div v-if="isLoading && isLoadingFilm" class="animate-pulse flex flex-col gap-5 py-4">
      <div class="flex">
        <div class="w-full h-115 bg-zinc-800">
          <div class="absolute top-1/3 start-1/2 -translate-x-1/2 -translate-y-1/2">
            <div class="flex-1">
              <div class="grid grid-cols-16 gap-4 ">
                <div class="h-2.5 bg-zinc-700 rounded col-span-16"></div>
                <div class="h-2.5 bg-zinc-700 rounded col-start-3 col-span-12"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- ANIMATE SHOWING -->
      <div class="flex flex-col mx-4 space-y-4">
        <!-- HEADER -->
        <div class="h-3 m-3 md:w-1/6 sm:w-1/5 w-1/4 bg-zinc-700 rounded col-span-10"></div>

        <!-- BODY -->
        <div class="flex w-full">
          <div class="flex flex-col gap-2 items-center mr-5" v-for="i in 3" :key="i">
            <div class="h-48 w-36 lg:h-64 lg:w-45 bg-zinc-800 rounded-2xl"></div>
            <div class="h-2.5 w-24 bg-zinc-700 rounded-2xl"></div>
            <div class="h-2.5 w-36 bg-zinc-700 rounded-2xl"></div>
          </div>
        </div>
      </div>
      <div class="flex flex-col mx-4 space-y-4">
        <!-- HEADER -->
        <div class="h-3 m-3 md:w-1/6 sm:w-1/5 w-1/4 bg-zinc-700 rounded col-span-10"></div>

        <!-- BODY -->
        <div class="flex w-full">
          <div class="flex flex-col gap-2 items-center mr-5" v-for="i in 4" :key="i">
            <div class="h-48 w-36 lg:h-64 lg:w-45 bg-zinc-800 rounded-2xl"></div>
            <div class="h-2.5 w-36 bg-zinc-700 rounded-2xl"></div>
          </div>
        </div>
      </div>
      <div class="flex flex-col mx-4 space-y-4">
        <!-- HEADER -->
        <div class="h-3 m-3 md:w-1/6 sm:w-1/5 w-1/4 bg-zinc-700 rounded col-span-10"></div>

        <!-- BODY -->
        <div class="flex w-full">
          <div class="flex flex-col gap-2 items-center mr-5" v-for="i in 4" :key="i">
            <div class="h-48 w-36 lg:h-64 lg:w-45 bg-zinc-800 rounded-2xl"></div>
            <div class="h-2.5 w-36 bg-zinc-700 rounded-2xl"></div>
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script setup lang="ts">
import { ref, onMounted, defineComponent } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { Film } from '@/types';
import axios from '@/libs/axios';
import vue3starRatings from "vue3-star-ratings";
import { useSetting } from '@/services';
import { TransitionRoot, TransitionChild } from '@headlessui/vue'
import AOS from 'aos'
import Chip from 'primevue/chip';

defineComponent({
  components: {
    vue3starRatings,
    Chip
  }
})

const responsiveOptions = ref([
    {
        breakpoint: '1400px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '1199px',
        numVisible: 3,
        numScroll: 1
    },
    {
        breakpoint: '767px',
        numVisible: 2,
        numScroll: 1
    },
    {
        breakpoint: '575px',
        numVisible: 1,
        numScroll: 1
    }
]);

const { data: review, refetch, isLoading } = useQuery({
  queryKey: ['film-top', 'top-rate-film'],
  queryFn: () => axios.get('/master/film/top-film').then((res: any) => res.data.data)
})

const { data: film, refetch: refetchFilm, isLoading: isLoadingFilm } = useQuery({
  queryKey: ['film', 'all'],
  queryFn: async () => await axios.get('/master/film/now-showing').then((res: any) => res.data.data)
})

const { data, isLoading: isLoadingComing } = useQuery({
  queryKey: ['film', 'coming-soon'],
  queryFn: async () => await axios.get('/master/film/coming-soon').then((res: any) => res.data.data),
  onError: (err: any) => console.error(err.response.data.message)
})

const { data: setting, refetch: refetchSetting } = useSetting()

onMounted(() => {
  refetch()
  refetchSetting()
  AOS.init({
    duration: 100,
    once: true,
    mirror: false,
    anchorPlacement: 'top-center',
  })
})
</script>
