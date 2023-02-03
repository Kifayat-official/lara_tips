import { User } from "../entity/User";
import AuthRepo from "../repositories/auth.repo";
import AuthVM from "../view-model/auth/signup.vm";

export default class AuthService {
    // register user
    public static registerUser(authVM: AuthVM) {
        let user: User = {
            username: authVM.email,
            password: authVM.password
        }

        AuthRepo.registerUser(user)
        return true
    }
    // login user
}