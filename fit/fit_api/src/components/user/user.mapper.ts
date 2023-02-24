import { User } from "../../database/entities/user.entity";
import { Password } from "../../common/utilities/password.utility";
import { IUserRequestPayload } from "./user.request";
import { IUserEndPointResponse, IUserResponsePayload } from "./user.response";
import { DeleteResult, UpdateResult } from "typeorm";

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

    public static userFetchEndpointResponse(userResponse: IUserResponsePayload) {
        let userEndPointResponse: IUserEndPointResponse = {
            status: 200,
            message: "User Fetched Successfully!",
            data: { result: userResponse }
        }

        return userEndPointResponse
    }

    public static userCreationEndpointResponse(responsePayload: IUserResponsePayload) {
        let userEndPointResponse: IUserEndPointResponse = {
            status: 201,
            message: "User Created Successfully!",
            data: { result: responsePayload }
        }
        return userEndPointResponse
    }

    public static userAlreadyExistsResponse() {
        let userEndPointResponse: IUserEndPointResponse = {
            status: 400,
            message: "User Already Exists!",
            data: { result: null }
        }
        return userEndPointResponse
    }

    public static userUpdateEndpointResponse(updateResult: UpdateResult) {
        let userEndPointResponse: IUserEndPointResponse = {
            status: 200,
            message: "User Updated Successfully!",
            data: { result: updateResult }
        }

        return userEndPointResponse
    }

    public static userDeleteEndpointResponse(userResponse: DeleteResult) {
        let userEndPointResponse: IUserEndPointResponse = {
            status: 202,
            message: "User Deleted Successfully!",
            data: { result: userResponse }
        }

        return userEndPointResponse
    }


}