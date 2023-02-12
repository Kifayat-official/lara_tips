import { IUserResponse } from "../../components/user/user.response"

export interface IAuthResponse {
    status: number
    message: string
    data: { user: IUserResponse, token: string }
}

