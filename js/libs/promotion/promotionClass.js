/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


function load_promotioncalcalation(){
   months = document.getElementById("months").value;
    locations = document.getElementById("location-box-result-input").value;
   
    $('#calculation').load('php/load_promotioncalculation.php?locations='+locations+'&months='+months+'');

		
}