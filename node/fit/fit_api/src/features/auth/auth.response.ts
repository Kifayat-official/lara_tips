export interface IAuthResponse {
    status: number
    message: string
    data: { result: any, token: string }
}

