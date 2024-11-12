import { Studio } from "./studio"

export interface ShowTime {
    id: number
    uuid: string
    film_id: number
    studio_id: number
    start_time: string
    end_time: string;
    studio?: Studio;
}