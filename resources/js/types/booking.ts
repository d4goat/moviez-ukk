export interface Booking {
    id: number;
    uuid: string;
    tanggal: string;
    quantity: number;
    user_id: number;
    show_time_id: number;
    invoice_number: string;
}

export interface BookedSeat {
    id: number,
    uuid: string,
    booking_id: number,
    seat_id: number,
}