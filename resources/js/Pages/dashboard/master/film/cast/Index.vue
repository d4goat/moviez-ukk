<script setup lang="ts">
import { ref, h, watch } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';
import type { FilmCast } from '@/types';
import Form from './Form.vue';
import { useDelete } from '@/libs/hooks';
import { useRoute } from 'vue-router';

const column = createColumnHelper<FilmCast>()
const paginateRef = ref<any>(null)
const selected = ref<string>("")
const openForm = ref<boolean>(false)
const route = useRoute()

const { delete: deleteCast } = useDelete({
    onSuccess: paginateRef.value?.refetch()
})

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('cast_name', {
        header: 'Name'
    }),
    column.accessor('films.name', {
        header: 'Role'
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
                onClick: () => deleteCast(`/master/film/cast/${cell.getValue()}`)
            }, [
                h('i', { class: 'las la-trash fs-2' })
            ])
        ])
    })
]

const refresh = () => paginateRef.value.refetch()

watch(openForm, () => {
    if (!openForm.value) {
        selected.value = ""
    }
    window.scrollTo(0, 0)
})
</script>

<template>
    <main class="border-b-[1px] border-body pb-3">
        <Form :selected="selected" @close="openForm = false" v-if="openForm" @refresh="refresh" />

        <div class="w-full h-full flex flex-col rounded-xl space-y-4">
            <div class="border-b-[1px] border-body flex justify-between items-center p-4">
                <h2 class="text-xl">Cast List</h2>
                <button type="button" @click="openForm = true" class="btn btn-md btn-primary">
                    <i class="las la-plus"></i>
                    Add
                </button>
            </div>

            <div class="w-full h-full py-2 px-4">
                <paginate
                    ref="paginateRef"
                    url="/master/film-cast"
                    id="table-cast"
                    :columns="columns"
                    :payload="{uuid: route.params.uuid}"
                >
                </paginate>
            </div>
        </div>
    </main>
</template>