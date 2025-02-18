<template>
    <main class="text-gray-100 pt-21 pb-10 px-4 sm:px-6 lg:px-8">
        <div class="container mx-auto max-w-2xl">
            <div ref="invoiceRef" class="bg-dropdown shadow-2xl rounded-lg overflow-hidden">
                <div class="bg-gray-850 p-6 border-b border-gray-700">
                    <h2 class="text-3xl font-bold text-center text-white">Cinema Ticket Invoice</h2>
                    <p class="text-center text-gray-400 mt-2">
                        Booking ID:
                        <span class="font-semibold text-gray-200">
                            {{ data?.invoice_number || 'Loading...' }}
                        </span>
                    </p>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-500 font-medium">Customer Name</p>
                            <p class="text-xl font-semibold text-gray-100">
                                {{ data?.user.name || 'N/A' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <p class="text-gray-500 font-medium">Purchase Date</p>
                            <p class="text-xl font-semibold text-gray-100">
                                {{ data?.tanggal || 'N/A' }}
                            </p>
                        </div>
                    </div>

                    <div class="border-t border-gray-700 pt-6">
                        <h3 class="text-2xl font-semibold text-white mb-4">Movie Details</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Movie</span>
                                <span class="text-lg font-semibold text-gray-100">
                                    {{ data?.show_time.film.title || 'Loading...' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Showtime</span>
                                <span class="text-lg font-semibold text-gray-100">
                                    {{ data?.tanggal }} {{ data?.show_time.start_time || 'N/A' }}
                                </span>
                            </div>

                            <div class="flex justify-between items-center">
                                <span class="text-gray-500 font-medium">Seats</span>
                                <div class="text-lg font-semibold text-gray-100">
                                    <template v-if="data?.booked_seats?.length">
                                        {{ data.booked_seats.map(seat => seat.seat.seat_number).join(', ') }}
                                    </template>
                                    <span v-else>No seats selected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="border-t border-gray-700 py-6">
                        <h3 class="text-2xl font-semibold text-white mb-4">Payment Details</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-medium">Ticket Price ({{ data?.quantity }} seats)</span>
                                <span class="text-lg font-semibold text-gray-100">
                                    {{ currency(data?.quantity * data?.show_time.price) }}
                                </span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500 font-semibold">Total Amount</span>
                                <span class="text-gray-100 text-lg font-semibold">{{ currency(data?.quantity * data?.show_time.price) }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-850 p-6 border-t border-gray-700 text-center">
                    <button
                        @click="() => generatePDF(data)"
                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition-colors"
                    >
                        Print Invoice
                    </button>
                </div>
                <div id="route" class="text-right mb-4 px-4">
                    <router-link
                        :to="{name: 'landing.review', params: { uuid: data?.uuid }}"
                        class="text-indigo-500 hover:text-indigo-700 transition-colors underline"
                    >
                        Review
                    </router-link>
                </div>

            </div>

            <!-- Loading Overlay -->
            <div v-if="isLoading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
                <div class="animate-spin rounded-full h-32 w-32 border-t-2 border-b-2 border-indigo-500"></div>
            </div>
        </div>
    </main>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useQuery } from '@tanstack/vue-query';
import { useRoute, useRouter } from 'vue-router';
import axios from '@/libs/axios';
import { ElMessage } from 'element-plus';
import type { ApiResponse, Booking, ShowTime, Film, BookedSeat, User, Seat } from '@/types';
import { currency } from '@/libs/utils';
import html2pdf from 'html2pdf.js';
import {jsPDF} from "jspdf"

interface Showtimes extends ShowTime {
    film: Film
}

interface BookedSeats extends BookedSeat {
    seat: Seat
}

interface Bookings extends Booking {
    booked_seats: BookedSeats[],
    show_time: Showtimes,
    user: User
}

const route = useRoute()
const invoiceRef = ref()

const { data, isLoading, error } = useQuery({
    queryKey: ['invoice', route.params.uuid],
    queryFn: async (): Promise<Bookings> => {
        const response = await axios.get<ApiResponse<Bookings>>(`/master/booking/${route.params.uuid}`)
        return response.data.data
    },
    onError: (err: any) => {
        ElMessage.error(err.response?.data?.message || 'An error occurred')
    }
})

const generateInvoice = (booking: Bookings) => {
    // Initialize PDF with A4 size
    const doc = new jsPDF();

    doc.setFillColor(18, 18, 18); // Darker background
    doc.rect(0, 0, 210, 297, 'F');

    // Calculate card dimensions (centered, slightly smaller than page width)
    const pageWidth = 210;
    const cardWidth = 180;
    const cardHeight = 200;
    const cardX = (pageWidth - cardWidth) / 2;
    const cardY = 40;

    // Draw dark card background
    doc.setFillColor(28, 28, 36);
    doc.roundedRect(cardX, cardY, cardWidth, cardHeight, 8, 8, 'F');

    // Calculate content margins
    const leftMargin = cardX + 20;
    const rightMargin = cardX + cardWidth - 20;
    const centerX = cardX + (cardWidth / 2);

    // Add title
    doc.setFontSize(24);
    doc.setTextColor(255, 255, 255);
    doc.text('Cinema Ticket Invoice', centerX, cardY + 20, { align: 'center' });

    // Add booking ID
    doc.setFontSize(12);
    doc.setTextColor(156, 163, 175);
    doc.text(`Booking ID: ${booking.invoice_number}`, centerX, cardY + 30, { align: 'center' });

    // Customer Details Section
    let currentY = cardY + 50;
    doc.setFontSize(14);

    // Left column labels
    doc.setTextColor(156, 163, 175);
    doc.text('Customer Name', leftMargin, currentY);
    doc.text('Purchase Date', leftMargin, currentY + 10);

    // Right column values
    doc.setTextColor(255, 255, 255);
    doc.text(booking.user.name, rightMargin - 60, currentY);
    doc.text(booking.tanggal, rightMargin - 60, currentY + 10);

    // Movie Details Section
    currentY += 30;
    doc.setFontSize(18);
    doc.setTextColor(255, 255, 255);
    doc.text('Movie Details', leftMargin, currentY);

    // Movie information
    currentY += 15;
    doc.setFontSize(14);
    doc.setTextColor(156, 163, 175);
    doc.text('Movie', leftMargin, currentY);
    doc.text('Showtime', leftMargin, currentY + 10);
    doc.text('Seats', leftMargin, currentY + 20);

    doc.setTextColor(255, 255, 255);
    doc.text(booking.show_time.film.title, rightMargin - 60, currentY);
    doc.text(`${booking.tanggal} - ${booking.show_time.start_time}`, rightMargin - 60, currentY + 10);
    doc.text(booking.booked_seats.map(seat => seat.seat.seat_number).join(', '), rightMargin - 60, currentY + 20);

    // Payment Details Section
    currentY += 40;
    doc.setFontSize(18);
    doc.setTextColor(255, 255, 255);
    doc.text('Payment Details', leftMargin, currentY);

    // Payment information
    currentY += 15;
    doc.setFontSize(14);
    doc.setTextColor(156, 163, 175);
    doc.text('Ticket Price (1 seats)', leftMargin, currentY);
    doc.text('Total Amount', leftMargin, currentY + 10);

    doc.setTextColor(255, 255, 255);
    doc.text(currency(booking.show_time.price), rightMargin - 60, currentY);
    doc.text(currency(booking.quantity * booking.show_time.price), rightMargin - 60, currentY + 10);

    // Add divider lines
    doc.setDrawColor(75, 85, 99);
    doc.line(leftMargin, cardY + 70, rightMargin, cardY + 70);  // After customer details
    doc.line(leftMargin, currentY - 25, rightMargin, currentY - 25); // After movie details

    return doc;
};

const generatePDF = async (data: Bookings) => {
    const invoice = generateInvoice(data)

    invoice.save(`Cinema-ticket-${data.invoice_number}.pdf`)
};

</script>
