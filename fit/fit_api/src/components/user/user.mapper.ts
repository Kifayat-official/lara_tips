import { User } from "../../database/entities/user.entity";
import { Password } from "../../common/utilities/password.utility";
import { IUserRequestPayload } from "./user.request";
import { IUserEndPointResponse, IUserResponsePayload } from "./user.response";

export default class UserMapper {
    public static async reqToEntity(requestPayload: IUserRequestPayload) {
        let user: User = new User()
        user.username = requestPayload.username
        user.password = await Password.hashPassword(requestPayload.password)
        user.first_name = requestPayload?.first_name
        user.last_name = requestPayload?.last_name
        return user
    }

    public static entityToResponse(user: User) {
        let userRes: IUserResponsePayload = {
            id: Number(user.id),
            username: user.username,
            first_name: user?.first_name,
            last_name: user?.last_name
        }
        return userRes
    }

    public static userCreationEndpointResponse(userResponse: IUserResponsePayload) {
        let userEndPointResponse: IUserEndPointResponse = {
            status: 201,
            message: "User Created Successfully!",
            data: { user: userResponse }
        }

        return userEndPointResponse
    }

    public static userFetchEndpointResponse(userResponse: IUserResponsePayload) {
        let userEndPointResponse: IUserEndPointResponse = {
            status: 204,
            message: "User Fetched Successfully!",
            data: { user: userResponse }
        }

        return userEndPointResponse
    }


}