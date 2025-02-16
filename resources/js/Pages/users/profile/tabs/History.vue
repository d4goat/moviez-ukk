<template>
    <main class="w-full">
        <div class="card-header border-b pb-3 flex justify-between items-center border-gray-700">
            <span class="font-medium">History Booking</span>
            <el-input v-model="search" placeholder="Oppenheimer, The Marvels, etc.." style="width: 240px;" />
        </div>
        <div v-if="!isFetching" class="card-body flex flex-col space-y-6 my-3">
            <div v-if="filteredData?.length > 0" class="flex flex-col gap-6">
                <div v-for="history in filteredData" :key="history.uuid"
                    class="bg-dropdown shadow-md shadow-cyan-500/20 p-3 rounded-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Invoice Number</p>
                            <p class="font-medium text-base">{{ history.invoice_number }}</p>
                        </div>
                        <div class="text-end">
                            <p class="text-gray-400 text-sm">Booking Date</p>
                            <p class="font-medium text-base">{{ formatDate(history.tanggal) }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <p class="text-gray-400 text-sm">Film</p>
                        <p class="font-medium text-base">{{ history.show_time.film.title }}</p>
                    </div>
                    <div class="mt-3">
                        <p class="text-gray-400 text-sm">Cinema</p>
                        <p class="font-medium text-base">{{ history.show_time.studio.cinema.name }}</p>
                    </div>
                    <div class="mt-3 flex items-center justify-between">
                        <div>
                            <p class="text-gray-400 text-sm">Quantity</p>
                            <p class="font-medium text-base">{{ history.quantity }}</p>
                        </div>
                        <div class="text-end">
                            <p class="text-gray-400 text-sm">Total Price</p>
                            <p class="font-medium text-base">{{ currency(history.total_price) }}</p>
                        </div>
                    </div>
                    <div class="border-t border-gray-500 mt-2 py-2">
                        <router-link :to="{ name: 'landing.invoice', params: { uuid: history.uuid } }"
                            class="flex justify-between items-center">
                            <span>Detail</span>
                            <i class="fa-solid fa-chevron-right"></i>
                        </router-link>
                    </div>
                </div>
                <ul class="flex justify-between">
                    <span>Showing {{ data.from }} to  {{ data.to }} of {{ data.total }} </span>
                    <div class="flex  gap-2">
                        <li class="py-1 px-[12px] rounded-md"
                            :class="{ 'opacity-50 pointer-events-none': data?.current_page == 1 || !data }">
                            <span @click="page = data?.current_page - 1; refetch()" class="page-link cursor-pointer">
                                <i class="fa fa-angle-left"></i>
                            </span>
                        </li>
                        <li v-for="item in pagination" :key="item" @click="page = item; refetch()"
                            class="py-1 px-[12px] rounded-md" :class="{ 'bg-blue-600 text-white': item === page }">
                            <span class="page-link cursor-pointer">{{ item }}</span>
                        </li>
                        <li class="py-1 px-[12px] rounded-md"
                            :class="{ 'opacity-50 pointer-events-none': data?.current_page == data?.last_page || !data }">
                            <span @click="page = data?.current_page + 1; refetch()" class="page-link cursor-pointer">
                                <i class="fa fa-angle-right"></i>
                            </span>
                        </li>
                    </div>
                </ul>
            </div>
            <div v-else class="flex flex-col justify-center items-center">
                <span class="text-center capitalize text-xl font-medium">no history found</span>
            </div>
        </div>
        <div class="animate-pulse" v-else>
            <div class="flex flex-col gap-6">
                <div v-for="(item, index) in 3" :key="index" class="rounded-lg bg-dropdown h-30"></div>
            </div>
        </div>
    </main>
</template>

<script lang="ts">
import { ref, watch, onMounted, computed, defineComponent } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { useAuthStore } from '@/stores/auth';
import axios from '@/libs/axios';
import { Booking, ShowTime, Film, Studio, Cinema } from '@/types';
import { TransitionRoot, TransitionChild } from '@headlessui/vue';
import { ElMessage } from 'element-plus';
import { currency } from '@/libs/utils';

interface Studios extends Studio {
    cinema: Cinema
}

interface ShowTimes extends ShowTime {
    film: Film;
    studio: Studios
}

interface Bookings extends Booking {
    show_time: ShowTimes
}

export default defineComponent({
    setup() {
        const { user } = useAuthStore()
        const page = ref(1)
        const search = ref<string>("")

        const { data, isFetching, refetch } = useQuery({
            queryKey: ['booking', 'history', user.uuid],
            queryFn: async () => await axios.post('/master/booking/history', { page: page.value, uuid: user.uuid }).then((res: any) => res.data),
            onError: (err: any) => ElMessage.error(err.response.data.message),
            onSuccess: (res: any) => {
                if (page.value > res.last_page) page.value = res.last_page
            }
        })

        const pagination = computed(() => {
            let limit = data.value?.last_page <= page.value + 1 ? 5 : 2;
            return Array.from({ length: data.value?.last_page }, (_, i) => i + 1).filter(
                (i) =>
                    i >= (page.value < 3 ? 3 : page.value) - limit && i <= (page.value < 3 ? 3 : page.value) + limit
            );
        });

        const filteredData = computed(() => {
            if (!search.value) return data.value?.data

            const query = search.value.toLowerCase()

            return data.value?.data.filter((item: Bookings) => {
                return (
                    item.show_time.studio.cinema.name.toLowerCase().includes(query) || item.show_time.film.title.toLowerCase().includes(query)
                )
            })
        })

        return {
            user,
            search,
            data, isFetching, refetch,
            filteredData,
            pagination,
            currency,
            page
        }
    },
    methods: {
        formatDate(dateString: string) {
            const dates = new Date(dateString)
            return dates.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' })
        }
    },
})
</script>
