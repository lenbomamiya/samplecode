//*********************************************************************
// JavaScript Document
//
// Description: For "StartTime" and "EndTime" of SelectBox
// Programmer : lenbo
// History    : 20121101 - Release.
//              20130725 - To add comments and change function name.
//**********************************************************************

var StartTimeList = [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10" ];

var EndTimeList = [];
EndTimeList [ "1" ] = [ "1", "2", "3", "4", "5", "6", "7", "8", "9", "10" ];
EndTimeList [ "2" ] = [      "2", "3", "4", "5", "6", "7", "8", "9", "10" ];
EndTimeList [ "3" ] = [           "3", "4", "5", "6", "7", "8", "9", "10" ];
EndTimeList [ "4" ] = [                "4", "5", "6", "7", "8", "9", "10" ];
EndTimeList [ "5" ] = [                     "5", "6", "7", "8", "9", "10" ];
EndTimeList [ "6" ] = [                          "6", "7", "8", "9", "10" ];
EndTimeList [ "7" ] = [                               "7", "8", "9", "10" ];
EndTimeList [ "8" ] = [                                    "8", "9", "10" ];
EndTimeList [ "9" ] = [                                         "9", "10" ];
EndTimeList ["10" ] = [                                              "10" ];

//
// The main function on loading SelectBox.
//
function time () {
	
    var StartTimeVar = document.getElementById ( "StartTime" );
    var EndTimeVar   = document.getElementById ( "EndTime" );
 	
	// To add all StartTime in the SelectBox.
   	for ( var Count in StartTimeList ) {
       	var obj   = document.createElement ( "option" );
       	obj.text  = StartTimeList [ Count ];
       	obj.value = StartTimeList [ Count ];
       	StartTimeVar.options.add ( obj );
   	}
	
   	// When StartTime is selected.
   	StartTimeVar.onchange = function () {
	
        EndTimeVar.innerHTML = ""; // To clean SelectBox's value before.
    
        // To list correspondent classroom#.    
       	if ( this.selectedIndex >= 0 ) {
			for ( var Count in EndTimeList [ StartTimeVar.value ] ) {
               	var obj   = document.createElement ( "option" );
               	obj.text  = EndTimeList [ StartTimeVar.value ] [ Count ];
               	obj.value = EndTimeList [ StartTimeVar.value ] [ Count ];
               	EndTimeVar.options.add ( obj );
           	}
       	}
   	};
} // End of function time ();

//
// To change selected time by value.
//
function change_time ( ItemId, ItemValue ) {
	var obj = document.getElementById ( ItemId );
    for ( var Count = 0; Count < obj.options.length; Count++ ) {
    	if ( obj.options[Count].value == ItemValue ) {
            obj.selectedIndex = Count;
			obj.onchange();
			break;
        }
    }
}