
<?php
require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';
######################################
# Basic PHP scraper
# Credit to Yukoff this code is forked from their scrapper
# https://github.com/yukoff/imdb-toptv-250
# I couldn't use most of that data an wanted the ID (which that scraper lacked)
# and Rank Only
######################################
$html = scraperwiki::scrape("http://www.imdb.com/chart/top");

$dom = new simple_html_dom();
$dom->load($html);

$movies=$dom->find('.titleColumn');
$ids=[];
foreach($dom->find('td.titleColumn') as $movie) {
   print_r($movie->innertext);

   preg_match('#.*?([1-9][0-9]{0,2})\..*?<a.*?/.*?\/title\/(.+)?\/.*#', $movie->innertext, $match);
    $ids[$match[1]]=$match[2];
}
print_r($ids);

function clean($val)
{
    $val = str_replace('&nbsp;', ' ', $val);
    $val = str_replace('&amp;', '&', $val);
    $val = html_entity_decode($val);
    $val = strip_tags($val);
    $val = trim($val);
    $val = utf8_decode($val);
    return $val;
}
?>
