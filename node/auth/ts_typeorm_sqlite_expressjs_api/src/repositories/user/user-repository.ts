import { DataSource, Repository } from 'typeorm';
import { IUserRepository } from './iuser-repository';
import { injectable } from 'tsyringe';
import { User } from '../../entities/user';
import { Req } from 'routing-controllers';
import { Request } from 'express';

@injectable()
class UserRepository implements IUserRepository {
    private user: Repository<User>;
    private req: Request;
    //constructor(@inject('UserRepository') private user: Repository<User>) {}

    constructor() {
        const dataSource: DataSource = this.req.app.locals.data_source;
        this.user = dataSource.getRepository(User);
    }

    public async getAllUsers(): Promise<User[]> {
        return this.user.find()
    }

    // async getUserById(id: number): Promise<User | undefined> {
    //     return this.userRepository.findOne(id);
    // }

    public async createUser(user: User): Promise<User> {
        return this.user.save(user)
    }

    // public async updateUser(id: number, updatedUser: User): Promise<User | undefined> {
    //     await this.userRepository.update(id, updatedUser);
    //     return this.getUserById(id);
    // }

    // public async deleteUser(id: number): Promise<void> {
    //     await this.userRepository.delete(id);
    // }
}

export { UserRepository };
