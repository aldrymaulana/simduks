<?php
function htmlout($text)
{
    echo html($text);
}

function html($text)
{
    return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="end">
<head>
	<title>Terjadi Kesalahan</title>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
</head>
<body>
	<h1>Terjadi Kesalahan</h1>
	<p class="error"><?php htmlout($error); ?></p>
        <p class="link"><a href="<?php echo($back_link);?>">Kembali</a></p>
</body>
</html>
