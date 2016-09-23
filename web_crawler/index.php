<?php
function crawler($url,$depth)
{
	if($depth<=0)
	{
		return;
	}

	$doc = new DOMDocument();
	$doc->loadHTMLfile($url);
	echo "<ul>";
	$titles= $doc->getElementsByTagName('title');
	foreach ($titles as $title) {
		echo "<li>".$title->textContent."</li>";
	}
	$images=$doc->getElementsByTagName('img');
	foreach ($images as $image) {
		$img=$image->getAttribute('src');
		echo "<li><img src='".$img."'/></li>";	
	}
	$tags= $doc->getElementsByTagName('a');
	foreach ($tags as $tag ) {
		$link= $tag->getAttribute('href');
		echo "<li>".$link."</li>";
		
	}
	foreach ($tags as $tag) {
		$link= $tag->getAttribute('href');
		$depth=$depth-1;
		echo "<li>".$link."</li>";
		crawler($link,$depth);
	}
	echo "</ul>";
}
crawler("first.html",5);
?> 
