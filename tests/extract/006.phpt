--TEST--
extract try-to-extract-with-umask-777.tar
--SKIPIF--
<?php if (!extension_loaded("archive")) print "skip"; ?>
--FILE--
<?php

include_once dirname(__FILE__)."/../unlink_entry.inc";

chdir(dirname(__FILE__));

$ar = new ArchiveReader(dirname(__FILE__)."/../_files/try-to-extract-with-umask-777.tar");

$files = Array();
while ($e = $ar->getNextEntry(false)) {
	var_dump($files [] = $e->getPathname());
	var_dump($ar->extractCurrentEntry());
}

foreach ($files as $file) {
	if (!file_exists(dirname(__FILE__).'/'.$file)) {
		echo $file, " doesn't exist!\n";
	}
}

foreach ($files as $file) {
	$file = realpath($file);
	$file = substr($file, strlen(dirname(__FILE__).'/'));
	unlink_entry(dirname(__FILE__).'/', $file);
}

echo "Done\n";
?>
--EXPECT--
string(59) "usr/local/share/doc/ghostscript/7.06/pcl3/how-to-report.txt"
bool(true)
Done