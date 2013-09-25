function follow_add(user){
    $.post("php/follow_add.php", { user: user});
   // $('#likebox_'+article+'').load('php/load_likebox.php?article_id='+article+'');	
   
if (document.getElementById("follow_button").value == 'Folgen') { 
   document.getElementById("follow_button").value= "Entfolgen";
  } else { 
     document.getElementById("follow_button").value= "Folgen"; 
  } 
   
}

function follow_add_location(location){
   
    $.post("php/follow_add.php", { location: location});
   	
  
if (document.getElementById("follow_button_location").value == 'Folgen') { 
   document.getElementById("follow_button_location").value= "Entfolgen";
  } else { 
     document.getElementById("follow_button_location").value= "Folgen"; 
  } 
   
}

function follow_add_location_byid(location){
     
    $.post("../php/follow_add.php", { location: location});
  
   	if (document.getElementById("location_"+location).value == 'Folgen') { 
   document.getElementById("location_"+location).value= "Entfolgen";
  } else { 
     document.getElementById("location_"+location).value= "Folgen"; 
      //document.getElementById("location_"+location).style.backgroundColor="green";
  } 
  
}
   
  
function follow_add_user_byid(user){
   
    $.post("../php/follow_add.php", { user: user});
   	if (document.getElementById("user_"+user).value == 'Folgen') { 
   document.getElementById("user_"+user).value= "Entfolgen";
  } else { 
     document.getElementById("user_"+user).value= "Folgen"; 
      //document.getElementById("location_"+location).style.backgroundColor="green";
  } 
   
  
}