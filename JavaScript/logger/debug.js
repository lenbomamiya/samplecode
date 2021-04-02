//
// デバッグログ
//
const DBG_LV = {
    SET: 7, // You can set logging level here.
    len: 256,
    prefix: "@Title: ",
    async: true,
    ipaddr: "http://192.168.243.26:8878/?",
    SVR: 0,
    SUB: 1,
    LOG: 2,
    INF: 5,
    WAR: 7,
    ERR: 9
};

/**
 * @param {string} [strLog] default as "" 
 * @param {number} [numLv] default as DBG_LV.LOG
 * @param {number} [numLeng] default as 256ß
 */
function DebugLog( strLog, numLv, numLeng )
{    
    var text = typeof strLog !== 'undefined' ? String(strLog) : "";
    var level = typeof numLv !== 'undefined' ? Number(numLv) : DBG_LV.LOG;
    var length = typeof numLeng !== 'undefined' ? Number(numLeng) : DBG_LV.len;

    if( text.length > length && level != DBG_LV.SVR ){
        level = DBG_LV.SUB;
    }//endif

    if( level >= DBG_LV.SET ){
        switch( level ){
            case DBG_LV.SVR:
                var now = new Date();
                var date = now.getHours()+":"+now.getMinutes()+":"+now.getSeconds()+"."+now.getMilliseconds();
                $.ajax({
                    type: "POST",
                    url: DBG_LV.ipaddr +'(' +date +') ' +text,
                    async: DBG_LV.async,
                    timeout: 10000,
                });
            case DBG_LV.SUB:
                var head = 0;
                var tail = ( text.length < length ) ? text.length : length;
                console.log( DBG_LV.prefix +"DBG_LV.SUB >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>" );
                while( text.length > head ){
                    console.log( text.slice( head, tail ) );
                    head = tail;
                    tail = ( (tail+length) < text.length ) ? tail+length : text.length ;
                };
                console.log( DBG_LV.prefix +"DBG_LV.SUB <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<" );
                break;
            case DBG_LV.INF:
                console.info( DBG_LV.prefix +text );
                break;
            case DBG_LV.WAR:
                console.warn( DBG_LV.prefix +text );
                break;
            case DBG_LV.ERR:
                console.error( DBG_LV.prefix +text );
                break;
            default:
                console.log( DBG_LV.prefix +text );
        } //endswitch
    } //endif
}