<script setup lang="ts">
import { ref, h, watch } from 'vue';
import { useDelete } from '@/libs/hooks';
import Form from './Form.vue';
import { createColumnHelper } from '@tanstack/vue-table';
import type { User } from '@/types';

const column = createColumnHelper<User>()
const paginateRef = ref<any>(null)
const selected = ref<string>('')
const openForm = ref<boolean>(false)

const { delete: deleteUser } = useDelete({
    onSuccess: () => paginateRef.value.refetch(),
});

const columns = [
    column.accessor('no', {
        header: 'No'
    }),
    column.accessor('name', {
        header: 'Name'
    }),
    column.accessor('uuid', {
        header: 'Action',
        cell: (cell: any) =>
            h("div", { class: "d-flex gap-2" }, [
                h(
                    "button",
                    {
                        class: "btn btn-sm bg-purple-700 hover:bg-purple-800 text-white",
                        onClick: () => {
                            selected.value = cell.getValue();
                            openForm.value = true;
                        },
                    },
                    h("i", { class: "la la-pencil fs-2" })
                ),
                h(
                    "button",
                    {
                        class: "btn btn-sm btn-icon bg-red-700 hover:bg-red-800 text-white",
                        onClick: () =>
                            deleteUser(`/master/users/${cell.getValue()}`),
                    },
                    h("i", { class: "la la-trash fs-2" })
                ),
            ]),
    })
]

const refresh = () => paginateRef.value.refetch();

watch(openForm, (val) => {
    if(!val){
        selected.value = ''
    }
    window.scrollTo(0, 0);
})
</script>
<template>
    <div>
        <Form
        :selected="selected"
        @close="openForm = false"
        v-if="openForm"
        @refresh="refresh"
        />

        <div class="w-full h-full flex-col rounded-lg space-y-4">
            <div class="border-b-[1px] border-body flex justify-between items-center p-4">
                <h2>Users List</h2>
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
                    id="table-user"
                    url="/master/users"
                    :columns="columns"
                ></paginate>
            </div>
        </div>
    </div>
</template>
