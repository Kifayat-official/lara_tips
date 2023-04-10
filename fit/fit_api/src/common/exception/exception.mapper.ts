import { IExceptionResponse } from "./exception.response"

// export default class ExceptionMapper {
//     public static errorToResponse(message: string, error: any) {
//         let response: IExceptionResponse = {
//             status: 500,
//             error: `${message}. Error: ${error.message}`,
//             data: null
//         }
//         return response
//     }
// }

export default class ExceptionResponse implements IExceptionResponse {
    constructor(
        public errorMessage: string,
        public errorCode: number,
        public timestamp: Date
    ) { }
}