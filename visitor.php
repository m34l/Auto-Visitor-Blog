<?php
/**
 *
 * @source Auto Visitor Blog / Website
 * @author Ismail Muhammad Zeindy
 * @link https://m34lnetwork.co.id/
 * @copyright 2023
 * 
 **/

$cyan = "\e[96m";

echo "$cyan + //////////////////////////////+\n";

echo ' Website Anda  : ';
$url = trim(fgets(STDIN));
echo ' Jumlah Visitor  : ';
$max = trim(fgets(STDIN));


for ($i = 1; $i < $max + 1; $i++) {
    $class = new autovisitor($url);
    $response = $class->jalankan();
    $statusMessage = $response['status'] == 200 ? "Sukses ^_^" : "Gagal :(";

    echo $i . ". " . $statusMessage . " - [" . $response['status'] . "]\n";
}

// error_reporting(0);

class autovisitor {

	public function __construct($url) {
		$this->url = $url;
	}

    public function generateUserAgent() {
        $userAgents = array(
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(90, 99) . '.0.' . rand(1000, 9999) . '.0 Safari/537.36',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Firefox/' . rand(80, 89) . '.0',
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Edge/' . rand(80, 89) . '.0.' . rand(1000, 9999),
            'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:'.rand(80, 89).'.0) Gecko/20100101 Firefox/'.rand(80, 89).'.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/' . rand(90, 99) . '.0.' . rand(1000, 9999) . '.0 Safari/537.36',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/' . rand(13, 15) . '.0 Safari/' . rand(605, 609) . '.1.15',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Firefox/' . rand(80, 89) . '.0',
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Edge/' . rand(80, 89) . '.0.' . rand(1000, 9999),
            'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Safari/' . rand(605, 609) . '.1.15',
        );
    
        return $userAgents[array_rand($userAgents)];
    }
    
	private function curl() {
        $ch = curl_init();
        CURL_SETOPT($ch, CURLOPT_URL, $this->url);
        CURL_SETOPT($ch, CURLOPT_HTTPHEADER, array('User-Agent: '.$this->generateUserAgent()));
        CURL_SETOPT($ch, CURLOPT_FOLLOWLOCATION, true);
        CURL_SETOPT($ch, CURLOPT_SSL_VERIFYHOST, 0);
        CURL_SETOPT($ch, CURLOPT_SSL_VERIFYPEER, 0);
        CURL_SETOPT($ch, CURLOPT_RETURNTRANSFER, 1);
        CURL_SETOPT($ch, CURLOPT_USERAGENT, $this->generateUserAgent());
        $result = curl_exec($ch);
        $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE); // Mendapatkan status HTTP
        curl_close($ch);
    
        return array('status' => $httpStatus, 'response' => $result);
    }


	private function xflush() {
    	static $output_handler = null;
    	if ($output_handler === null) {
        	$output_handler = @ini_get('output_handler');
    	}
    	if ($output_handler == 'ob_gzhandler') {
        	return;
    	}
    	flush();
    	if (function_exists('ob_flush') AND function_exists('ob_get_length') AND ob_get_length() !== false) {
       		@ob_flush();
    	} else if (function_exists('ob_end_flush') AND function_exists('ob_start') AND function_exists('ob_get_length') AND ob_get_length() !== FALSE) {
       		@ob_end_flush();
        	@ob_start();
    	}
	}


	public function jalankan() {
		$this->xflush();
		return $this->curl();
		$this->xflush();
	}

} 

?>
