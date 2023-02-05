export interface RegisterRequestPayload {
    id: number
    email: string
    password: string
    firstName: string
    lastName: string
}

export interface LoginRequestPayload {
    email: string
    password: string
}