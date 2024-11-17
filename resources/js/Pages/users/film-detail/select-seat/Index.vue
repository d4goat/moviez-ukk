<template>
  <div class="pt-21 font-medium">
    <div class="flex justify-center">
      <div class="w-1/2 border-y border-zinc-700 py-3 text-2xl text-center">
        Screen
      </div>
    </div>
    <div class="mt-4 mx-14 flex flex-col gap-4">
      <div v-for="(seatGroup, groupName) in filteredSeats" :key="groupName"
        class="flex justify-center items-center gap-3">
        <div class="text-lg font-medium mb-2">{{ numberToAlphabet(groupName) }}</div>
        <div class="flex flex-wrap gap-3">
          <div v-for="seat in seatGroup" :key="seat.uuid" :class="[
            'rounded-xl h-8 w-8 cursor-pointer',
            {
              'bg-orange-500': isSelected(seat),
              'bg-gray-200': !isSelected(seat) && canSelectMore,
              'bg-gray-400 cursor-not-allowed': !isSelected(seat) && !canSelectMore
            }
          ]" @click="toggleSeat(seat)">
          </div>
        </div>
      </div>
      <div class="flex flex-col items-center">
        <div class="flex space-x-3">
          <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-white rounded-sm"></div>
            <span>Available</span>
          </div>
          <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-orange-500 rounded-sm"></div>
            <span>Selected</span>
          </div>
          <div class="flex items-center space-x-2">
            <div class="w-3 h-3 bg-red-700 rounded-sm"></div>
            <span>Booked</span>
          </div>
        </div>
        <div class="flex flex-col items-center gap-2">
          <div class="text-sm text-gray-600">
            Remaining seats: {{ remainingSeats }}
          </div>
          <div class="flex">
            <span>Chosen seats: </span>
            <span v-for="seat in selected" :key="seat.uuid" class="ml-2">
              {{ seat.seat_number }}
            </span>
          </div>
        </div>
        <button type="button" :disabled="selected.length == 0" @click="booked"
          class="bg-gray-600 rounded-lg mt-3 w-1/3 py-1 grid grid-cols-2 divide-x">
          <div>{{ currency(payment.amount) }}</div>
          <div>Continue</div>
        </button>
      </div>
    </div>
    <TransitionRoot appear :show="isLoadingBookingSeat" as="template">
      <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0"
      enter-to="opacity-100" leave="duration-200 ease-in" leave-from="opacity-100"
      leave-to="opacity-0">

      <div class="fixed flex items-center justify-center inset-0 bg-[#171717a2] z-99999">
          <svg class="animate-spin h-12 w-12 mx-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <path class="opacity-75" fill="cyan" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
          </svg>
      </div>
      </TransitionChild>
  </TransitionRoot>
  </div>
</template>

<script setup lang="ts">
import { computed, ref } from 'vue';
import { useMutation, useQuery } from '@tanstack/vue-query';
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import { Seat } from '@/types';
import { toast } from 'vue3-toastify';
import { ElMessage } from 'element-plus';
import { TransitionRoot, TransitionChild } from '@headlessui/vue';
import { currency } from '@/libs/utils';

const route = useRoute();
const router = useRouter();
const selected = ref<Seat[]>([]);

const { data, refetch, isLoading } = useQuery({
  queryKey: ['seat', route.params.uuid, route.query.uuid_studio],
  queryFn: async () =>
    (
      await axios.get(`/master/seat/by-studio?uuid_studio=${route.query.uuid_studio}`)
    ).data.data,
  onError: (err: any) => {
    toast.error(err.response.data.message);
    console.log(err.response.data.message);
  },
  cacheTime: 0,
});

const { data: booking, isLoading: isLoadingBooking } = useQuery({
  queryKey: ['booking', route.params.uuid],
  queryFn: async () => await axios.get(`/master/booking/${route.params.uuid}`).then((res: any) => res.data.data)
});

const { data: payment, isLoading: isLoadingPayment } = useQuery({
  queryKey: ['payment', route.query.uuid_payment],
  queryFn: async () => await axios.get(`/master/payment/${route.query.uuid_payment}`).then((res: any) => res.data.data)
})

// Computed property for remaining seats
const remainingSeats = computed(() => {
  if (!booking.value?.quantity) return 0;
  return booking.value.quantity - selected.value.length;
});

// Computed property to check if more seats can be selected
const canSelectMore = computed(() => {
  if (!booking.value?.quantity) return false;
  return selected.value.length < booking.value.quantity;
});

const isSelected = (seat: Seat) => selected.value.some(s => s.uuid === seat.uuid);

const numberToAlphabet = (num: number): string => {
  return String.fromCharCode(65 + Number(num));
};

const toggleSeat = (seat: Seat) => {
  if (isSelected(seat)) {
    // Always allow deselecting
    selected.value = selected.value.filter(s => s.uuid !== seat.uuid);
  } else if (canSelectMore.value) {
    // Only allow selecting if under the quantity limit
    selected.value.push(seat);
  } else {
    ElMessage.error(`Maximum ${booking.value.quantity} seats can be selected`);
  }
};

const { mutate: booked, isLoading: isLoadingBookingSeat, isSuccess } = useMutation({
  mutationKey: ['booking-seat'],
  mutationFn: async () => {
    const seatIds = selected.value.map(seat => seat.id);

    return await axios.post('/master/booked-seat/store', {
      booking_id: booking.value.id,
      seat_id: seatIds
    }).then((res: any) => res.data.data)
  },
  onError: (err: any) => ElMessage.error(err.response.data.message),
  onSuccess: (res: any) => {
    ElMessage.success('Successfully select seat')
    router.push({ name: 'landing.page' })
  }
})

const filteredSeats = computed(() => {
  const seatGroups: { [key: string]: Seat[] } = {};

  data.value?.forEach((seat: Seat) => {
    const group = seat.seat_number.charAt(0);
    if (!seatGroups[group]) {
      seatGroups[group] = [];
    }
    seatGroups[group].push(seat);
  });

  return Object.values(seatGroups);
});
</script>