<script setup lang="ts">
import { ref, h, watch } from 'vue';
import type { Promotion } from '@/types';
import { createColumnHelper } from '@tanstack/vue-table';
import { useDelete } from '@/libs/hooks';
import Form from './Form.vue';

const column = createColumnHelper<Promotion>()
const paginateRef = ref<any>(null)
const selected = ref<string>("")
const openForm = ref<boolean>(false)

const { delete:deletePromotion } = useDelete({
    onSuccess: paginateRef.value?.refetch()
})

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('name', {
        header: 'Name'
    }),
    column.accessor('description', {
        header: 'Description'
    }),
    column.accessor('start_date', {
        header: 'Start Date'
    }),
    column.accessor('end_date', {
        header: 'End Date'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-4' }, [
            h('button', {
                class: 'btn btn-sm bg-purple-700 hover:bg-purple-800 text-white',
                onClick: () => {
                    openForm.value = true
                    selected.value = cell.getValue()
                }
            }, [
                h('i', { class: 'la la-pencil fs-2' })
            ]),
            h('button', {
                class: 'btn btn-sm bg-red-700 hover:bg-red-800 text-white',
                onClick: () => deletePromotion(`/master/promotion/${cell.getValue()}`)
            }, [
                h('i', { class: 'las la-trash fs-2' })
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
    <main class="border-b-[1px] border-body pb-3">
        <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

        <div class="w-full h-full flex flex-col rounded-xl space-y-4">
            <div class="border-b-[1px] border-body flex justify-between items-center p-4">
                <h2 class="text-xl">Promotion List</h2>
                <button type="button" @click="openForm = true" v-if="!openForm" class="btn btn-md btn-primary">
                    <i class="las la-plus"></i>
                    Add
                </button>
            </div>

            <div class="w-full h-full py-2 px-4">
                <paginate
                    ref="paginateRef"
                    url="/master/promotion"
                    id="table-promotion"
                    :columns="columns"
                ></paginate>
            </div>
        </div>
    </main>
</template>
