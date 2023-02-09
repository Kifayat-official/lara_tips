export interface UserEntityRequestPayload {
    id: number
    username: string
    password: string
    firstName: string
    lastName: string
    createdAt: Date
    updatedAt: Date
}

export interface LoginUserRequestPayload {
    username: string
    password: string
}