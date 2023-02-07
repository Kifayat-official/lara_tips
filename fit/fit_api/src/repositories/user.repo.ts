import MysqlFitDbDataSource from "../database/db.config";
import { User } from "../entities/user.entity";

export default class UserRepo {

    public static async getUsers() {
        return await MysqlFitDbDataSource.getRepository(User)
    }
    public static async getUser(id: number) {
        return await MysqlFitDbDataSource.getRepository(User).findOne({ where: { id: id } })
    }
    public static async createUser(user: User) {
        return await MysqlFitDbDataSource.getRepository(User).save(user)
    }
    public static async deleteUser(id: number) {
        return await MysqlFitDbDataSource.getRepository(User).delete(id)
    }
    public static async updateUser(user: User) {
        return await MysqlFitDbDataSource.getRepository(User).update({ id: user.id }, user)
    }
}