import { NextFunction, Request, Response, } from "express"
import { User } from "../../database/entities/user.entity"
import { Jwt } from "../../common/utilities/jwt.utility"
import { AuthenticatedRequest } from "./auth.request";
import AuthMapper from "./auth.mapper";


export const authMiddleware = async (req: AuthenticatedRequest, res: Response, next: NextFunction) => {
    try {
        const { authorization } = req.headers

        if (!authorization) {
            const authEndPointResponse = AuthMapper.unauthorizedAccessResponse()
            return res.send(authEndPointResponse)
        }

        const token = authorization.split(' ')[1];

        // Verify token and get user ID
        let user: User = await Jwt.verifyJwt(token)
        req.user = { id: user.id }
        next()

    } catch (error) {
        console.log(error)
    }
}