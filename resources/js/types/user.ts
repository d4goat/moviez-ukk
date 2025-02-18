export interface User {
    id: number;
    uuid: string;
    name: string;
    email: string;
    phone: string;
    photo?: string;
    password?: string,
    role_id: number;
}
