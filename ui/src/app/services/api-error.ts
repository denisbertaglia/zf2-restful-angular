export interface ApiError {
    status: number;
    statusText: string;
    error: Errors;
    url: null | string;
}

export interface Errors {
    errors: {
        message: string;
        code: number;
    }
}