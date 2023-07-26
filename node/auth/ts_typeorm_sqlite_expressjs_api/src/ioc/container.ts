import { DependencyContainer, container as tsyringeContainer } from 'tsyringe';
import { IUserRepository } from '../repositories/user/iuser-repository';
import { UserRepository } from '../repositories/user/user-repository';
import { TSyringeAdapter } from './ioc-adapter';

// Bind the implementations to the interfaces using the container
tsyringeContainer.register<IUserRepository>('IUserRepository', { useClass: UserRepository });
// Export the TSyringe container instance
export const container: DependencyContainer = tsyringeContainer;

// Create the adapter instance using the container
const tsyringeAdapter = new TSyringeAdapter(container);

// Export the adapter instance
export { tsyringeAdapter };

