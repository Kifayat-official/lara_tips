import { DependencyContainer, inject, injectable, InjectionToken } from 'tsyringe';
import { IocAdapter } from 'routing-controllers';

@injectable()
export class TSyringeAdapter implements IocAdapter {
    private container: DependencyContainer;

    constructor(container: DependencyContainer) {
        this.container = container;
    }

    get<T>(someClass: InjectionToken<T>): T {
        return this.container.resolve(someClass);
    }
}
