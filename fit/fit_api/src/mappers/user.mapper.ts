import { User } from "../entities/user.entity";
import { UserEntityRequestPayload } from "../payload/request/user.payload";
import { UserEntityResponse } from "../payload/response/user.response";

export default class UserMapper {
    public static reqToEntity(requestPayload: UserEntityRequestPayload) {
        let user: User = new User()
        user.username = requestPayload.email
        user.password = requestPayload.password
        user.firstName = requestPayload.firstName
        user.lastName = requestPayload.lastName
        return user
    }

    public static entityToResponse(user: User) {
        let userRes: UserEntityResponse = {
            email: user.username,
            firstName: user.firstName,
            lastName: user.lastName
        }
        return userRes
    }
}