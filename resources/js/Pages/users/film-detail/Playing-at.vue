<template>
    <main class="pt-21">
        <section class="mx-18 flex flex-col gap-5">
            <div class="flex flex-row justify-between">
                <div class="col-md-2">
                    <select2 :options="cities" v-model="kota" class="form-select-solid" placeholder="Select City">
                    </select2>
                </div>
                <div class="flex gap-2 bg-dropdown border-none focus:ring-dropdown rounded-lg px-2">
                    <Field name="search" v-model="search" placeholder="Search Cinema.."
                        class="bg-dropdown p-2.5 rounded-xl border-none focus:ring-dropdown" autocomplete="off" />
                </div>
            </div>
            <TransitionRoot appear :show="!isFetching" as="template">
                <TransitionChild enter="transform transiton-all duration-500 delay-300 ease-out"
                    enter-from="opacity-0 -translate-x-8" enter-to="opacity-100 translate-x-0"
                    leave="transform transition-all duration-500 delay-300 ease-in"
                    leave-from="opacity-100 translate-x-0" leave-to="opacity-0 translate-x-8">
                    <div v-if="filtered.length > 0" class="flex flex-col w-full h-full">
                        <template v-for="(cinema, index) in filtered" :key="cinema">
                            <div class="bg-dropdown rounded-lg p-4 flex flex-row items-center justify-between w-full"
                                :style="{ transition: 'all 0.7s ease', transitionDelay: `${600 + (index * 100)}ms` }">
                                <span class="text-lg font-medium"> {{ cinema.name }} </span>
                                <div class="flex flex-row gap-4">
                                    <template v-for="show in cinema.show_times" :key="show.uuid">
                                        <div class="bg-gray-900 rounded-xl py-2 px-3">
                                            <button type="button" @click="openModal(cinema.name, show)"
                                                class="btn btn-sm text-white font-medium"> {{ show.start_time }}
                                            </button>
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
                                    class="w-full max-w-xl transform overflow-hidden rounded-2xl bg-[#222222] p-6 text-left align-middle shadow-xl transition-all">
                                    <DialogTitle as="h3"
                                        class="text-lg font-medium border-b border-stone-600 leading-6 text-white pb-2.5">
                                        How Many Ticket Needed?
                                    </DialogTitle>
                                    <div class="mt-2 text-white text-lg">
                                        <span>Ticket Booking For : </span>
                                        <VForm @submit="booking" class="flex flex-col">
                                            <div class="flex flex-col mt-2 space-y-1">
                                                <span>Movie : <span class="font-medium">{{ film?.title }}</span></span>
                                                <span>Cinema : <span class="font-medium">{{ name }}</span></span>
                                                <span>Date : <span class="font-medium">{{ date }} : {{ selected }}</span></span>
                                                <div class="flex justify-between">
                                                    <span>Ticket :</span>
                                                    <div class="flex flex-row items-center gap-3 text-gray-500">
                                                        <button type="button" @click="decrement">
                                                            <Minus :size="15" :class="quantity === 1 ? 'text-gray-500' : 'text-white'" />
                                                        </button>
                                                        <span :class="['transition-all duration-75', quantity === 10 ? 'text-gray-500' : 'text-white']"> {{ quantity }} </span>
                                                        <button type="button" @click="increment">
                                                            <Plus :size="15" :class="quantity === 10 ? 'text-gray-500' : 'text-white'" />
                                                        </button>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="text-xs">*Your ticket <strong>cannot be refund</strong> or
                                                    <strong>refunded</strong></span>
                                                </div>
                                                <button type="submit"
                                                class="w-full bg-stone-600 rounded-xl pb-1 font-medium">Continue</button>
                                            </div>
                                        </VForm>
                                    </div>
                                </DialogPanel>
                            </TransitionChild>
                        </div>
                    </div>
                </Dialog>
            </TransitionRoot>
        </section>
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted, computed, watch } from 'vue';
import { useMutation, useQuery } from '@tanstack/vue-query';
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import { toast } from 'vue3-toastify';
import { useCities } from '@/services';
import { TransitionRoot, TransitionChild, Dialog, DialogTitle, DialogPanel } from '@headlessui/vue';
import { Cinema, Booking, ShowTime } from '@/types';
import moment from 'moment'
import { useAuthStore } from '@/stores/auth';
import { block } from '@/libs/utils';
import { Plus, Minus } from 'lucide-vue-next';

interface City {
    code: number;
    name: string
}

const isOpen = ref(false)

const route = useRoute()
const router = useRouter()
const kota = ref()
const search = ref('')
const { user } = useAuthStore()

const name = ref('')
const selected = ref()
const date = ref(moment().format('YYYY-MM-DD'))
const quantity = ref(1)
const form = ref<Booking>({
    ...user
} as Booking)

function increment() {
    if (quantity.value < 10) return quantity.value++
}

function decrement() {
    if (quantity.value > 1) return quantity.value--
}

const openModal = (cinema: string, show: ShowTime) => {
    form.value.show_time_id = show.id
    selected.value = show.start_time
    name.value = cinema
    isOpen.value = true
}

const { data, isFetching, refetch } = useQuery({
    queryKey: ['show-time', 'playing-at'],
    queryFn: async () => await axios.post('/master/show-time/get-list', { uuid: route.params.uuid, city: kota.value }).then((res: any) => res.data.data),
    onError: (err: any) => toast.error(err.response.data.message),
    cacheTime: 0
})

const { data: film, isLoading } = useQuery({
    queryKey: ['film', route.params.uuid],
    queryFn: async () => await axios.get(`/master/film/${route.params.uuid}`).then((res: any) => res.data.data),
    cacheTime: 0
})

const { mutate: booking, isLoading: isLoadingBooking } = useMutation({
    mutationKey: ['booking'],
    mutationFn: async () => {
        const formData = new FormData()
        formData.append('tanggal', date.value)
        formData.append('quantity', quantity.value)
        formData.append('user_id', user.id)
        formData.append('show_time_id', form.value.show_time_id)

        return await axios.post('/master/booking/store', formData)
    },
    onMutate: () => block(document.querySelector("#form-data")),
    onSuccess: (res: any) => {
        router.push({ name: 'landing.booking.select-seat', params: { uuid: res.data.uuid } })
    },
    onError: (err: any) => {
        toast.error(err.response.data.message)
        console.error(err.response.data.message)
    }
})

const city = useCities()
const cities = computed(() =>
    city.data.value?.map((item: City) => ({
        id: item.code,
        text: item.name
    }))
)

const filtered = computed(() => {
    if (!search.value) return data.value

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