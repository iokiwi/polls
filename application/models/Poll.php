<?php
/*
 * Declare the Category class, representing a row of the Categories table.
 *
 * Implements only the Read function, since we're just implementing a product
 * browser, plus a listAll function that returns a map from productID to
 * productName for all products in the database.
 *
 * This class uses CodeIgniter's
 */
class Poll extends CI_Model {

    public $id;
    public $title;
    public $question;
    public $choices;

    public function __construct() {
        $this->load->database();
    }

    public function pollChoiceExists($pollId, $choiceNo) {
        $query = $this->db->get_where('PollChoices', array(
            'pollId' => $pollId,
            'choiceNo' => $choiceNo
        ));
        if ($query->num_rows() !== 1) {
            throw new Exception("Poll Choice $choiceNo for Poll $pollId not found in database");
        }
    }

    public function pollExists($pollId) {
        $query = $this->db->get_where('Polls', array('id' => $pollId));
        if ($query->num_rows() !== 1) {
            throw new Exception("Poll ID $pollId not found in database");
        }
        return true;
    }

    public function countVotes($pollId, $choiceNo) {
        return $this->db
            ->where(array(
                'pollId' => $pollId,
                'choiceNo' => $choiceNo))
            ->count_all_results('Votes');
    }

    public function getAllPolls() {
        $rows = $this->db->get('Polls')->result();
        $list = array();
        foreach ($rows as $row) {
            $poll = new Poll();
            $poll->load($row);
            $list[] = $row;
        }
        return $list;
    }

    public function read($pollId) {
        $poll = new Poll();
        $query = $this->db
            ->get_where('Polls', array('id' => $pollId));
        if($query->num_rows() !== 1) {
            throw new Exception("Poll ID $pollId not found in database");
        }
        $rows = $query->result();
        $poll->load($rows[0]);
        return $poll;
    }

    public function saveVote($pollId, $choiceNo, $ip) {
        $data = array(
            'pollId' => $pollId,
            'choiceNo' => $choiceNo,
            'ipAddress' => $ip
        );    
        $this->db->insert('Votes', $data);
    }

    public function getChoices($pollId) {
        $query = $this->db
            ->order_by('choiceNo', 'asc')
            ->get_where('PollChoices', array('pollId' => $pollId));
        $rows = $query->result();
        $choices = array();
        foreach ($rows as $choice) {
            $choices[$choice->choiceNo] = $choice->choiceText;
        }
        return $choices;
    }

    public function reset($pollId) {
        $this->db->delete('Votes', array('pollId' => $pollId));
    }

    private function load($row) {
        foreach ((array) $row as $field => $value) {
            $fieldName = strtolower($field[0]) . substr($field, 1);
            $this->$fieldName = $value;
        }
    }
};
