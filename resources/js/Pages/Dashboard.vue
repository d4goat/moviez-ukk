
<template>
    <div class="text-white bg-[#0f1014]">
        <div class="bg-[#14171c] rounded-lg">
            <div class="flex items-center justify-between mb-4 border-b-[1px] p-4">
                <h2 class="text-xl font-semibold">Article List</h2>
                <button
                type="button"
                class="btn btn-sm bg-blue-500 text-white py-2 px-4 rounded hover:bg-blue-600"
            >
                Add
                <i class="la la-plus ml-2"></i>
            </button>
        </div>
        <div class="py-2 px-4">
            <paginate
            ref="paginateRef"
            id="table-article"
            url="/admin/film"
            :columns="columns"
            ></paginate>
        </div>
    </div>
    </div>
</template>

<script setup lang="ts">
import { h, ref } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';

const column = createColumnHelper()

const columns = [
    column.accessor('no', {
        header: 'No',
    }),
    column.accessor('title', {
        header: 'title',
    }),
    column.accessor('description', {
        header: 'Sinopsis',
    }),
    column.accessor('uuid', {
        header: 'UUID',
    })
]
</script>
