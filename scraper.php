
<?php
require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';
######################################
#  Scrapes top 250 movies from imdb
#  Outputs rank and id
######################################
$html = scraperwiki::scrape("http://www.imdb.com/chart/top");

$dom = new simple_html_dom();
$dom->load($html);

$movies=$dom->find('.titleColumn');
$movies_list=[];
foreach($dom->find('td.titleColumn') as $movie) {

   preg_match('#.*?([1-9][0-9]{0,2})\..*?<a.*?\/title\/(.+?)\/.*#', $movie->innertext, $match);
  $movies_list[]=['rank'=>$match[1],'imdb_id'=>$match[2]];
}
print_r($movies_list);
 scraperwiki::save_sqlite(['rank','imdb_id'],$movies_list);
?>
