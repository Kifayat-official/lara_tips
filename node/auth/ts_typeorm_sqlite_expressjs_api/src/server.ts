import 'reflect-metadata';
import { createExpressServer, useContainer } from 'routing-controllers';
import { tsyringeAdapter } from './ioc/container';
import { MySqlDataSource, SqliteDataSource } from './config/database/data_source';
import { selectDatasourceMiddleware } from './middlewares/select-datasource';



const port = process.env.PORT || 3000;
useContainer(tsyringeAdapter);

(async () => {
    try {

        await MySqlDataSource.initialize()
        await SqliteDataSource.initialize();

        const app = createExpressServer({
            controllers: [`${__dirname}/controllers/*.ts`],
        });

        app.use(selectDatasourceMiddleware);


        app.listen(port, () => {
            console.log(`http://localhost:${port}`);
        });


    } catch (err) {
        console.error(err)
    }

})()
