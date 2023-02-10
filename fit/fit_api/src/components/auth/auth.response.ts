import { IUserEntityResponse } from "../user/user.response"

export interface IAuthResponse {
    status: number
    message: string
    data: { user: IUserEntityResponse, token: string }
}

