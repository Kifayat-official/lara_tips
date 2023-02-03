import { User } from "../entity/User";
import AuthVM from "../view-model/auth/signup.vm";

export default class AuthRepo {

    public static registerUser(userEntity: User) {
        return true
    }
}