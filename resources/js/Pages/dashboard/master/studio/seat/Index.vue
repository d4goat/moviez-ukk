<script setup lang="ts">
import { ref, watch, h } from 'vue';
import { useDelete } from '@/libs/hooks';
import { createColumnHelper } from '@tanstack/vue-table';
import { Seat } from '@/types';
import { useRoute } from 'vue-router';
import Form from './Form.vue'
const column = createColumnHelper<Seat>()

const paginateRef = ref<any>(null)
const selected = ref<string>('')
const openForm = ref<boolean>(false)
const route = useRoute()

const { delete: deleteSeat } = useDelete({
    onSuccess: () => paginateRef?.value.refetch()
})

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('seat_number', {
        header: 'Seat Number'
    }),
    column.accessor('studio', {
        header: 'Studio'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-4' }, [
            h('button', 
            {
                 class: 'btn btn-md btn-info',
                 onClick: () => {
                    selected.value = cell.getValue()
                    openForm.value = true
                 } 
            }, [
                h('i', { class: 'la la-pencil fs-2' })
            ]),
            h('button', 
            {
                class: 'btn btn-md btn-danger',
                onClick: () => deleteSeat(`/master/seat/${cell.getValue()}`)
            }, [
                h('i', { class: 'la la=trash fs-2' })
            ])
        ])
    })
]

const refresh = () => paginateRef.value.refetch()

watch(openForm, (val: any) => {
    if(!val){
        selected.value = ''
    }
    window.scrollTo(0, 0)
})
</script>

<template>
    <main>
        <Form />
    </main>
</template>