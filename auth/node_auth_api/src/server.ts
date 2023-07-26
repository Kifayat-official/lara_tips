import { createExpressServer, useContainer } from 'routing-controllers';
import { AppDataSource } from './data-source';
import { tsyringeAdapter } from './ioc/container';

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
            console.log(`Server is listening on port ${port}`);
        });

    } catch (err) {
        console.error(err)
    }

})()

