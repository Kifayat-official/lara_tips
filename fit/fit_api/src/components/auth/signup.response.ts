import { User } from "../../database/entities/user.entity"

export interface ISignupResponse {
    status: number
    message: string
    data: { createdUser: User, token: string }
}