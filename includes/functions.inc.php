<?php
    //this function creates links to rss feeds
    function rssfeed_links($items_array) {
        $rsslinks = "";
        for ($item = 0; $item < count($items_array); $item++) {
            $item_name = $items_array[$item];
            $item_name_url = urlencode($item_name);

            $rsslinks .= "<p>
                            <a href='rssfeed.php?rssLink=$item_name_url' target='_blank'><img src='./images/rssicon.png' alt='$item_name RSS feed'></a>
                            <a href='rssfeed.php?rssLink=$item_name_url' target='_blank'>$item_name</a>
                        </p>";
        }
        return $rsslinks;
    }

    // this function builds navigational page links based on selection, current page, number of pages
    function generate_page_links($selection, $cur_page, $num_pages) {
        $links = "";

        // if this page is not first page, generate previous "<" link
        if ($cur_page > 1) {
            $previous_link = $cur_page - 1;
            $links .= "<a href='" . $_SERVER['PHP_SELF'] . "?productline=$selection&page=$previous_link'>&lt;</a>";
        }
        else {
            $links .= "&lt;";
        }
        // loop through pages generating page number links
        for ($link = 1; $link <= $num_pages; $link++) {
            if ($cur_page == $link) {
                $links .= " $link";
            }
            else {
                $links .= "<a href='" . $_SERVER['PHP_SELF'] . "?productline=$selection&page=$link'> $link</a>";
            }
        }
        // if this page is not last page, generate next ">" link
        if ($cur_page < $num_pages) {
            $next_link = $cur_page + 1;
            $links .= "<a href='" . $_SERVER['PHP_SELF'] . "?productline=$selection&page=$next_link'> &gt;</a>";
        }
        else {
            $links .= " &gt;";
        }
        return $links;
    }

    // this function creates data set containing bar names and values
    function fill_graph_array($array) {

        $bar1 = $bar2 = $bar3 = $bar4 = $bar5 = 0;

        foreach ($array as $values) {
            if ($values == 0) {
                $bar1++;
            }
            elseif ($values < 50001) {
                $bar2++;
            }
            elseif ($values < 75001) {
                $bar3++;
            }
            elseif ($values < 100001) {
                $bar4++;
            }
            else {
                $bar5++;
            }
        }

        $filled_chart_array = array( 
            array(" $0", $bar1),
            array(" $1 to $50,000", $bar2),
            array(" $50,001 to $75,000", $bar3),
            array(" $75,001 to $100,000", $bar4),
            array(" Greater than $100,000", $bar5)
        );

        return $filled_chart_array;
    }
    
    // this function calculates maximum y-axis value
    function make_graph_scale($array) {
        
        $scale_max = round((count($array) / 5) + 15);
        
        return $scale_max;
    }

    // this function draws bar graph given width, height, data set, max value, and image filename
    function draw_bar_graph($width, $height, $data, $max_value, $filename) {
        // create empty graph image
        $img = imagecreatetruecolor($width, $height);
        
        // set background, border, bar and text colors
        $bg_color = imagecolorallocate($img, 228, 228, 228); // gray
        $border_color = imagecolorallocate($img, 0, 0, 0); // black
        $bar_color = imagecolorallocate($img, 51, 102, 102); // green
        $text_color = imagecolorallocate($img, 255, 255, 255); // white
        
        // fill graph background
        imagefilledrectangle($img, 0, 0, $width, $height, $bg_color);
        
        // draw graph bars
        $bar_width = $width / ((count($data) * 2) + 1);
        for ($i = 0; $i < count($data); $i++) {
            imagefilledrectangle($img, ($i * $bar_width * 2) + $bar_width, $height,
            ($i * $bar_width * 2) + ($bar_width * 2), $height - (($height / $max_value) * $data[$i][1]), $bar_color);
            imagestringup($img, 5, ($i * $bar_width * 2) + ($bar_width), $height - 5, $data[$i][0], $text_color);
        }
        // draw graph border
        imagerectangle($img, 0, 0, $width - 1, $height - 1, $border_color);
        
        // draw range on left side of graph
        for ($i = 0; $i <= $max_value; $i+=5) {
            imagestring($img, 5, 0, $height - ($i * ($height / $max_value)), $i, $border_color);
        }
        
        // write graph image to a file
        imagepng($img, $filename, 5);
        imagedestroy($img);
    }
?>