import { Request } from "express";
import { DataSource } from "typeorm";

// Custom request interface extending the built-in Request interface
interface CustomRequest extends Request {
    data_source: DataSource;
}

export default CustomRequest;