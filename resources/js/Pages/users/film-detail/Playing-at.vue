<template>
    <main class="pt-21">
        <section class="mx-18 flex flex-col gap-5">
            <div class="flex flex-row justify-between">
                <div class="col-md-2">
                    <select2 :options="cities" v-model="kota" class="form-select-solid" placeholder="Select City"></select2>
                </div>
                <div class="flex gap-2 bg-dropdown border-none focus:ring-dropdown rounded-lg px-2">
                    <Field name="search" v-model="search" class="bg-dropdown p-2.5 rounded-xl border-none focus:ring-dropdown" autocomplete="off" />
                </div>
            </div>
            <TransitionRoot appear :show="!isFetching" as="template">
                <TransitionChild 
                enter="transform transiton-all duration-700 delay-500 ease-in"
                enter-from="opacity-0 translate-x-4" enter-to="opacity-100 translate-x-0"
                leave="transform transition-all duration-700 delay-500 ease-out"
                leave-from="opacity-100 tranlaste-x-0" leave-to="opacity-0 translate-x-4">
                <div v-if="filtered.length > 0" class="flex flex-col space-y-4 w-full h-full">
                    <template v-for="(cinema, index) in filtered" :key="data">
                        
                    </template>
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
    queryFn: async () => await axios.post('/master/show-time/get-list', { uuid: route.params.uuid }).then((res: any) => res.data.data),
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