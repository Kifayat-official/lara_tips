import { Jwt } from "../../utilities/jwt.utility";
import { IUserEntityResponse } from "../user/user.response";
import { IAuthResponse } from "./auth.response";

export default class AuthMapper {
    public static async userCreatedResponse(userEntityResponse: IUserEntityResponse) {
        let signupResponse: IAuthResponse = {
            status: 201,
            message: "User Created Successfully!",
            data: { user: userEntityResponse, token: await Jwt.generateJwt(userEntityResponse) }
        }
        return signupResponse
    }

    public static async userAlreadyExistsResponse(userEntityResponse: IUserEntityResponse) {
        let signupResponse: IAuthResponse = {
            status: 400,
            message: "User Already Exists!",
            data: { user: null, token: null }
        }
        return signupResponse
    }
}