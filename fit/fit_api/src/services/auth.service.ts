import UserRegisterMapper from "../mappers/signup.mapper";
import RegisterMapper from "../mappers/signup.mapper";
import { RegisterUserRequestPayload } from "../payload/request/auth.payload";
import AuthRepo from "../repositories/auth.repo";

export default class AuthService {
    // register user
    public static registerUser(requestPayload: RegisterUserRequestPayload) {
        AuthRepo.registerUser(UserRegisterMapper.reqToEntity(requestPayload));
        return true
    }
    // login user
}