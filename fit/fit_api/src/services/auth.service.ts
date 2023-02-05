import RegisterMapper from "../mappers/signup.mapper";
import { RegisterRequestPayload } from "../payload/request/auth.payload";
import AuthRepo from "../repositories/auth.repo";

export default class AuthService {
    // register user
    public static registerUser(requestPayload: RegisterRequestPayload) {
        AuthRepo.registerUser(RegisterMapper.reqToEntity(requestPayload));
        return true
    }
    // login user
}