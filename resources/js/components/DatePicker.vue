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

<style>
/* Flatpickr with Tailwind CSS */

:root {
    --flatpickr-width: 280px;
    --flatpickr-width-week-numbers: 325px;
    --flatpickr-day-height: 36px;
    --flatpickr-time-height: 46px;
  }
  
  /* Container */
  .flatpickr-calendar {
    @apply w-[var(--flatpickr-width)] border-0 rounded-none shadow-lg bg-white;
  }
  
  /* Remove arrows */
  .flatpickr-calendar:before,
  .flatpickr-calendar:after {
    @apply hidden;
  }
  
  /* Week numbers */
  .flatpickr-calendar.hasWeeks {
    @apply w-[var(--flatpickr-width-week-numbers)];
  }
  
  /* Months container */
  .flatpickr-months {
    @apply px-4 pt-2;
  }
  
  /* Inner container */
  .flatpickr-innerContainer {
    @apply p-2;
  }
  
  /* Day containers */
  .flatpickr-days,
  .dayContainer {
    @apply w-full min-w-full max-w-full;
  }
  
  /* Months */
  .flatpickr-months .flatpickr-month {
    @apply bg-transparent text-gray-600 fill-gray-600 h-[46px];
  }
  
  .flatpickr-months .flatpickr-prev-month,
  .flatpickr-months .flatpickr-next-month {
    @apply flex items-center justify-center rounded top-4;
  }
  
  .flatpickr-months .flatpickr-prev-month svg,
  .flatpickr-months .flatpickr-next-month svg {
    @apply fill-gray-500;
  }
  
  .flatpickr-months .flatpickr-prev-month:hover,
  .flatpickr-months .flatpickr-next-month:hover {
    @apply bg-gray-100;
  }
  
  .flatpickr-months .flatpickr-prev-month:hover svg,
  .flatpickr-months .flatpickr-next-month:hover svg {
    @apply fill-gray-700;
  }
  
  .flatpickr-months .flatpickr-prev-month.flatpickr-prev-month {
    @apply left-4;
  }
  
  .flatpickr-months .flatpickr-prev-month.flatpickr-next-month,
  .flatpickr-months .flatpickr-next-month.flatpickr-next-month {
    @apply right-4;
  }
  
  /* Month selector */
  .flatpickr-current-month {
    @apply font-semibold;
  }
  
  .flatpickr-current-month .numInputWrapper {
    @apply rounded w-[65px];
  }
  
  .flatpickr-current-month .numInputWrapper span.arrowUp {
    @apply rounded-tr;
  }
  
  .flatpickr-current-month .numInputWrapper span.arrowDown {
    @apply rounded-br;
  }
  
  .flatpickr-current-month .flatpickr-monthDropdown-months {
    @apply border-0 bg-white text-base text-gray-700 font-semibold py-2 px-3 mr-2 outline-none rounded appearance-none;
  }
  
  .flatpickr-current-month .flatpickr-monthDropdown-months:hover {
    @apply bg-gray-100;
  }
  
  .flatpickr-current-month .flatpickr-monthDropdown-month {
    @apply text-base text-gray-700 font-semibold bg-transparent outline-none p-0;
  }
  
  .flatpickr-current-month span.cur-month {
    @apply text-gray-700 text-base font-semibold;
  }
  
  .flatpickr-current-month span.cur-month:hover {
    @apply bg-gray-100;
  }
  
  .flatpickr-current-month input.cur-year {
    @apply text-gray-700 text-lg py-2 px-3 font-semibold outline-none;
  }
  
  /* Week days */
  span.flatpickr-weekday {
    @apply text-gray-800 text-base font-bold;
  }
  
  /* Time */
  .flatpickr-time {
    @apply rounded-b;
  }
  
  .flatpickr-calendar.hasTime .flatpickr-time {
    @apply h-[var(--flatpickr-time-height)] leading-[var(--flatpickr-time-height)] max-h-[var(--flatpickr-time-height)] border-t border-gray-100;
  }
  
  .flatpickr-time .numInputWrapper {
    @apply h-[var(--flatpickr-time-height)];
  }
  
  .flatpickr-time .flatpickr-am-pm {
    @apply text-gray-700 text-base font-semibold;
  }
  
  .flatpickr-time input.flatpickr-hour,
  .flatpickr-time input.flatpickr-minute {
    @apply text-gray-700 text-base font-semibold;
  }
  
  .flatpickr-time input:hover,
  .flatpickr-time .flatpickr-am-pm:hover,
  .flatpickr-time input:focus,
  .flatpickr-time .flatpickr-am-pm:focus {
    @apply bg-transparent;
  }
  
  /* Number input */
  .numInputWrapper span {
    @apply border-0;
  }
  
  .numInputWrapper span:hover {
    @apply bg-transparent;
  }
  
  .numInputWrapper span:after {
    @apply top-1/2 transform -translate-y-1/2;
  }
  
  .numInputWrapper span.arrowUp:after {
    @apply border-b-gray-500;
  }
  
  .numInputWrapper span.arrowUp:hover:after {
    @apply border-b-gray-700;
  }
  
  .numInputWrapper span.arrowDown:after {
    @apply border-t-gray-500;
  }
  
  .numInputWrapper span.arrowDown:hover:after {
    @apply border-t-gray-700;
  }
  
  .numInputWrapper:hover {
    @apply bg-transparent;
  }
  
  /* Day */
  .flatpickr-day {
    @apply text-base rounded shadow-none h-[var(--flatpickr-day-height)] w-full max-w-full m-0 leading-[var(--flatpickr-day-height)] text-gray-600 mt-0;
  }
  
  .flatpickr-day.inRange,
  .flatpickr-day.prevMonthDay.inRange,
  .flatpickr-day.nextMonthDay.inRange,
  .flatpickr-day.today.inRange,
  .flatpickr-day.prevMonthDay.today.inRange,
  .flatpickr-day.nextMonthDay.today.inRange,
  .flatpickr-day:hover,
  .flatpickr-day.prevMonthDay:hover,
  .flatpickr-day.nextMonthDay:hover,
  .flatpickr-day:focus,
  .flatpickr-day.prevMonthDay:focus,
  .flatpickr-day.nextMonthDay:focus {
    @apply cursor-pointer outline-none bg-gray-100 text-gray-700 border-transparent;
  }
  
  /* Today */
  .flatpickr-day.today {
    @apply bg-gray-100 text-gray-600 border-transparent;
  }
  
  .flatpickr-day.today:hover,
  .flatpickr-day.today:focus {
    @apply border-transparent bg-gray-200 text-gray-700;
  }
  
  /* Selected */
  .flatpickr-day.selected,
  .flatpickr-day.startRange,
  .flatpickr-day.endRange,
  .flatpickr-day.selected.inRange,
  .flatpickr-day.startRange.inRange,
  .flatpickr-day.endRange.inRange,
  .flatpickr-day.selected:focus,
  .flatpickr-day.startRange:focus,
  .flatpickr-day.endRange:focus,
  .flatpickr-day.selected:hover,
  .flatpickr-day.startRange:hover,
  .flatpickr-day.endRange:hover,
  .flatpickr-day.selected.prevMonthDay,
  .flatpickr-day.startRange.prevMonthDay,
  .flatpickr-day.endRange.prevMonthDay,
  .flatpickr-day.selected.nextMonthDay,
  .flatpickr-day.startRange.nextMonthDay,
  .flatpickr-day.endRange.nextMonthDay {
    @apply bg-blue-500 text-white border-transparent;
  }
  
  /* Disabled */
  .flatpickr-day.flatpickr-disabled,
  .flatpickr-day.flatpickr-disabled:hover,
  .flatpickr-day.prevMonthDay,
  .flatpickr-day.nextMonthDay,
  .flatpickr-day.notAllowed,
  .flatpickr-day.notAllowed.prevMonthDay,
  .flatpickr-day.notAllowed.nextMonthDay {
    @apply text-gray-400 bg-transparent border-transparent;
  }
  
  .flatpickr-day.flatpickr-disabled,
  .flatpickr-day.flatpickr-disabled:hover {
    @apply cursor-not-allowed text-gray-400;
  }
  
  /* Week numbers */
  .flatpickr-weekwrapper {
    @apply mr-[5px];
  }
</style>