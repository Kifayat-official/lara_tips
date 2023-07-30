import { Repository } from 'typeorm';
import { User } from '../../entities/user';
import { IUserRepository } from './iuser-repository';
import { inject, injectable } from 'tsyringe';
import { Req } from 'routing-controllers';
import { Request } from 'express';
import { AppDataSource } from '../../middlewares/select-datasource';

@injectable()
class UserRepository implements IUserRepository {
    private user: Repository<User>;

    //constructor(@inject('UserRepository') private user: Repository<User>) {}

    constructor() {
        this.user = AppDataSource.getRepository(User)
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
