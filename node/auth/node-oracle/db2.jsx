var oracledb = require('oracledb');

oracledb.getConnection({
    user: "disco",
    password: "asiscis",
    connectString: "(DESCRIPTION =(ADDRESS = (PROTOCOL = TCP)(HOST   = 192.168.2.14)(PORT = 1521))(CONNECT_DATA =(SID= orcl)))"
}, function (err, connection) {

    if (err) {
        console.error(err.message);
        return;
    }

    // console.log(connection)
    // doRelease(connection);
    // return;

    connection.execute("SELECT * FROM MENU_LEVEL_001", [], function (err, result) {
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