import { User } from "../entity/User";
import { RegisterUserRequestPayload } from "../payload/request/auth.payload";

export default class UserRegisterMapper {
    public static reqToEntity(requestPayload: RegisterUserRequestPayload) {
        let user: User = {
            id: requestPayload.id,
            username: requestPayload.email,
            password: requestPayload.password,
            firstName: requestPayload.firstName,
            lastName: requestPayload.lastName
        }
        return user
    }
}