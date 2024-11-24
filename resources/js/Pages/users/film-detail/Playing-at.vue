<template>
    <main class="pt-21">
        <section class="mx-18 flex flex-col gap-5">
            <div class="flex flex-row flex-wrap justify-between">
                <el-select-v2
                v-model="kota"
                    style="width: 240px;"
                    filterable
                    remote
                    clearable
                    :remote-method="remoteMethod"
                    :options="options"
                    :loading="loading"
                    size="large"
                    placeholder="Search city"
                >
                <template #loading>
                    <svg class="animate-spin h-7 w-7 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path class="opacity-50" fill="cyan" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                  </template>
            </el-select-v2>
                <Field name="search" v-model="search" placeholder="Search Cinema.."
                    class="bg-transparent p-2 rounded-lg text-sm border-[#46474a] focus:border-[#46474a] focus:ring-dropdown" autocomplete="off" />
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
                                        <button type="button" @click="openModal(cinema.name, show)"
                                            class=" bg-gray-900 rounded-xl py-2 px-3 text-white font-medium"> {{ show.start_time }}
                                        </button>
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
                                                <span>Movie : <span class="font-medium">{{ route.query.title }}</span></span>
                                                <span>Cinema : <span class="font-medium">{{ name }}</span></span>
                                                <span>Date : <span class="font-medium">{{ date }} : {{ selected.start_time }}</span></span>
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
            <TransitionRoot appear :show="isLoadingBooking" as="template">
                <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
                enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100"
                leave-to="opacity-0">

                <div class="fixed flex items-center justify-center inset-0 bg-[#171717a2] z-99999">
                    <svg class="animate-spin h-12 w-12 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <path class="opacity-75" fill="cyan" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </div>
                </TransitionChild>
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

interface ListItem {
    value: string;
    label: string
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
    selected.value = show
    name.value = cinema
    isOpen.value = true
}

const { data, isFetching, refetch } = useQuery({
    queryKey: ['show-time', 'playing-at'],
    queryFn: async () => await axios.post('/master/show-time/get-list', { uuid: route.params.uuid, city: kota.value }).then((res: any) => res.data.data),
    onError: (err: any) => toast.error(err.response.data.message),
    cacheTime: 0
})

const { mutate: booking, isLoading: isLoadingBooking } = useMutation({
    mutationKey: ['booking'],
    mutationFn: async () => {
        const formData = new FormData()
        formData.append('tanggal', date.value)
        formData.append('quantity', quantity.value)
        formData.append('total_price', selected.value.price * quantity.value)
        formData.append('user_id', user.id)
        formData.append('show_time_id', selected.value.id)

        return await axios.post('/master/booking/store', formData)
    },
    onSuccess: async (res: any) => {
        const data = new FormData()

        data.append('booking_id', res.data.data.id)
        data.append('amount', res.data.data.total_price)
        data.append('status', 2)
        
        const response = await axios.post('/master/payment/store', data).then((res: any) => res.data.data)
        router.push({ name: 'landing.booking.select-seat', params: { uuid: res.data.data.uuid }, query: { uuid_studio: selected.value.studio.uuid, uuid_payment: response.uuid, uuid_showtime: selected.value.uuid } })
    },
    onError: (err: any) => {
        toast.error(err.response.data.message)
        console.error(err.response.data.message)
    }
})

const city = useCities()
const cities = computed(() => {
    return Array.isArray(city.data.value)
        ? city.data.value.map((item: City) => ({
            value: item.code,
            label: item.name
        }))
        : [];
});

const options = ref<ListItem[]>([])
const loading = ref(false)

const remoteMethod = (query: string) => {
  if (query !== '') {
    loading.value = true
    setTimeout(() => {
      loading.value = false
      options.value = cities.value.filter((item: any) => {
        return item.label.toLowerCase().includes(query.toLowerCase())
      })
    }, 1000)
  } else {
    options.value = []
  }
}

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
