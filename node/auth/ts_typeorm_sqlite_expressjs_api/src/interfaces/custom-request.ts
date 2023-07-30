import { Request } from "express";

// Custom request interface extending the built-in Request interface
interface CustomRequest extends Request {
    data_source: string;
}

export default CustomRequest;