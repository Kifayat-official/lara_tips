import { User } from "../database/entities/user.entity"
import * as jwt from "jsonwebtoken"

export class Jwt {

    static readonly SECRET_KEY: string = "pitc"
    static readonly EXPIRES_IN: string = "24h"

    // Generating JWT
    public static async generateJwt(createdUser: User) {
        return jwt.sign(createdUser, Jwt.SECRET_KEY, { expiresIn: Jwt.EXPIRES_IN })
    }

    // Verifying JWT
    private static async verifyJwt() {

    }

}