<script setup lang="ts">
import { watch, ref, h } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import type { Film } from '@/types'
import { useDelete } from '@/libs/hooks';
import Form from './Form.vue'

const column = createColumnHelper<Film>()
const paginateRef = ref<any>(null)
const selected = ref<string>("")
const openForm = ref<boolean>(false)

const { delete: deleteFilm } = useDelete({
    onSuccess: () => paginateRef?.value.refetch()
})

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('title', {
        header: 'Title'
    }),
    column.accessor('description', {
        header: 'Description'
    }),
    column.accessor('duration', {
        header: 'Duration',
        cell: (cell: any) => h('div', [cell.getValue() + ' Minute']),
    }),
    column.accessor('producer', {
        header: 'Producer'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-2' }, [
            h('button', 
                {
                    class: 'btn btn-sm btn-info',
                    onClick: () => {
                        selected.value = cell.getValue(),
                        openForm.value = true
                    }
                }, [
                    h('i', { class: 'la la-pencil fs-3' })
                ]
            ),
            h('button', 
                {
                    class: 'btn btn-sm btn-danger',
                    onClick: () => deleteFilm(`/master/film/${cell.getValue()}`)
                },[
                    h('i', { class: 'la la-trash fs-3' })   
                ]
            )
        ])
    })
]

const refresh = () => paginateRef.value.refetch()

watch(openForm, (val: any) => {
    if(!val){
        selected.value = ''
    }
    window.scrollTo(0, 0);
})
</script>

<template>
    <div class="border-b-[1px] border-body pb-3">
        <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

        <div class="w-full h-full flex-col rounded-lg space-y-4"> 
            <div class="border-b-[1px] border-body flex justify-between items-center p-4">
                <h2 class="text-xl">Films List</h2>
                <button 
                    type="button" 
                    class="bg-blue-600 text-bodydark1 py-2 px-4 rounded hover:bg-blue-700"
                    v-if="!openForm"
                    @click="openForm = true"    
                >
                Add
                <i class="fa-solid fa-plus"></i>
                </button>
            </div>   
            <div class="w-full h-full py-2 px-4">
                <paginate 
                    ref="paginateRef"
                    id="table-films"
                    url="/master/film"
                    :columns="columns"
                ></paginate>
            </div>
        </div>
    </div>
</template>