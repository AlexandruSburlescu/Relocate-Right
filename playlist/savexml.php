<?php

session_start();

require 'database.php';
$user = NULL;
$allsongs = simplexml_load_file("xmlPlaylist.xml"); 	

if( isset($_SESSION['user_id']) ){
	//if the sesion is set then select the users id
	$sql1 = 'SELECT memberID,name FROM users WHERE memberID = :id';
	$records = $conn->prepare($sql1);
	$records->bindParam(':id', $_SESSION['user_id']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);

	

	if( count($results) > 0){
		$user = $results;
	}
	//display only the songs that the current user has saved in the database
	
	$sql2 = 'SELECT saved_songs.* FROM saved_songs LEFT JOIN members ON saved_songs.memberID = :id AND saved_songs.songID = :songID';	
	$rec = $conn->prepare($sql2);
	$rec->bindParam(':songID', $song->songid);
	$rec->bindParam(':id', $_SESSION['user_id']);
	$rec->execute();
	$res = $rec->fetchAll(PDO::FETCH_ASSOC);
	$songs = $res;
	
	$fileName = "exported_playlist.xml";
	$filePointer = fopen($fileName, "w");
	fwrite( $filePointer, "<?xml version=\"1.0\" encoding=\"ISO-8859-1\"?>\n" );
	fwrite( $filePointer, "<rss version=\"0.91\">\n");
	fwrite( $filePointer, "<channel>\n");

	foreach ($songs as $item){ 
			fwrite( $filePointer, "\t<item>\n>");
			fwrite( $filePointer,"\t\t<songid>".$item['songID']."</songid>\n"); 
		    fwrite( $filePointer,"\t\t<songtitle>".$item['songtitle']."</songtitle>\n");
		    fwrite( $filePointer,"\t\t<artist>".$item['artist']."</artist>\n"); 
			fwrite( $filePointer,"\t\t<genre>".$item['genre']."</genre>\n");
			fwrite( $filePointer,"\t\t<link>".$item['link']."</link>\n");
			fwrite( $filePointer,"\t\t<releaseyear>".$item['releaseYear']."</releaseyear>\n"); 
			fwrite( $filePointer, "\t</item>\n>");			
	}
fwrite( $filePointer, "</channel>\n");
fwrite( $filePointer, "</rss>\n");
fclose( $filePointer );
}
header("Location: playlist.php");
?>     