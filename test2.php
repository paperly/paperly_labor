
<!DOCTYPE html>
<html>
    <head>
        <base href="http://localhost" target="_blank">

        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/bootstrap.min.css" rel="stylesheet">
         <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
   <!-- <script src="https://code.jquery.com/jquery.js"></script> -->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
      <!-- jquery -->
        <script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
        <script src="http://code.jquery.com/jquery-migrate-1.1.1.min.js"></script>
    <script src="js/libs/bootstrap/bootstrap.min.js"></script>
    
     
       
       
    <script>
        
        
        
        function load_article(){
            
            
         
         //   $('#test').load('remote.html');
                    //   $('#test'). html("less...");
            
           // alert("html");
   //  $('.modal-content').load('remote.html');
  
      

  
 //      $('#lala').html("less...");
 $('#lala').load("remote.html");
            
    $('#myModal').modal('show');
            
    //$.post("php/unlike_add.php", { user: user, article: article });
    //$('#likebox_'+article+'').load('php/load_likebox.php?article_id='+article+'');
		
}

    </script>
    
    
    </head>
    <body>
        <div>TODO write content</div>
        
        
        <!-- Button trigger modal -->
<button onclick="load_article();">
  hallo
</button>
        
        <div id="test">1</div>
        
        
        
        

 <a data-toggle="modal" data-target="#myModal" href="remote.html"  >Seite 2</a>

 
 
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
         <div id="lala">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div></div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


    </body>
</html>
