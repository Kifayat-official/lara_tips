import { NextFunction, Request, Response, } from "express"
import { User } from "../../database/entities/user.entity"
import { Jwt } from "../../utilities/jwt.utility"
import { AuthenticatedRequest } from "./auth.request";


export const authMiddleware = async (
    req: AuthenticatedRequest,
    res: Response,
    next: NextFunction
) => {
    try {
        const { authorization } = req.headers

        if (!authorization) {
            return res.status(401).send({ message: "Unauthorized User!" });
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
// export default class AuthMiddleware {

//     public static async auth(req: AuthenticatedRequest, res: Response, next: NextFunction) {
//         try {
//             const { authorization } = req.headers

//             if (!authorization) {
//                 return res.status(401).send({ message: "Unauthorized User!" });
//             }

//             const token = authorization.split(' ')[1];

//             // Verify token and get user ID
//             let user: User = await Jwt.verifyJwt(token)
//             req.user = { id: user.id }
//             next()

//         } catch (error) {
//             console.log(error)
//         }
//     }
// }