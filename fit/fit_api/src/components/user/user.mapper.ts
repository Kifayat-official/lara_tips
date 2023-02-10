import { UserEntity } from "../../database/entities/user.entity";
import { Password } from "../../utilities/password.utility";
import { UserEntityRequestPayload } from "./user.request";
import { IUserEntityResponse } from "./user.response";

export default class UserMapper {
    public static async reqToEntity(requestPayload: UserEntityRequestPayload) {
        let user: UserEntity = new UserEntity()
        user.id = requestPayload.id
        user.username = requestPayload?.username
        user.passwordHash = await Password.hashPassword(requestPayload.password)
        user.firstName = requestPayload.firstName
        user.lastName = requestPayload.lastName
        return user
    }

    public static entityToResponse(user: UserEntity) {
        let userRes: IUserEntityResponse = {
            id: Number(user.id),
            username: user.username,
            firstName: user.firstName,
            lastName: user.lastName
        }
        return userRes
    }
}