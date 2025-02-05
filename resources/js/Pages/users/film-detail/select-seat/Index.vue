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
              'bg-gray-400 cursor-not-allowed': !isSelected(seat) && !canSelectMore,
              'bg-red-700': isBooked(seat)
            }
          ]" @click="!isBooked(seat) && toggleSeat(seat)">
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
            <div class="w-3 h-3 bg-yellow-500 rounded-sm"></div>
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
          <div>{{ currency(booking?.total_price) }}</div>
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
import { computed, onMounted, ref } from 'vue';
import { useMutation, useQuery } from '@tanstack/vue-query';
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import { Seat } from '@/types';
import { toast } from 'vue3-toastify';
import { ElMessage } from 'element-plus';
import { TransitionRoot, TransitionChild } from '@headlessui/vue';
import { currency } from '@/libs/utils';
import Swal from 'sweetalert2';

const route = useRoute();
const router = useRouter();
const selected = ref<Seat[]>([]);
const bookedSeatUuid = ref<string[]>([])

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

const { data: booked_seat, isLoading: isLoadingBookedSeat } = useQuery({
  queryKey: ['booked_seat', route.params.uuid],
  queryFn: async () => await axios.post(`/master/booked-seat/show-by-booking`, { uuid: route.query.uuid_showtime }).then((res: any) => res.data.data),
  onSuccess: (res: any) => {
    const bookedSeats: string[] = [];
    res.bookings.forEach((booking: any) => {
      booking.booked_seats.forEach((bookedSeat: any) => {
        bookedSeats.push(bookedSeat.seat.uuid);
      });
    });
    bookedSeatUuid.value = bookedSeats;
  }
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

/**
 * Converts a number to its corresponding uppercase alphabet letter
 * @example numberToAlphabet(1) => 'A'
 * @example numberToAlphabet(26) => 'Z'
 * @param {number} num
 * @returns {string}
 */
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

const isBooked = (seat: Seat) => {
  return bookedSeatUuid.value.includes(seat.uuid);
}

const mySwal = Swal.mixin(
        {
            customClass: {
                confirmButton: "btn bg-red-600 hover:bg-red-700 btn-md py-2 ml-3",
                cancelButton: "btn btn-secondary btn-md py-2 mr-3",
            },
            buttonsStyling: false,
        },
    );

const { mutate: booked, isLoading: isLoadingBookingSeat, isSuccess } = useMutation({
  mutationKey: ['booking-seat'],
  mutationFn: async () => {
    const seatIds = selected.value.map(seat => seat.id);

    const data = new FormData()

    data.append('booking_id', booking.value.id)
    data.append('amount', booking.value.total_price)
    data.append('status', 'pending')

    const response = await axios.post('/master/payment/store', data).then((res: any) => res.data.data)

    return await axios.post('/master/booked-seat/store', {
      booking_id: booking.value.id,
      seat_id: seatIds,
      uuid: response.uuid
    }).then((res: any) => res.data)
  },
  onError: (err: any) => ElMessage.error(err.response.data.message),
  onSuccess: async (res: any) => {
    ElMessage.success('Successfully select seat')

    window.snap.pay(res.token, {
      onSuccess: () => {
        axios.post(`master/payment/${res.uuid}/update-status`, { status: 'success' }).then((res: any) => res.data.data)
        router.push({ name: 'landing.invoice', params: res.data.uuid })
      },
      onError: (err: any) => {
        axios.post(`master/payment/${res.uuid}/update-status`, { status: 'failed' }).then((res: any) => res.data.data)
        console.error(err.response.data.message)
      },
      onClose: () => {
        axios.post(`master/payment/${res.uuid}/update-status`, { status: 'failed' }).then((res: any) => res.data.data)
      },
      onPending: () => {
        Swal.fire({
          title: "Are you sure to cancel the payment",
          text: "Canceled payment cannot be returned!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Yes, Cancel",
          reverseButtons: true,
        }).then((result: any) => {
          if(result.isConfirmed){
            axios.post(`master/payment/${res.uuid}/update-status`, { status: 'failed' }).then((res: any) => res.data.data).catch((err: any) => Swal.showValidationMessage(err.response.data.message))
          }
        })
      }
    })
  }
})

/**
 * This computed property takes the array of seats and groups them by their first letter (A, B, C, etc.)
 * The result is an array of arrays, where each sub-array is a group of seats that start with the same letter.
 * For example, if the input is [{seat_number: 'A1'}, {seat_number: 'A2'}, {seat_number: 'B1'}],
 * the output will be [[{seat_number: 'A1'}, {seat_number: 'A2'}], [{seat_number: 'B1'}]]
 */
const filteredSeats = computed(() => {
  const seatGroups: { [key: string]: Seat[] } = {};

  data.value?.forEach((seat: Seat) => {
    // Get the first letter of the seat number
    const group = seat.seat_number.charAt(0);
    // If the group doesn't exist yet, create it
    if (!seatGroups[group]) {
      seatGroups[group] = [];
    }
    // Add the seat to its group
    seatGroups[group].push(seat);
  });

  // Return an array of the groups
  return Object.values(seatGroups);
});

onMounted(async () => {
  let recaptchaScript = document.createElement('script')
  recaptchaScript.setAttribute(
    "src",
    "https://app.sandbox.midtrans.com/snap/snap.js"
  )
  recaptchaScript.setAttribute(
    "data-client-key",
    "SB-Mid-client-jbGm4juhRnPp_wt1"
  );
  document.head.appendChild(recaptchaScript)
})
</script>
