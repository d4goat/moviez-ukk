<script setup lang="ts">
import { ref, h, watch, onMounted } from 'vue';
import { ShowTime } from '@/types';
import { createColumnHelper } from '@tanstack/vue-table';
import { useDelete } from '@/libs/hooks';
import Form from './Form.vue'
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import { useQuery } from '@tanstack/vue-query';

const column = createColumnHelper<ShowTime>()

const paginateRef = ref<any>(null)
const selected = ref<string>("")
const openForm = ref<boolean>(false)

const route = useRoute()
const router = useRouter()

const { data, refetch } = useQuery({
    queryKey: ['films'],
    queryFn: async () => await axios.get(`/master/film/${route.params.uuid}`).then((res: any) => res.data.data),
})

const { delete: deleteShowTime } = useDelete({
    onSuccess: () => paginateRef?.value.refetch()
})

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('film.title', {
        header: 'Film'
    }),
    column.accessor('studio', {
        header: 'Studio',
        cell: (cell:  any) => h('div', { class: 'flex gap-2' },
            [
                h('span', { class: 'text-sm' }, cell.getValue().name),
                h('span', { class: 'text-sm' }, ' - '),
                h('span', { class: 'text-sm' }, cell.getValue().cinema.name)
            ]
        )
    }),
    column.accessor('start_time', {
        header: 'Start Time'
    }),
    column.accessor('end_time', {
        header: 'End Time'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) => h('div', { class: 'flex gap-4' }, [
            h('button', {
                class: 'btn btn-sm btn-info',
                onClick: () => {
                    selected.value = cell.getValue()
                    openForm.value = true
                }
            }, [
                h('i', { class: 'la la-pencil fs-2' })
            ]),
            h('button', {
                class: 'btn btn-sm btn-danger',
                onClick: () => deleteShowTime(`/master/show-time/${cell.getValue()}`)
            }, [
                h('i', { class: 'las la-trash fs-2' })
            ])
        ])
    })
]

const refresh = () => paginateRef.value?.refetch()

watch(openForm, () => {
    if (!openForm.value) {
        selected.value = ""
    }
    window.scrollTo(0, 0)
})

onMounted(() => refetch())
</script>

<template>
    <main class="border-b-[1px] border-body pb-3">
        <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

        <div class="w-full h-full flex flex-col rounded-xl space-y-4">
            <div class="border-b-[1px] border-body flex justify-between items-center p-4">
                <div class="flex items-center gap-3">
                    <button type="button" class="btn btn-sm btn-icon hover:text-blue-700 hover:bg-slate-900 text-bodydark bg-slate-800"
                        @click="router.push({ name: 'master.film' })"
                    >
                        <i class="la la-arrow-left"></i>
                    </button>
                    <h2 class="text-xl">{{ data?.title }} Show Time List</h2>
                </div>
                <button type="button" @click="openForm = true" v-if="!openForm" class="btn btn-md btn-primary">
                    <i class="las la-plus"></i>
                    Add
                </button>
            </div>

            <div class="w-full h-full py-2 px-4">
                <paginate
                    ref="paginateRef"
                    url="/master/show-time"
                    id="table-show-time"
                    :payload="{uuid_film: $route.params.uuid_film, uuid_studio: $route.params.uuid_studio}"
                    :columns="columns"></paginate>
            </div>
        </div>
    </main>
</template>