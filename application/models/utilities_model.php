<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Includes the User_Model class as well as the required sub-classes
 * @package codeigniter.application.models
 */

/**
 * User_Model extends codeigniters base CI_Model to inherit all codeigniter magic!
 * @author Leon Revill
 * @package codeigniter.application.models
 */

class Utilities_model extends CI_Model {

	public function insertCPULog($data) {
        $status = "";
        $log_description_query = "INSERT INTO error_log_description VALUES (0,(SELECT id FROM error_log_modules WHERE module_code = 'CTBX'),'".$data['timestamp']."','".$data['error_description']."');";
        		$result = $this->db->query($log_description_query);
        if ($result === TRUE) {
           $log_query = "INSERT INTO error_logs VALUES (0,(SELECT id FROM error_log_modules WHERE module_code = 'CTBX'),(SELECT id FROM error_log_description WHERE timestamp = '".$data['timestamp']."'))";
           $result = $this->db->query($log_query);
           if ($result === TRUE) {
                $status = "Error log entry successfully added..\n";
           } else {
                $status = "Failed to add Error log entry..\n";
           }
        } else {
            $status = "Failed to add new error log: " . $this->dbconn->error." \n";
        }
        return $status;
	}

  public function getVersion() {
    $version = "SELECT version FROM web_version";
    $result = $this->db->query($version);
    return $result->result();
  }

  public function updateVersion($version) {
    $version = "UPDATE web_version SET version = '".$version."'";
    $result = $this->db->query($version);
    return $result();
  }
}
