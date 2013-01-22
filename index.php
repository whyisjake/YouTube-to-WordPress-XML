<?php

// Change the names of categories be dashed, rather then have spaces.
function make_dashed($str) {
	$dashed = str_replace(' ', '-', $str );
	return $dashed;
}


// GLobals //

$GLOBALS['t'] = '$t';
$GLOBALS['playlist'] = $videosobj->feed->title->$t;

// Add a query parameter for playlists.
$limit = (!empty($_REQUEST['offset']) ? $_REQUEST['offset'] : null);
//Username
$username = (!empty($_REQUEST['username']) ? $_REQUEST['username'] : null);
//Username
$start = (!empty($_REQUEST['start']) ? $_REQUEST['start'] : null);

//Path to the WordPress files.
require('../wp-load.php');

function make_get_the_playlist_feed() {

	// Get the the playlist that we are going to generate the feed for.
	// This is offset so that only one is fetched at a time.
	// Using the offset query param, you can go down the list to generate one file for each playlist.
	$file = 'http://gdata.youtube.com/feeds/api/users/' . $username . '/playlists?max-results=1&alt=json&offset=1&start-index=' . $limit;
	$contents = file_get_contents($file);
	$playlists = json_decode($contents);
	$feedlink = 'gd$feedLink';
	$videos = $playlists->feed->entry[0]->$feedlink;
	$url = $videos[0]->href . '?alt=json&max-results=50&start-index=' . $start;
	$contents = file_get_contents($url);
	$videosobj = json_decode($contents);
	$videos = $videosobj->feed->entry;
}

//Spit out the header with the correct content type.
header("Content-type: text/xml; charset=utf-8");

// I have this echoed out first, I was getting XML errors for having it below.
echo '<?xml version="1.0" encoding="UTF-8" ?>';

?>
<rss version="2.0"
	xmlns:excerpt="http://wordpress.org/export/1.2/excerpt/"
	xmlns:content="http://purl.org/rss/1.0/modules/content/"
	xmlns:wfw="http://wellformedweb.org/CommentAPI/"
	xmlns:dc="http://purl.org/dc/elements/1.1/"
	xmlns:wp="http://wordpress.org/export/1.2/"
>

<channel>
	<title>MAKE</title>
	<link>http://localhost:8888</link>
	<description>DIY projects, how-tos, and inspiration from the workshops and minds of geeks, makers, and hackers @ Make: magazine</description>
	<pubDate>Wed, 28 Nov 2012 18:12:25 +0000</pubDate>
	<language>en-US</language>
	<wp:wxr_version>1.2</wp:wxr_version>
	<wp:base_site_url>http://localhost:8888</wp:base_site_url>
	<wp:base_blog_url>http://localhost:8888</wp:base_blog_url>
	<wp:wxr_version>1.2</wp:wxr_version>
	<generator>https://github.com/whyisjake/YouTube-to-WordPress-XML</generator>

<?php 
	foreach ( $videos as $video ) {
		$t = '$t';
		$link = $video->link;
		echo "\t" . '<item>' . "\n";
		echo "\t\t" . '<title>' . ent2ncr( esc_html( $video->title->$t ) ) . '</title>' . "\n";
		echo "\t\t" . '<pubDate>' . $video->published->$t . '</pubDate>' . "\n";
		echo "\t\t" . '<dc:creator>makemagazine</dc:creator>' . "\n";
		echo "\t\t" . '<description></description>' . "\n";
		echo "\t\t" . '<content:encoded><![CDATA[[youtube="' . $link[0]->href . '"]' . "\n" . $video->content->$t . ']]></content:encoded>' . "\n";
		echo "\t\t" . '<excerpt:encoded><![CDATA[' . $video->content->$t . ']]></excerpt:encoded>' . "\n";
		echo "\t\t" . '<wp:post_id>' . mt_rand(0, 2000) . '</wp:post_id>' . "\n";
		echo "\t\t" . '<wp:post_date>' . $video->published->$t . '</wp:post_date>' . "\n";
		echo "\t\t" . '<wp:comment_status>open</wp:comment_status>' . "\n";
		echo "\t\t" . '<wp:ping_status>open</wp:ping_status>' . "\n";
		echo "\t\t" . '<wp:post_name>' . ent2ncr( esc_html( $video->title->$t ) ) . '</wp:post_name>' . "\n";
		echo "\t\t" . '<wp:status>publish</wp:status>' . "\n";
		echo "\t\t" . '<wp:post_type>video</wp:post_type>' . "\n";
		echo "\t\t" . '<wp:post_parent>0</wp:post_parent>' . "\n";
		echo "\t\t" . '<wp:menu_order>0</wp:menu_order>' . "\n";
		echo "\t\t" . '<wp:post_type>post</wp:post_type>' . "\n";
		echo "\t\t" . '<wp:post_password></wp:post_password>' . "\n";
		echo "\t\t" . '<wp:is_sticky>0</wp:is_sticky>' . "\n";
		echo "\t\t" . '<category domain="category" nicename="science-technology"><![CDATA[Science &amp; Technology]]></category>' . "\n";
		echo "\t\t" . '<category domain="playlist" nicename="' . make_dashed( $playlist ) . '"><![CDATA[' . $playlist . ']]></category>' . "\n";
		echo "\t" . '</item>' . "\n";
  	}
 ?>
		
</channel>
</rss>
