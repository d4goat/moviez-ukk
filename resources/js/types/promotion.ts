export interface Promotion{
    id: number;
    uuid: string;
    name: string;
    description: string;
    start_date: Date;
    end_date: Date;
    code: string;
    discount: number;
}