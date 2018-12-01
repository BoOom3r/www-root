<?php session_start();
?>
<p>&nbsp;</p>
<p><img src="https://www.onecraft.fr/forum/styles/uix/uix/logo.png" alt="" width="308" height="80" /></p>
<h1>&nbsp;</h1>
<h1 style="text-align: left; padding-left: 150px;"><span style="color: #333333;"><strong>Desole mais tu as déja gagné cette enigme :/</strong></span></h1>
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>
<h1>&nbsp;</h1>

<script>
window.setTimeout(function() {
    window.location = "index.php?uuid=<?php echo ($_SESSION['uuid']);?>";
  }, 4000);
</script>