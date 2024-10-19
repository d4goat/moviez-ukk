<script setup lang="ts">
import { ref, h, watch } from 'vue';
import { Genre } from '@/types';
import { createColumnHelper } from '@tanstack/vue-table';
import { useDelete } from '@/libs/hooks';
import Form from './Form.vue'

const column = createColumnHelper<Genre>()
const paginateRef = ref<any>(null)
const selected = ref<string>("")
const openForm = ref<boolean>(false)

const { delete: deleteGenre } = useDelete({
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
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell : any) => h('div', { class: 'flex gap-4' }, [
            h('button', 
            {
                class: 'btn btn-sm btn-info',
                onClick: () => {
                    openForm.value = true,
                    selected.value = cell.getValue()
                }
            }, [
                h('i', { class: 'la la-pencil fs-2' })
            ]),
            h('button', 
            {
                class: 'btn btn-sm btn-danger',
                onClick: () => {
                    deleteGenre(`/master/genre/${cell.getValue()}`)
                }
            }, [
                h('i', { class: 'las la-trash fs-2' })
            ])
        ]) 
    })
]

const refresh = () => paginateRef.value?.refetch()

watch(openForm, (val: any) => {
    if(!val){
        selected.value = ''
    }
    window.scrollTo(0, 0)
})
</script>

<template>
    <main class="border-b-[1px] border-body pb-3">
        <Form class="mb-4" :selected="selected" v-if="openForm" @close="openForm = false" @refresh="refresh" />

        <div class="w-full h-full flex flex-col rounded-lg space-y-4">
            <div class="border-b-[1px] border-body flex justify-between items-center p-4">
                <h2 class="text-xl">Genre List</h2>
                <button type="button" @click="openForm = true" class="btn btn-md btn-primary">
                    <i class="las la-plus"></i>
                    Add
                </button>
            </div>
            <div class="w-full h-full py-2">
                <paginate
                    ref="paginateRef"
                    url="/master/genre"
                    id="table-genre"
                    :columns="columns"
                >
                </paginate>
            </div>
        </div>
    </main>
</template>