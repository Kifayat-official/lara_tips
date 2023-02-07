import { User } from "../entities/user.entity";
import { UserEntityRequestPayload } from "../payload/request/user.payload";

export default class UserMapper {
    public static reqToEntity(requestPayload: UserEntityRequestPayload) {
        let user: User = new User()
        user.username = requestPayload.email
        user.password = requestPayload.password
        user.firstName = requestPayload.firstName
        user.lastName = requestPayload.lastName
        return user
    }
}