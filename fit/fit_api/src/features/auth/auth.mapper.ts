import { IUserResponse } from "../../components/user/user.response";
import { Jwt } from "../../common/utilities/jwt.utility";
import { IAuthResponse } from "./auth.response";

export default class AuthMapper {
    public static async signUpSuccessResponse(userResponse: IUserResponse) {
        let signupResponse: IAuthResponse = {
            status: 201,
            message: "User Created Successfully!",
            data: { user: userResponse, token: await Jwt.generateJwt(userResponse) }
        }

        return signupResponse
    }

    public static async signInSuccessResponse(userResponse: IUserResponse) {
        let signinResponse: IAuthResponse = {
            status: 201,
            message: "User Logged in Successfully!",
            data: { user: userResponse, token: await Jwt.generateJwt(userResponse) }
        }
        return signinResponse
    }

    public static async userAlreadyExistsResponse() {
        let signupResponse: IAuthResponse = {
            status: 400,
            message: "User Already Exists!",
            data: { user: null, token: null }
        }
        return signupResponse
    }

    public static async userDoesNotExistsResponse() {
        let signinResponse: IAuthResponse = {
            status: 404,
            message: "User Does Not Exists!",
            data: { user: null, token: null }
        }
        return signinResponse
    }

    public static async passwordDoesNotMatchResponse() {
        let invalidPasswordResponse: IAuthResponse = {
            status: 400,
            message: "Invalid Credentials!",
            data: { user: null, token: null }
        }
        return invalidPasswordResponse
    }
}