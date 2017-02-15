<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Gintagshelper extends CI_Controller {


	public function __construct(){
		parent::__construct();
		$this->load->model('gintags_helper_model');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
	}

	public function initialize() {
        //Create a DB Connection
        $host = "localhost";
        $usr = "root";
        $pwd = "senslope";
        $dbname = "senslopedb";

        $this->dbconn = new \mysqli($host, $usr, $pwd);
        $this->createGintagsTable();
        $this->createGintagsReferenceTable();
	}

	public function createGintagsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `gintags` (
				  `gintags_id` int(11) NOT NULL,
				  `tag_id` int(11) NOT NULL,
				  `tagger` int(10) unsigned NOT NULL,
				  `remarks` varchar(200) DEFAULT NULL,
				  `database` varchar(45) DEFAULT NULL,
				  `timestamp` varchar(45) DEFAULT NULL,
				  PRIMARY KEY (`gintags_id`),
				  KEY `tag_id_idx` (`tag_id`),
				  KEY `tagger_idx` (`tagger`),
				  CONSTRAINT `tag_id` FOREIGN KEY (`tag_id`) REFERENCES `gintags_reference` (`tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
				  CONSTRAINT `tagger` FOREIGN KEY (`tagger`) REFERENCES `dewslcontacts` (`eid`) ON DELETE NO ACTION ON UPDATE NO ACTION
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        if ($this->dbconn->query($sql) === TRUE) {
            echo "Table 'gintags' exists!\n";
        } else {
            die("Error creating table 'gintags': " . $this->dbconn->error);
        }
	}

	public function createGintagsReferenceTable() {
        $sql = "CREATE TABLE IF NOT EXISTS `gintags_reference` (
				  `tag_id` int(11) NOT NULL AUTO_INCREMENT,
				  `tag_name` varchar(200) NOT NULL,
				  `tag_description` longtext,
				  PRIMARY KEY (`tag_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8";

        if ($this->dbconn->query($sql) === TRUE) {
            echo "Table 'gintags_reference' exists!\n";
        } else {
            die("Error creating table 'gintags_reference': " . $this->dbconn->error);
        }
	}

	public function ginTagsEntry(){
		$gintags = json_decode($_POST['gintags']);
		$data['tag_name'] = $gintags->tag_name;
		$data['tag_description'] = $gintags->tag_description;
		$data['timestamp'] = $gintags->timestamp;
		$data['tagger'] = $gintags->tagger;
		$data['remarks'] = $gintags->remarks;
		$data['table_used'] = $gintags->table_used;
		$result = $this->gintags_helper_model->insertGinTagEntry($data);
	}

	public function getGinTags(){
		if (isset($_POST['gintags']) && !empty($_POST["gintags"])) {
			$gintags = json_decode($_POST['gintags']);
		} else {
			$gintags = null;
		}
		$result = $this->gintags_helper_model->fetchGinTags($gintags);
		print json_encode($result);
	}
}