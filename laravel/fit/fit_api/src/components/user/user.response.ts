export interface IUserResponsePayload {
    id: number
    username: string
    first_name: string | undefined
    last_name: string | undefined
}

export interface IUserEndPointResponse {
    status: number
    message: string
    data: { result: any }
}