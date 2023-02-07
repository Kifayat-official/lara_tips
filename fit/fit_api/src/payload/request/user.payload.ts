export interface UserEntityRequestPayload {
    email: string
    password: string
    firstName: string
    lastName: string
    createdAt: Date
    updatedAt: Date
}

export interface LoginUserRequestPayload {
    email: string
    password: string
}