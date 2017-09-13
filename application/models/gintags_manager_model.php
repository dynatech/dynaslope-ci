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
class Gintags_manager_model extends CI_Model {

	public function insertGintagNarrative($data) {
		$status = false;
		try {
			$query = "SELECT * FROM gintags_reference WHERE tag_name='".$data['tag']."'";
			$result = $this->db->query($query);
			
			if ($result->num_rows > 0) {
				foreach ($result->result() as $row) {
					$gintag_narrative = "INSERT INTO gintags_manager VALUES(0,'".$row->tag_id."','".$data['tag_description']."','".$data['narrative_input']."')";
					$gn_result = $this->db->query($gintag_narrative);
				}
				$status = $gn_result;
			} else {
				$new_tag = "INSERT INTO gintags_reference VALUES (0,'".$data['tag']."','communications')";
				$nt_result = $this->db->query($new_tag);

				$get_last_id = "SELECT LAST_INSERT_ID() as id;";
				$glid_result = $this->db->query($get_last_id);

				if ($nt_result == true) {
					$gintag_narrative = "INSERT INTO gintags_manager VALUES(0,'".$glid_result->result()[0]->id."','".$data['tag_description']."','".$data['narrative_input']."')";
					$gn_result = $this->db->query($gintag_narrative);
					$status = $gn_result;
				}
			}
			return $status;
		} catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function getAllTags() {
		$query = "SELECT tag_name FROM gintags_reference";
		$result = $this->db->query($query);
		return $result->result();
	}

	public function getAllGintagsNarrative() {
		$query = "SELECT gintags_manager.id,gintags_reference.tag_name,gintags_manager.description,gintags_manager.narrative_input FROM senslopedb.gintags_manager INNER JOIN gintags_reference ON gintags_manager.tag_id_fk = gintags_reference.tag_id;";
		$result = $this->db->query($query);
		return $result->result();
	}
}

?>