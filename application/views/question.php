<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link link href='http://fonts.googleapis.com/css?family=Hanuman' rel="stylesheet">
	<script type="text/javascript" async  src="https://cdnjs.cloudflare.com/ajax/libs/mathjax/2.7.2/MathJax.js?config=TeX-MML-AM_CHTML"></script>

	<script type="text/x-mathjax-config">

    MathJax.Hub.Config({
        showProcessingMessages: false,
        messageStyle: "none",
        tex2jax: {
          inlineMath: [
            ['$', '$'],
            ['\\(', '\\)']
          ],
          processEscapes: true
        },
    });

	</script>
	<style type="text/css">
    *{margin: 0;padding: 0;box-sizing: border-box;font-family: Arial,'Hanuman'}
    p.ans{
      border: 1px solid #000;
      display: inline-block;
      padding: 8px;
    }
    p{line-height: 35px}
    button.show{
        color: #fff;
        background-color: #26a69a;
        border: none;
        border-radius: 2px;
        line-height: 36px;
        padding: 0 2rem;
        outline: none;
    }
	</style>
</head>
<body style="padding:15px">
<p><?=$question?></p>
<hr style='margin:20px'>
<div style='text-align: center;color: #E91E63;font-size: medium;'><button type='button' class='show'>ចុចទីនេះមើលចម្លើយ</button></div>
<div id='ans' style='display:none'><?=$answer?></div>

<script type="text/javascript">
  var btn = document.querySelector("button");
  var ans = document.querySelector("#ans");
  var i=0;
  btn.onclick=function(){
    ans.style.display =(i%2==0)? "inline-block":"none";  
    i++;
  }
</script>
</body>
</html>