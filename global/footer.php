<?php
date_default_timezone_set('America/Chicago');
if(preg_match("/staff/i", $_SERVER["PHP_SELF"]))
{
	$xml = simplexml_load_file("../svninfo/svninfo.xml");
}
else
{
	$xml = simplexml_load_file("./svninfo/svninfo.xml");
}
$revision = $xml->entry->commit->attributes();

$rev_number = preg_replace('/^(.{1})(.{2})$/', '$1.$2', $revision);
echo "Next Generation Gaming CP&trade; <a href='http://127.0.0.1/cp//global/changelog.php'><span style='color:silver'>v".$rev_number."</span></a><br />&copy;2010-".date('Y')." Next Generation Gaming, LLC.<br />Current Server Time: ".date('m/d/Y - g:iA');
?>