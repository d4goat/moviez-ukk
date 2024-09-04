
<template>
    <div class="">
    <!-- <date-picker :config="{
        enableTime: true, format: 'Y:m:d H:i', minDate: 'today'
    }" class="text-red-700" /> -->
    <paginate url="/admin/film" :columns="columns" ></paginate>
    </div>
</template>

<script>
import { h, ref } from 'vue';
import { createColumnHelper } from '@tanstack/vue-table';

const column = createColumnHelper()

const columns = [
    column.accessor('title', {
        header: 'title',
    })
]
</script>
