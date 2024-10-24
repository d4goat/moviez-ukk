export interface Studio {
    id: number;
    uuid: string;
    name: string;
    cinema_id: number;
}

export interface Seat {
    id: number;
    uuid: string;
    seat_number: number;
    studio_id: number;
}