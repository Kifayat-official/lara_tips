import { User } from "../../database/entities/user.entity";
import { UserEntityRequestPayload } from "./user.request";
import { UserEntityResponse } from "./user.response";

export default class UserMapper {
    public static reqToEntity(requestPayload: UserEntityRequestPayload) {
        let user: User = new User()
        user.id = requestPayload.id
        user.username = requestPayload?.email
        user.password = requestPayload.password
        user.firstName = requestPayload.firstName
        user.lastName = requestPayload.lastName
        return user
    }

    public static entityToResponse(user: User) {
        let userRes: UserEntityResponse = {
            id: Number(user.id),
            email: user.username,
            firstName: user.firstName,
            lastName: user.lastName
        }
        return userRes
    }
}