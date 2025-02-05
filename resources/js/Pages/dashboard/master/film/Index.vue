<script setup lang="ts">
import { watch, ref, h } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import type { Film } from '@/types'
import { useDelete } from '@/libs/hooks';
import Form from './Form.vue'
import { useRouter } from 'vue-router';

const column = createColumnHelper<Film>()
const paginateRef = ref<any>(null)
const selected = ref<string>("")
const openForm = ref<boolean>(false)

const { delete: deleteFilm } = useDelete({
    onSuccess: () => paginateRef?.value.refetch()
})

const router = useRouter()

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
                class: 'btn btn-sm btn-warning flex items-center',
                onClick: () => router.push({name: 'master.film.review', params: { uuid: cell.getValue() }})
            }, [
                h('i', { class: 'fa-regular fa-star fs-5' }),
                h('span', { class: 'ml-2' }, 'Review')
            ]),
            h('button',
            {
                class: 'btn btn-sm btn-success flex items-center',
                onClick: () => router.push({name: 'master.film.cast', params: { uuid: cell.getValue() }})
            }, [
                h('i', { class: 'la la-users fs-3' }),
                h('span', { class: 'ml-2' }, 'Cast')
            ]),
            h('button',
            {
                class: 'btn btn-sm btn-primary flex items-center',
                onClick: () => router.push({name: 'master.film.show-time', params: { uuid_film: cell.getValue(), uuid_studio: 0 }})
            }, [
                h('i', { class: 'la la-clock fs-3' }),
                h('span', { class: 'ml-2' }, 'Showtime')
            ]),
            h('button',
                {
                    class: 'btn btn-sm bg-purple-700 hover:bg-purple-800 text-white',
                    onClick: () => {
                        selected.value = cell.getValue(),
                        openForm.value = true
                    }
                }, [
                    h('i', { class: 'la la-pencil fs-4' })
                ]
            ),
            h('button',
                {
                    class: 'btn btn-sm bg-red-700 hover:bg-red-800 text-white',
                    onClick: () => deleteFilm(`/master/film/${cell.getValue()}`)
                },[
                    h('i', { class: 'la la-trash fs-4' })
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
