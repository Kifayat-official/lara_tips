import { User } from "../../database/entities/user.entity";
import { Password } from "../../utilities/password.utility";
import { IUserRequestPayload } from "./user.request";
import { IUserResponse } from "./user.response";

export default class UserMapper {
    public static async reqToEntity(requestPayload: IUserRequestPayload) {
        let user: User = new User()
        //user.id = requestPayload?.id
        user.username = requestPayload.username
        user.password = await Password.hashPassword(requestPayload.password)
        user.first_name = requestPayload?.first_name
        user.last_name = requestPayload?.last_name
        return user
    }

    public static entityToResponse(user: User) {
        let userRes: IUserResponse = {
            id: Number(user.id),
            username: user.username,
            first_name: user.first_name,
            last_name: user.last_name
        }
        return userRes
    }
}