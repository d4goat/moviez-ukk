<template>
    <main class="w-full">
        <div class="card-header border-b pb-3 flex justify-between border-gray-700">
          <span class="font-medium">History Booking</span>
          <el-input v-model="search" placeholder="Oppenheimer, The Marvels, etc.." style="width: 240px;" />
        </div>
        <div class="card-body flex flex-col space-y-6 my-3">
          <div
            v-for="history in filteredData"
            :key="history.uuid"
            class="bg-dropdown shadow-md shadow-cyan-500/20 p-3 rounded-lg"
          >
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
              <router-link :to="{name: 'landing.invoice', params: { uuid: history.uuid }}" class="flex justify-between items-center">
                <span>Detail</span>
                <i class="fa-solid fa-chevron-right"></i>
              </router-link>
            </div>
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

interface Studios extends Studio{
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

        const { data, isLoading, refetch } = useQuery({
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
            data, isLoading, refetch,
            filteredData,
            pagination,
            currency
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