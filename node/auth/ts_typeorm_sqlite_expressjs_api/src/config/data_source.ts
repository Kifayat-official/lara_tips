import "reflect-metadata"
import { DataSource } from "typeorm"
import { User } from "../entities/user"



const MySqlDataSource = new DataSource({
    type: "sqlite",
    database: "mysql.sqlite",
    synchronize: true,
    logging: false,
    entities: [User],
    migrations: [],
    subscribers: [],
})

const SqliteDataSource = new DataSource({
    type: "sqlite",
    database: "database.sqlite",
    synchronize: true,
    logging: false,
    entities: [User],
    migrations: [],
    subscribers: [],
})

// Map of supported data sources
const SUPPORTED_DATA_SOURCES: Record<string, any> = {
    'sqlite': SqliteDataSource,
    'mysql': MySqlDataSource,
  };

export {SUPPORTED_DATA_SOURCES, MySqlDataSource, SqliteDataSource}