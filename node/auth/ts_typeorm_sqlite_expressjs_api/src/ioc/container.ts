import { container } from 'tsyringe';
import { IUserRepository } from '../repositories/user/iuser-repository';
import { UserRepository } from '../repositories/user/user-repository';
import { TSyringeAdapter } from './ioc-adapter';
import { User } from '../entities/user';

// Bind the implementations to the interfaces using the container
container.register<IUserRepository>('IUserRepository', { useClass: UserRepository });
// container.register('UserRepository', {
//     useFactory: () => AppDataSource.getRepository(User),
// });

// Export the TSyringe container instance
// export const container: DependencyContainer = tsyringeContainer;

// Create the adapter instance using the container
const tsyringeAdapter = new TSyringeAdapter(container);

// Export the adapter instance
export { tsyringeAdapter };

