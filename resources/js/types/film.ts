export interface Film {
    id: number;
    uuid: string;
    title: string;
    description: string;
    duration: number;
    producer: string;
    director: string;
    writer: string;
    poster?: string;
    trailer?: string;
    release_date?: Date;
}

export interface FilmCast{
    id: number;
    uuid: string;
    cast_name: string;
    film_id: number;
}