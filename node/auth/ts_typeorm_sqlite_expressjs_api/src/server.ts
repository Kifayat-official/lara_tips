import 'reflect-metadata';
import { createExpressServer, useContainer } from 'routing-controllers';
import { tsyringeAdapter } from './ioc/container';
import { AppDataSource } from './data_source';

const port = process.env.PORT || 3000;
useContainer(tsyringeAdapter);

(async () => {
    try {

        await AppDataSource.initialize();

        const routingControllersOptions = {
            controllers: [`${__dirname}/controllers/*.ts`],
        };

        const app = createExpressServer(routingControllersOptions)

        app.listen(port, () => {
            console.log(`http://localhost:${port}`);
        });

    } catch (err) {
        console.error(err)
    }

})()

