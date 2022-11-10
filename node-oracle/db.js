var oracledb = require('oracledb');
oracledb.getConnection({
    user: "tescobill",
    password: "tescobill_pitc",
    connectString: "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST   = 128.101.23.106)(PORT = 1521))(CONNECT_DATA =(SID= orcl)))"
}, function (err, connection) {
    if (err) {
        console.error(err.message);
        return;
    } connection.execute("SELECT * FROM VW_GENERAL_BILL_PRINT WHERE CKEY='02591130057920'", [], function (err, result) {
        if (err) {
            console.error(err.message);
            doRelease(connection);
            return;
        } console.log(result.metaData);
        console.log(result.rows);
        doRelease(connection);
    });
});
function doRelease(connection) {
    connection.release(function (err) {
        if (err) {
            console.error(err.message);
        }
    }
    );
}