
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
preg_match_all('|<tr bgcolor="#.*?" valign="top"><td align="right"><font face="Arial, Helvetica, sans-serif" size="-1"><b>(.*?)\.</b></font></td><td align="center"><font face="Arial, Helvetica, sans-serif" size="-1">.*?</font></td><td><font face="Arial, Helvetica, sans-serif" size="-1"><a href="(.*?)">.*?</a> \(.*?\)</font></td><td align="right"><font face="Arial, Helvetica, sans-serif" size="-1">.*?</font></td></tr>|', $html, $arr);
foreach ($arr[1] as $key => $val) {
    scraperwiki::save_sqlite([
        'rank'
    ], [
        'rank' => "" . clean($arr[1][$key]),
        'imdb_id' => clean($arr[2][$key])
    ]);
    echo "rank: " . clean($arr[1][$key]);
    echo "id: " .clean($arr[2][$key]);
}
 print_r($movies);
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
function oneline($code)
{
    $code = str_replace("\n", '', $code);
    $code = str_replace("\r", '', $code);
    return $code;
}
?>
