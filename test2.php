
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



function load_new_article(id) {
              //  $('#myModal').modal('hide');

                $('#lala').load("remote.php?var=" + id);
               
                $('#myModal').modal('show');

            }


            function load_article(id) {

                $('#lala').load("remote.php?var=" + id);
                $('#myModal').modal('show');

            }

        </script>


    </head>
    <body>
        <div>TODO write content</div>


        <!-- Button trigger modal -->
        <button onclick="load_article('3dgdgiodgfjdgdgfgdgsdg');">
            hallo1
        </button>
        <button onclick="load_article('dgdfgdfg');">
            hallo2
        </button>     







       


        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div id="lala">
                        </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </body>
</html>
