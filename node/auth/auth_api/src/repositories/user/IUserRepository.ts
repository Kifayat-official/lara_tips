import { User } from '../../entities/User';

export interface IUserRepository {
    getAllUsers(): Promise<User[]>;
    //getUserById(id: number): Promise<User | undefined>;
    createUser(user: User): Promise<User>;
    //updateUser(id: number, updatedUser: User): Promise<User | undefined>;
    //deleteUser(id: number): Promise<void>;
}