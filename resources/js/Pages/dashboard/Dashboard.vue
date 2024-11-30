<template>
    <main>
        
    </main>
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
