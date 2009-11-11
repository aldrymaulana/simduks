<?php

/**
 * Jcrop image cropping plugin for jQuery
 * Example cropping script
 * @copyright 2008 Kelly Hallman
 * More info: http://deepliquid.com/content/Jcrop_Implementation_Theory.html
 */

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$targ_w = $targ_h = 150;
	$jpeg_quality = 90;

	$src = 'demo_files/flowers.jpg';
	$img_r = imagecreatefromjpeg($src);
	$dst_r = ImageCreateTrueColor( $targ_w, $targ_h );

	imagecopyresampled($dst_r,$img_r,0,0,$_POST['x'],$_POST['y'],
	$targ_w,$targ_h,$_POST['w'],$_POST['h']);

	header('Content-type: image/jpeg');
	imagejpeg($dst_r,null,$jpeg_quality);

	exit;
}

// If not a POST request, display page below:

?><html>
	<head>

		<script src="../js/jquery.min.js"></script>
		<script src="../js/jquery.Jcrop.js"></script>
		<link rel="stylesheet" href="../css/jquery.Jcrop.css" type="text/css" />
		<link rel="stylesheet" href="demo_files/demos.css" type="text/css" />
		<style type="text/css">
			fieldset.optdual { width: 500px; }
			.optdual { position: relative; }
			.optdual .offset { position: absolute; left: 18em; }
			.optlist label { width: 16em; display: block; }
			#dl_links { margin-top: .5em; }
		</style>
		<script language="Javascript">
			jQuery(document).ready(function(){			
				function init(){

					$('#cropbox').Jcrop({
						aspectRatio: 1,
						onSelect: updateCoords,
						onChange: updateCoords
					});

				};

				function updateCoords(c)
				{
					$('#x').val(c.x);
					$('#y').val(c.y);
					$('#w').val(c.w);
					$('#h').val(c.h);
					
					if (parseInt(c.w) > 0)
					{
						var rx = 100 / c.w;
						var ry = 100 / c.h;
	
						jQuery('#preview').css({
							width: Math.round(rx * 500) + 'px',
							height: Math.round(ry * 370) + 'px',
							marginLeft: '-' + Math.round(rx * c.x) + 'px',
							marginTop: '-' + Math.round(ry * c.y) + 'px'
						});
					}
				};

				function checkCoords()
				{
					if (parseInt($('#w').val())) return true;
					alert('Please select a crop region then press submit.');
					return false;
				};
				
				init();
			});
		</script>

	</head>

	<body>

	<div id="outer">
	<div class="jcExample">
	<div class="article">

		<h1>Jcrop - Crop Behavior</h1>

		<!-- This is the image we're attaching Jcrop to -->
		<img src="demo_files/flowers.jpg" id="cropbox" />

		<!-- This is the form that our event handler fills -->
		<form action="crop.php" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="submit" value="Crop Image" />
		</form>

		<p>
			<b>An example server-side crop script.</b> Hidden form values
			are set when a selection is made. If you press the <i>Crop Image</i>
			button, the form will be submitted and a 150x150 thumbnail will be
			dumped to the browser. Try it!
		</p>
		<div style="width:100px;height:100px;overflow:hidden;">
			<img src="demo_files/flowers.jpg" id="preview" />
		</div>
		<div id="dl_links">
			<a href="http://deepliquid.com/content/Jcrop.html">Jcrop Home</a> |
			<a href="http://deepliquid.com/content/Jcrop_Manual.html">Manual (Docs)</a>
		</div>


	</div>
	</div>
	</div>
	</body>

</html>
