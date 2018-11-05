<?php
   session_start();
   include_once 'geshi/geshi.php';
?> 
<html>
<head>
<title>Online Compiler</title>
<meta charset="utf-8"/>
<link rel=stylesheet href="doc/docs.css">

<link rel="stylesheet" href="lib/codemirror.css">
<link rel="stylesheet" href="theme/3024-day.css">
<link rel="stylesheet" href="theme/3024-night.css">
<link rel="stylesheet" href="theme/ambiance.css">
<link rel="stylesheet" href="theme/base16-dark.css">
<link rel="stylesheet" href="theme/base16-light.css">
<link rel="stylesheet" href="theme/blackboard.css">
<link rel="stylesheet" href="theme/cobalt.css">
<link rel="stylesheet" href="theme/eclipse.css">
<link rel="stylesheet" href="theme/elegant.css">
<link rel="stylesheet" href="theme/erlang-dark.css">
<link rel="stylesheet" href="theme/lesser-dark.css">
<link rel="stylesheet" href="theme/mbo.css">
<link rel="stylesheet" href="theme/mdn-like.css">
<link rel="stylesheet" href="theme/midnight.css">
<link rel="stylesheet" href="theme/monokai.css">
<link rel="stylesheet" href="theme/neat.css">
<link rel="stylesheet" href="theme/night.css">
<link rel="stylesheet" href="theme/paraiso-dark.css">
<link rel="stylesheet" href="theme/paraiso-light.css">
<link rel="stylesheet" href="theme/pastel-on-dark.css">
<link rel="stylesheet" href="theme/rubyblue.css">
<link rel="stylesheet" href="theme/solarized.css">
<link rel="stylesheet" href="theme/the-matrix.css">
<link rel="stylesheet" href="theme/tomorrow-night-eighties.css">
<link rel="stylesheet" href="theme/twilight.css">
<link rel="stylesheet" href="theme/vibrant-ink.css">
<link rel="stylesheet" href="theme/xq-dark.css">
<link rel="stylesheet" href="theme/xq-light.css">
<script src="lib/codemirror.js"></script>
<script src="mode/javascript/javascript.js"></script>
<script src="keymap/extra.js"></script>
<script src="addon/selection/active-line.js"></script>
<script src="addon/edit/matchbrackets.js"></script>
<style type="text/css">
      .CodeMirror {border: 1px solid black; font-size:13px}
    </style>
</head>
<body>

<!--php code starts-->
 <?php
        if (isset($_REQUEST['code'])){
            $newcode=$_REQUEST['code'];
            $input=$_REQUEST['code1'];
            $oName = "temp/" . session_id();
            $fName= $oName . ".c";
            $fHandle=fopen($fName, 'w') or die ('can\'t open file');
            fwrite($fHandle, $newcode);
            fclose($fHandle);
            //$cherro =shell_exec('chmod 777 $fName');
            $cmd = "gcc $fName -o $oName > $oName.err 2>&1";
	    
         
           shell_exec($cmd);

         

            if (file_exists("$oName.err")){
               
                $fErr = fopen("$oName.err", "r");
                $errors = fread($fErr, filesize("$oName.err"));
            }

	    
if (filesize("$oName.err") == 0)
		{ 
if ($input){

$output=shell_exec("echo $input | $oName");

}
else
{ $output=shell_exec($oName); } 

}



            $geshi=new GeSHi($newcode,'c');
            $geshi->enable_line_numbers(GESHI_FANCY_LINE_NUMBERS);
            $geshi->set_header_type(GESHI_HEADER_PRE_VALID);
        }
        ?>

<!--php code ends-->



<table>
<tr><td><div style="margin-left:20px;"><h2>Online Compiler</h2>
<div style="width:600px;"><form name="compile" action="" method="post"><textarea id="code" name="code">
<?php echo $newcode ?>
</textarea>
<br>

<p>Select Your theme: <select onchange="selectTheme()" id=select>
    <option selected>night</option>
    <option>3024-day</option>
    <option>3024-night</option>
    <option>ambiance</option>
    <option>base16-dark</option>
    <option>base16-light</option>
    <option>blackboard</option>
    <option>cobalt</option>
    <option>eclipse</option>
    <option>elegant</option>
    <option>erlang-dark</option>
    <option>lesser-dark</option>
    <option>mbo</option>
    <option>mdn-like</option>
    <option>midnight</option>
    <option>monokai</option>
    <option>neat</option>
    <option>night</option>
    <option>paraiso-dark</option>
    <option>paraiso-light</option>
    <option>pastel-on-dark</option>
    <option>rubyblue</option>
    <option>solarized dark</option>
    <option>solarized light</option>
    <option>the-matrix</option>
    <option>tomorrow-night-eighties</option>
    <option>twilight</option>
    <option>vibrant-ink</option>
    <option>xq-dark</option>
    <option>xq-light</option>
</select>
</p>

<script>
  var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    styleActiveLine: true,
    matchBrackets: true
  });
  var input = document.getElementById("select");
  function selectTheme() {
    var theme = input.options[input.selectedIndex].innerHTML;
    editor.setOption("theme", theme);
  }
  var choice = document.location.search &&
               decodeURIComponent(document.location.search.slice(1));
  if (choice) {
    input.value = choice;
    editor.setOption("theme", choice);
  }
</script>



<h2> Standard Input </h2>
<textarea id="code1" name="code1" style="width:600px;">
</textarea><br><br>
<input type="submit" name="submit" value="Compile & Run">
</form></div>

</div></td>
<!--Second side starts-->
<td valign="top" align="center">

<table><tr><td>
<div style="width:200px; float:right; margin-left:50px;">
<h2>Output</h2>
<div class="output" name="output" style="height:150px;"><?php echo $output ?></div>
</div>

</td></tr>
<tr><td>
<div style="width:200px; float:right; margin-left:50px;">
<h2>Error</h2>
<div class="errors" name="errors"><?php echo $errors ?></div>
</div>
</td></tr></table>

</td>
</div>
</td></tr>
</table>





</body>
</html>
