import { Jwt } from "../../utilities/jwt.utility";
import { Password } from "../../utilities/password.utility";
import UserRepo from "../user/user.repo";
import { UserEntityRequestPayload } from "../user/user.request";
import UserService from "../user/user.service";
import { ISignupResponse } from "./signup.response";

export default class AuthService {

    // User login
    public static async signIn() {

        // let user: User = await UserRepo.get(id)
        // if (user) {
        //     let userRes = UserMapper.entityToResponse(user)
        //     return userRes
        // }
        // else {
        //     return "Sorry, user does not exists!";
        // }
    }

    // User registration
    public static async signUp(requestPayload: UserEntityRequestPayload) {
        let response: ISignupResponse
        try {
            // existing user check
            let isUserExists = UserService.getUserByUsername(requestPayload.username)
            if (isUserExists) {
                response.status = 400
                response.message = "User Already Exists!"
                response.data.createdUser = null
                response.data.token = null
                return response
            }

            // hash password
            requestPayload.password = await Password.hashPassword(requestPayload.password)

            // user creation
            let createdUser = await UserRepo.create(requestPayload)

            // generate token
            const jwt = await Jwt.generateJwt(createdUser)

            response.status = 201
            response.message = "User Created Successfully!"
            response.data.createdUser = createdUser
            response.data.token = jwt

            return response

        } catch (error) {
            console.log(error)
        }
    }
}