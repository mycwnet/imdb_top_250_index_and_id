
<?php
require 'scraperwiki.php';
require 'scraperwiki/simple_html_dom.php';
######################################
#  Scrapes top 250 movies from imdb
#  Outputs rank and id
#  Scraper wiki seems broken, the save function doesn't
#  seem to honor unique keys.
######################################
$html = scraperwiki::scrape("http://www.imdb.com/chart/top");

$dom = new simple_html_dom();
$dom->load($html);

$movies=$dom->find('.titleColumn');
foreach($dom->find('td.titleColumn') as $movie) {

   preg_match('#.*?([1-9][0-9]{0,2})\..*?<a.*?\/title\/(.+?)\/.*#', $movie->innertext, $match);
  scraperwiki::save_sqlite(['rank','imdb_id'],['rank'=>$match[1],'imdb_id'=>$match[2]]);
}
?>
