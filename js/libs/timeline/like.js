function like_add(user, article){
    $.post("php/like_add.php", { user: user, article: article });
    $('#likebox_'+article+'').load('php/load_likebox.php?article_id='+article+'');
		
}
function unlike_add(user, article){
    $.post("php/unlike_add.php", { user: user, article: article });
    $('#likebox_'+article+'').load('php/load_likebox.php?article_id='+article+'');
		
}
