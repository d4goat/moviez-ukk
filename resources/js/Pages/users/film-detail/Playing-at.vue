<template>
    <main class="pt-21">
        <section class="mx-18 flex flex-col gap-5">
            <div class="flex flex-row justify-between">
                <div class="col-md-2">
                    <select2 :options="cities" v-model="kota" class="form-select-solid" placeholder="Select City"></select2>
                </div>
                <div class="flex gap-2 bg-dropdown border-none focus:ring-dropdown rounded-lg px-2">
                    <Field name="search" v-model="search" placeholder="Search Cinema.." class="bg-dropdown p-2.5 rounded-xl border-none focus:ring-dropdown" autocomplete="off" />
                </div>
            </div>
            <TransitionRoot appear :show="!isFetching" as="template">
                <TransitionChild 
                enter="transform transiton-all duration-500 delay-300 ease-out"
                enter-from="opacity-0 -translate-x-8" enter-to="opacity-100 translate-x-0"
                leave="transform transition-all duration-500 delay-300 ease-in"
                leave-from="opacity-100 translate-x-0" leave-to="opacity-0 translate-x-8">
                <div v-if="filtered.length > 0" class="flex flex-col w-full h-full">
                    <template v-for="(cinema, index) in filtered" :key="cinema">
                        <div class="bg-dropdown rounded-lg p-4 flex flex-row items-center justify-between w-full"
                            :style="{transition: 'all 0.7s ease', transitionDelay: `${600 + (index * 100)}ms`}"
                            >
                            <span class="text-lg font-medium"> {{ cinema.name }} </span>
                            <div class="flex flex-row gap-4">
                                <template v-for="show in cinema.show_times" :key="show.uuid">
                                    <div class="bg-gray-900 rounded-xl py-2 px-3">
                                        <span> {{ show.start_time }} </span>
                                    </div>                     
                                </template>
                            </div>
                        </div>
                    </template>
                </div>
                <div v-else class="flex flex-col justify-center min-h-64 items-center">
                    <!-- <img src="/images/vector/confused.png" alt=""> -->
                    <span class="text-xl">No Cinema Found</span>
                </div>
                </TransitionChild>
            </TransitionRoot>
        </section>
    </main>    
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { useRoute } from 'vue-router';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useCities } from '@/services';
import { TransitionRoot, TransitionChild, Dialog, DialogTitle, DialogPanel } from '@headlessui/vue';
import { Cinema } from '@/types';

interface City {
    code: number;
    name: string
}


const route = useRoute()
const kota = ref()
const search = ref('')

const { data, isFetching, refetch } = useQuery({
    queryKey: ['show-time', 'playing-at'],
    queryFn: async () => await axios.post('/master/show-time/get-list', { uuid: route.params.uuid, city: kota.value }).then((res: any) => res.data.data),
    onError: (err: any) => toast.error(err.response.data.message),
    cacheTime: 0
})

const city = useCities()
const cities = computed(() => 
    city.data.value?.map((item: City) => ({
        id: item.code,
        text: item.name
    }))
)

const filtered = computed(() => {
    if(!search.value) return data.value

    const query = search.value.toLowerCase()

    return data.value.filter((item: Cinema) => {
        return (
            item.name.toLowerCase().includes(query) ||
            item.address.toLowerCase().includes(query)
        )
    })
})

onMounted(() => refetch())

watch(kota, () => refetch())
</script>