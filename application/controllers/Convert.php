<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Convert extends CI_Controller {
	public function index() {
		if (is_cli()) {
			$directory = dir("/var/www/simple/");

			while (($filename = $directory->read()) !== FALSE) {
				$ID = substr($filename, 0, strrpos($filename, '_'));
				if ($ID) {
					$this->png2jpg("/var/www/simple/{$ID}_simple.png", "/var/www/simple/{$ID}_simple.jpg", 100);
					echo($ID . "\n");
				}
			}
			$directory->close();
		}
	}

	private function png2jpg($src, $dest, $quality) {
	    $img = imagecreatefrompng($src);
	    imagejpeg($img, $dest, $quality);
	    imagedestroy($img);
	}
}
