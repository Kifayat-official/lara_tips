import { DataSource } from "typeorm";
import path from "path";

const MysqlFitDbDataSource = new DataSource({
    type: "mysql",
    host: "128.101.100.12",
    port: 3000,
    username: "enc_db",
    password: "wg3k2#339",
    database: "fit",
    synchronize: true,
    logging: true,
    entities: [path.join(__dirname, "..", "entities/**.entity{.ts,.js}")],
    migrations: [],
    subscribers: [],
})

export default MysqlFitDbDataSource