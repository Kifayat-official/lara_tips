import { Response, NextFunction, Request } from 'express';
import { SUPPORTED_DATA_SOURCES, SqliteDataSource } from '../config/database/data_source';
import CustomRequest from '../interfaces/custom-request';
import { DataSource } from 'typeorm';


/**
 * Middleware to select the data source based on the 'data_source' header in the request.
 * If the 'data_source' header is not provided or not recognized, the default data source 'sqlite' will be used.
 * @param req The Express request object.
 * @param res The Express response object.
 * @param next The next middleware function.
 */
function selectDatasourceMiddleware(req: Request, res: Response, next: NextFunction) {
  // Extract the 'data_source' header from the request headers and access the first element (if it exists)
  const data_source_header = "mysql";// req.headers['data_source']?.toString() || '';


  // Check if the data source is supported, otherwise use the default data source 'sqlite'
  // and set the selected data source on the application level
  req.app.locals.data_source = SUPPORTED_DATA_SOURCES[data_source_header] || SqliteDataSource;

  //console.log(req.data_source)
  // Continue to the next middleware or route handler
  next();
}

export { selectDatasourceMiddleware };
