import MysqlFitDbDataSource from "../database/db.config";
import { User } from "../entities/user.entity";

export default class UserRepo {

    public static async all() {
        return await MysqlFitDbDataSource.getRepository(User).find()
    }
    public static async get(id: number) {
        return await MysqlFitDbDataSource.getRepository(User).findOne({ where: { id: id } })
    }
    public static async create(user: User) {
        return await MysqlFitDbDataSource.getRepository(User).save(user)
    }
    public static async delete(id: number) {
        return await MysqlFitDbDataSource.getRepository(User).delete(id)
    }
    public static async update(user: User) {
        return await MysqlFitDbDataSource.getRepository(User).update({ id: user.id }, user)
    }
}