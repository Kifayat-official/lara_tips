import { User } from "../entity/User";
import { RegisterRequestPayload } from "../payload/request/auth.payload";

export default class RegisterMapper {
    public static reqToEntity(requestPayload: RegisterRequestPayload) {
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