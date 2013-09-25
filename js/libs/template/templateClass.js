/* 
 * Template Class Library - Paperly v1.0
 * Contains: All core methods of generating Template Elemts
 */

// make div visible
function showContentBox(id) {
    if (document.getElementById(id).style.visibility == "visible") {
        document.getElementById(id).style.visibility = "hidden";
    }
    else {
        document.getElementById(id).style.visibility = "visible";
    }
}