<template>
    <flat-pickr
        v-bind="$props"
        :class="`bg-transparent ${$props.class}`"
        style="border-color: transparent !important;"
    />
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import flatPickr from 'vue-flatpickr-component'
import 'flatpickr/dist/flatpickr.css'

export default defineComponent({
    components: {
        flatPickr
    },

    props: {
        class: {
            type: String,
            default: "",
        }
    },
    setup(){}
})
</script>