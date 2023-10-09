import { User } from "../../database/entities/user.entity"
import * as jwt from "jsonwebtoken"
import { IUserResponsePayload } from "../../components/user/user.response"

export class Jwt {

    static readonly SECRET_KEY: string = "pitc"
    static readonly EXPIRES_IN: string = "24h"

    // Generating JWT
    public static async generateJwt(UserResponse: IUserResponsePayload) {
        return jwt.sign(UserResponse, Jwt.SECRET_KEY, { expiresIn: Jwt.EXPIRES_IN })
    }

    // Verifying JWT
    public static async verifyJwt(token: string) {
        return jwt.verify(token, Jwt.SECRET_KEY)
    }

}