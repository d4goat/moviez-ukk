
<template>
    <div class="">
    <!-- <date-picker :config="{
        enableTime: true, format: 'Y:m:d H:i', minDate: 'today'
    }" class="text-red-700" /> -->
    <paginate url="/admin/film" :columns="columns" id="table-film"></paginate>
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
]
</script>
