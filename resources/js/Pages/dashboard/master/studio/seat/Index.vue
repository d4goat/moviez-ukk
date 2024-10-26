<script setup lang="ts">
import { ref, watch, h, onMounted } from 'vue';
import { useDelete } from '@/libs/hooks';
import { createColumnHelper } from '@tanstack/vue-table';
import { Seat } from '@/types';
import { useRoute } from 'vue-router';
import Form from './Form.vue'
import { useQuery } from '@tanstack/vue-query';
import { useRouter } from 'vue-router';
import axios from '@/libs/axios';
const column = createColumnHelper<Seat>()

const paginateRef = ref<any>(null)
const selected = ref<string>('')
const openForm = ref<boolean>(false)
const route = useRoute()
const router = useRouter()

const { delete: deleteSeat } = useDelete({
    onSuccess: () => paginateRef?.value.refetch()
})

const { data, isLoading, refetch } = useQuery({
    queryKey: ['stuido'],
    queryFn: async () => axios.get(`/master/studio/${route.params.uuid}`).then((res: any) => res.data.data),
})

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('seat_number', {
        header: 'Seat Number'
    }),
    column.accessor('studio.name', {
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
                h('i', { class: 'la la-trash fs-2' })
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

onMounted(() => refetch())
</script>

<template>
    <main class="border-b border-body pb-3">
        <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />
        <div class="w-full h-full flex flex-col rounded-xl space-y-4">
            <div class="border-b border-body flex justify-between items-center p-4">
                <div class="flex items-center gap-3">
                    <button type="button" @click="router.push({name: 'master.studio'})" class="btn btn-sm btn-icon hover:text-blue-700 hover:bg-slate-900 text-bodydark bg-slate-800">
                        <i class="la la-arrow-left"></i>
                    </button>
                    <h2 class="text-xl"> {{ data?.name }} Seat List </h2>
                </div>
                <button type="button" @click="openForm = true" v-if="!openForm" class="btn btn-md btn-primary"><i class="las la-plus"></i>Add</button>
            </div>

            <div class="w-full h-full py-2 px-4">
                <paginate
                    ref="paginateRef"
                    url="/master/seat"
                    id="table-seat"
                    :payload="{uuid_studio: $route.params.uuid}"
                    :columns="columns"
                ></paginate>
            </div>
        </div>
    </main>
</template>