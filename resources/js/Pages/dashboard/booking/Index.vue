<script setup lang="ts">
import { ref, h } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import { useQuery } from '@tanstack/vue-query';
import { Booking } from '@/types';
import { useDelete } from '@/libs/hooks';

const column = createColumnHelper<Booking>()
const paginateRef = ref<any>(null)

const { delete: deleteBooking } = useDelete({
    onSuccess: paginateRef.value?.refetch()
})

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
    column.accessor('payment.amount', {
        header: 'Total Price'
    }),
    column.accessor('show_time.film.title', {
        header: 'Film'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-4' }, [
            h('button', {
                class: 'btn btn-md btn-danger',
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
            <div class="border-b border-body p-4">
                <h2 class="text-xl">Booking List</h2>
            </div>
            <!-- Body -->
             <div class="py-2 px-4">
                <paginate
                    ref="paginateRef"
                    url="/master/booking"
                    id="table-booking"
                    :columns="columns"
                ></paginate>
             </div>
        </div>
    </main>
</template>