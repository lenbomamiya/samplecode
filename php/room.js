//*********************************************************************
// JavaScript Document
//
// Description: For "Hall Building" and "Classroom#" of SelectBox
// Programmer : lenbo
// History    : 20121101 - Release.
//              20130725 - To add comments and change function name.
//**********************************************************************

// Which hall building does the classroom at?
var HallList = [ "誠", "正", "樸", "綜", "教" ];

// To list all classroom# in detected hall building.
var NumList = [];
NumList [ "誠" ] = [ "101", "102",                        "105", "106", "107", "108", "109",
                     "201", "202",          "203", "204", "205", "206", "207", "208",
                     "301", "302",           	   "304", "305", "306", "307",
                     "401", "402" ];
NumList [ "正" ] = [ "101", "102",          "103", "104", "105", "106",
                     "201", "202",          "203", "204", "205", "206",
                     "301", "302",          "303", "304", "305", "306",
                     "401", "402A", "402B", "403", "404", "405", "406", "407" ];
NumList [ "樸" ] = [                                      "105", "106",
                            "202",          "203", "204", "205", "206",
                     "301", "302",          "303", "304", "305", "306",
                     "401", "402",          "403", "404",        "406", "407" ];
NumList [ "綜" ] = [ "202", "210", "508", "509", "1001" ];
NumList [ "教" ] = [ "104", "105", "201", "202" ];

//
// The main function on loading SelectBox.
//
function room ( IsQuery ){

    //
    // In query mode. 
    //
    if ( IsQuery ) {

        var Hall = document.getElementById ( "QueHall" );
    	var Num  = document.getElementById ( "QueNum" );
    	var Key  = document.getElementById ( "QueKey" );

        // To set default selected value.		
    	Hall.options.add ( selected_all() );
    	Num.options.add ( selected_all() );
    	
    	// To add all hall building's name in the SelectBox.
    	for ( var Count in HallList ) {
        	var obj   = document.createElement ( "option" );
        	obj.text  = HallList [ Count ];
        	obj.value = HallList [ Count ];
        	Hall.options.add ( obj );
    	}

    	// When hall building is selected.
    	Hall.onchange = function() {
	
            Num.innerHTML = "";                  // To clean SelectBox's value before.
            Num.options.add ( selected_all() );  // To set default selected value.

            // To list correspondent classroom#.
        	if ( this.selectedIndex > 0 ) {
                for ( var Count in NumList [ Hall.value ] ) {
                    var obj   = document.createElement ( "option" );
                	obj.text  = NumList [ Hall.value ] [ Count ];
                	obj.value = NumList [ Hall.value ] [ Count ];
                	Num.options.add ( obj );
                }
        	}
    	};
    	
    	// When classroom# is also selected, to generate the RoomKey.
    	Num.onchange = function () {
            if( this.selectedIndex > 0 ) {
                if ( Hall.value == "誠" ) Key.value = "1" + Num.value;
                if ( Hall.value == "正" ) Key.value = "2" + Num.value;
                if ( Hall.value == "樸" ) Key.value = "3" + Num.value;
                if ( Hall.value == "綜" ) Key.value = "7" + Num.value;
                if ( Hall.value == "教" ) Key.value = "8" + Num.value;
            }
        };

    //
    // In registration mode
    //
    } else {

        var Hall = document.getElementById ( "RoomHall" );
    	var Num  = document.getElementById ( "RoomNum" );
    	var Key  = document.getElementById ( "RoomKey" );

        // To set default selected value. 		
    	Hall.options.add ( selected_none() );
    	Num.options.add ( selected_none() );
    	
    	// To add all hall building's name in the SelectBox.
    	for ( var Count in HallList ) {
            var obj   = document.createElement ( "option" );
            obj.text  = HallList [ Count ];
            obj.value = HallList [ Count ];
            Hall.options.add ( obj );
    	}

    	// When hall building is selected.
    	Hall.onchange = function(){

            Num.innerHTML = "";                  // To clean SelectBox's value before.
            Num.options.add ( selected_none() ); // To set default selected value.
        
            // To list correspondent classroom#.
            if ( this.selectedIndex > 0 ) {
                for ( var Count in NumList [ Hall.value ] ) {
                    var obj   = document.createElement ( "option" );
                    obj.text  = NumList [ Hall.value ] [ Count ];
                    obj.value = NumList [ Hall.value ] [ Count ];
                    Num.options.add ( obj );
                }
            }
    	};
    	
    	// When classroom# is also selected, to generate the RoomKey.
    	Num.onchange = function() {
            if ( this.selectedIndex > 0 ) {
                if ( Hall.value == "誠" ) Key.value = "1" + Num.value;
                if ( Hall.value == "正" ) Key.value = "2" + Num.value;
	            if ( Hall.value == "樸" ) Key.value = "3" + Num.value;
                if ( Hall.value == "綜" ) Key.value = "7" + Num.value;
                if ( Hall.value == "教" ) Key.value = "8" + Num.value;
            }
        };
    }
} // End of function room ( IsQuery );

//
// To set default selected value in registration mode.
//
function selected_none() {
    var obj   = document.createElement ( "option" );
    obj.text  = "請選擇";
    obj.value = "";
    return obj;
}

//
//  To set default selected value in query mode.
//
function selected_all() {
    var obj   = document.createElement ( "option" );
    obj.text  = "各";
    obj.value = "";
    return obj;
}

//
// To change selected choice by value.
//
function change_choice ( ItemId, ItemValue ) {
    var obj = document.getElementById ( ItemId );
    for ( var Count = 0; Count < obj.options.length; Count++ ) {
    	if ( obj.options[Count].value == ItemValue ) {
            obj.selectedIndex = Count;
            obj.onchange();
            break;
        }
    }
 }