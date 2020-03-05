<div id="form">
    <form method="post" action="" name="searchsite" id="searchsite">
        <label for="url">Enter URL to Parse</label>
        <input type="text" name="url" id="url" value="http://">
        <input type="submit" value="Go">
    </form>
</div>

<hr>

<div id="results">
	<?php
	
	if ($_POST['url']) {
		
		$site = $_POST['url'];
		$error = "";
		
		// Validate input
		$url = parse_url($site);
		if (!$url['scheme']) { $site = "http://".$site; }
		
		if (substr($site,-4,-3) != ".") { 
			$error = "URL Suffix is invalid.";
		}
		
		if(empty(@file_get_contents($site))) {
			$error .= "<br>Invalid Contents - cannot parse. Please try again with a URL formatted like: http://commarato.com";	
		}
		
		if (!$error) { 	
			
			$sitecontent = file_get_contents($site);
			
			// Instantiate DOMDocument and load the contents
			$content = new DOMDocument;
			@$content->loadHTML($sitecontent);
			
			$links = $content->getElementsByTagName("a");
			foreach ($links AS $linkdata) {
				$outlink = str_replace($site,"",$linkdata->getAttribute("href"));
				if ((!empty($outlink)) && (!empty($linkdata->nodeValue))) { 
					echo $linkdata->nodeValue." [{$outlink}]<br>"; 
				}
			}
		} else {
			echo $error;
		}
	}
	?>
</div>