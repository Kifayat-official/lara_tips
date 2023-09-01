export interface IExceptionResponse {
    status?: number,
    error?: string,
    data?: any,
    errorMessage: string,
    errorCode: number,
    timestamp: Date
}