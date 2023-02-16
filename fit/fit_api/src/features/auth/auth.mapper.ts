
import { Jwt } from "../../common/utilities/jwt.utility";
import { IUserResponsePayload } from "../../components/user/user.response";
import { IAuthResponse } from "./auth.response";

export default class AuthMapper {
    public static async signUpSuccessResponse(userResponse: IUserResponsePayload) {
        let signupResponse: IAuthResponse = {
            status: 201,
            message: "User Created Successfully!",
            data: { result: userResponse, token: await Jwt.generateJwt(userResponse) }
        }

        return signupResponse
    }

    public static async signInSuccessResponse(userResponse: IUserResponsePayload) {
        let signinResponse: IAuthResponse = {
            status: 201,
            message: "User Logged in Successfully!",
            data: { result: userResponse, token: await Jwt.generateJwt(userResponse) }
        }
        return signinResponse
    }

    public static async userAlreadyExistsResponse() {
        let signupResponse: IAuthResponse = {
            status: 400,
            message: "User Already Exists!",
            data: { result: null, token: null }
        }
        return signupResponse
    }

    public static async userDoesNotExistsResponse() {
        let signinResponse: IAuthResponse = {
            status: 404,
            message: "User Does Not Exists!",
            data: { result: null, token: null }
        }
        return signinResponse
    }

    public static async passwordDoesNotMatchResponse() {
        let invalidPasswordResponse: IAuthResponse = {
            status: 400,
            message: "Invalid Credentials!",
            data: { result: null, token: null }
        }
        return invalidPasswordResponse
    }

    public static async unauthorizedAccessResponse() {
        let unauthorizedUserAccessResponse: IAuthResponse = {
            status: 401,
            message: "Unauthorized User!",
            data: { result: null, token: null }
        }
        return unauthorizedUserAccessResponse
    }
}