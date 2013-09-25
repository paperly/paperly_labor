<?php
session_start();
unset($_SESSION['user_id']);
 session_destroy(); 
 
     echo "<script language='javascript'>";
	echo "window.location.href='index.php'";
	echo "</script>";
  ?>

           <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-40911491-1', 'paperly.de');
  ga('send', 'pageview');

</script>