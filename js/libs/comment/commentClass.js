function add_comment(id){
      text = document.getElementById("commentfield").value;
    $.post("php/add_comment.php", {  text: text, id: id });
    
    document.getElementById("commentfield").value = "";
    $('#commentbox').load('php/load_commentbox.php?id='+id+'');
		
}
