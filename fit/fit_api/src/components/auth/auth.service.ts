import UserMapper from "../user/user.mapper";
import UserRepo from "../user/user.repo";
import { UserEntityRequestPayload } from "../user/user.request";
import { IUserEntityResponse } from "../user/user.response";
import UserService from "../user/user.service";
import AuthMapper from "./auth.mapper";
import { IAuthResponse } from "./auth.response";

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
        let signupResponse: IAuthResponse
        let userEntityResponse: IUserEntityResponse

        try {
            // check if user already exists
            userEntityResponse = await UserService.getUserByUsername(requestPayload.username)
            if (userEntityResponse) {
                return signupResponse = await AuthMapper.userAlreadyExistsResponse(userEntityResponse)
            }

            // user creation
            let userReqToEntity = await UserMapper.reqToEntity(requestPayload)
            let userEntity = await UserRepo.create(userReqToEntity)
            userEntityResponse = UserMapper.entityToResponse(userEntity)

            return signupResponse = await AuthMapper.userCreatedResponse(userEntityResponse)

        } catch (error) {
            console.log(error)
        }
    }
}