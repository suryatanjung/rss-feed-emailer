<?php

// Define the URL of the RSS feed
$feed_url = "any good blogger rss feed-url";

// Fetch the content of the RSS feed
$feed_content = get_content($feed_url);  

// Extract and compose the titles and links of the feed items
$composed_content = "";
for ($counter = 0; $counter <= 10; $counter++) {
    // Find the position of the start of each item
    $item_start = strpos($feed_content, "<item>");
    $feed_content = substr($feed_content, $item_start);
    
    // Extract title
    $title_start = strpos($feed_content, '<title>');
    $title_end = strpos($feed_content, '</title>');
    $title = substr($feed_content, $title_start, $title_end);
    
    // Extract link
    $link_start = strpos($feed_content, '<link>');
    $link_end = strpos($feed_content, '</link>');
    $link = substr($feed_content, $link_start, $link_end);
    
    // Concatenate title and link
    $composed_content .= $title . " " . $link . "\n";
    
    // Move to the next item
    $feed_content = substr($feed_content, $link_end + 7);
}

// Send email with the composed content
$sender_name = "Aj"; // Sender's name
$sender_email = "abc@def.com"; // Sender's email
$recipient_email = "ur blogger address@blogger.com"; // Recipient's email
$email_subject = "Some Topic"; // Email subject

// Compose email headers
$email_headers = "From: " . $sender_name . " <" . $sender_email . ">\r\n";

// Send email
mail($recipient_email, $email_subject, $composed_content, $email_headers);

// Custom function to fetch content from a URL
function get_content($url) {  
    $ch = curl_init();  
    curl_setopt($ch, CURLOPT_URL, $url);  
    curl_setopt($ch, CURLOPT_HEADER, 0);  
    ob_start();  
    curl_exec($ch);  
    curl_close($ch);  
    $content = ob_get_contents();  
    ob_end_clean();  
    return $content;      
}

?>
