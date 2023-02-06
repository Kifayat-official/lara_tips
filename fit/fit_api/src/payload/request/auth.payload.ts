export interface RegisterUserRequestPayload {
    id: number
    email: string
    password: string
    firstName: string
    lastName: string
}

export interface LoginUserRequestPayload {
    email: string
    password: string
}