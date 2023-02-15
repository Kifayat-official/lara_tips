import { IExceptionResponse } from "./exception.response"

export default class ExceptionMapper {
    public static errorToResponse(message: string, error: any) {
        let response: IExceptionResponse = {
            status: 500,
            message: message,
            data: error
        }
        return response
    }
}