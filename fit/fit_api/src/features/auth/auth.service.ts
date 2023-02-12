import UserMapper from "../../components/user/user.mapper";
import UserRepo from "../../components/user/user.repo";
import { IUserRequestPayload } from "../../components/user/user.request";
import { IUserResponse } from "../../components/user/user.response";
import UserService from "../../components/user/user.service";
import { User } from "../../database/entities/user.entity";
import { Password } from "../../utilities/password.utility";
import AuthMapper from "./auth.mapper";

export default class AuthService {

    // User login
    public static async signIn(requestPayload: IUserRequestPayload) {

        let existingUser: User = await UserRepo.getUserByUsername(requestPayload.username)
        if(!existingUser) {
            return await AuthMapper.userDoesNotExistsResponse()
        }
        
        let isPasswordMatches = await Password.verifyPassword(requestPayload.password, existingUser.password)
        if(!isPasswordMatches) {
            return await AuthMapper.passwordDoesNotMatchResponse()
        }
        
        let userResponse = UserMapper.entityToResponse(existingUser)
        return await AuthMapper.signInSuccessResponse(userResponse)
    }

    // User registrationuserResponse
    public static async signUp(requestPayload: IUserRequestPayload) {
        let userResponse: IUserResponse

        try {
            // check if user already exists
            userResponse = await UserService.getUserByUsername(requestPayload.username)
            if (userResponse) {
                return await AuthMapper.userAlreadyExistsResponse()
            }

            // user creation
            let user: User = await UserMapper.reqToEntity(requestPayload)
            let newDbUser: User = await UserRepo.create(user)
            userResponse = UserMapper.entityToResponse(newDbUser)
            
            return await AuthMapper.signUpSuccessResponse(userResponse)

        } catch (error) {
            console.log(error)
        }
    }
}