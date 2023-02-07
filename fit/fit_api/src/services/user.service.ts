import UserMapper from "../mappers/user.mapper";
import { UserEntityRequestPayload } from "../payload/request/user.payload";
import UserRepo from "../repositories/user.repo";

export default class UserService {
    // create user
    public static createUser(requestPayload: UserEntityRequestPayload) {
        UserRepo.createUser(UserMapper.reqToEntity(requestPayload));
        return true
    }
    // get single user by id
    public static getUser(id: number) {
        return UserRepo.getUser(id)
    }
    // get all users
    public static getAll() {
        return UserRepo.getAll()
    }
    // update user
    public static updateUser(requestPayload: UserEntityRequestPayload) {
        UserRepo.updateUser(UserMapper.reqToEntity(requestPayload));
        return true
    }
    // delete user
    public static deleteUser(id: number) {
        UserRepo.deleteUser(id)
        return true
    }
}