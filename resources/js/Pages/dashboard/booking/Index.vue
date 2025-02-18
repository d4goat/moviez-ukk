<script setup lang="ts">
import { ref, h } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import { useQuery } from '@tanstack/vue-query';
import type { Booking, User, ShowTime, Film, Payment } from '@/types';
import { useDelete } from '@/libs/hooks';
import { useDownloadExcel } from '@/libs/hooks';
import { currency } from '@/libs/utils';

const { download } = useDownloadExcel()

interface ShowTimes extends ShowTime {
    film: Film
}

interface Bookings extends Booking {
    no: number
    user: User,
    payments: Payment,
    show_time: ShowTimes
}

const column = createColumnHelper<Bookings>()
const paginateRef = ref<any>(null)

const { delete: deleteBooking } = useDelete({
    onSuccess: paginateRef.value?.refetch()
})

const tahun = ref(new Date().getFullYear())
const tahuns = ref<Array<Number>>([])
for (let i = new Date().getFullYear(); i >= new Date().getFullYear() - 2; i--) {
    tahuns.value.push(i)
}

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('user.name', {
        header: 'User'
    }),
    column.accessor('tanggal', {
        header: 'Date'
    }),
    column.accessor('quantity', {
        header: 'Quantity'
    }),
    column.accessor('total_price', {
        header: 'Total Price',
        cell: (cell: any) => currency(cell.getValue())
    }),
    column.accessor('show_time.film.title', {
        header: 'Film'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-4' }, [
            h('button', {
                class: 'btn btn-md bg-red-700 hover:bg-red-800 text-white',
                onClick: () => deleteBooking(`/master/booking/${cell.getValue()}`)
            }, [
                h('i', { class: 'la la-trash fs-2' })
            ])
        ])
    })
]

</script>

<template>
    <main class="border-b border-body pb-3">
        <div class="w-full h-full flex flex-col rounded-lg space-y-4">
            <!-- Title -->
            <div class="border-b border-body flex justify-between items-center p-4">
                <h2 class="text-xl">Booking List</h2>
                <div class="flex gap-3">
                    <Select :options="tahuns" v-model="tahun" style="--p-select-background: #222222"></Select>
                    <button @click="download(`/master/booking/report?tahun=${tahun}`)" class="bg-green-600 p-2.5 rounded-md flex items-center gap-2">
                        <span class="font-medium">Report</span> <i class="fa-regular fa-file-excel text-lg"></i>
                    </button>
                </div>
            </div>
            <!-- Body -->
             <div class="py-2 px-4">
                <paginate
                    ref="paginateRef"
                    url="/master/booking"
                    id="table-booking"
                    :columns="columns"
                    :payload="{ tahun: tahun }"
                ></paginate>
             </div>
        </div>
    </main>
</template>
