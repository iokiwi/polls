<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Services extends CI_Controller {

    /**
    */
    public function listPolls()	{
        $this->load->model('poll');
        $data = json_encode($this->poll->getAllPolls());
        $this->output
            ->set_content_type('application/json')
            ->set_output($data);
	}

    /** Gets all of the information for a poll
    */
    public function getPoll($pollId) {
        $this->load->model('poll');
        try {
            $poll = $this->poll->read($pollId);
            $choices = $this->poll->getChoices($pollId);
            $choice_array = array();
            foreach ($choices as $choiceNo => $choiceText) {
                $choice_array[] = $choiceText;
            }
            $poll->choices = $choice_array;
            $data = json_encode($poll);
            $this->output
                ->set_content_type('application/json')
                ->set_output($data);
        } catch (Exception $e) {
            $this->output->set_status_header(404, "Not Found");
        }
    }

    // Shows a vote count for a given poll
    public function countPollVotes($pollId) {
        $this->load->model('poll');
        try {
            $this->poll->pollExists($pollId);
            $choices = $this->poll->getChoices($pollId);
            $count = array();
            foreach ($choices as $choiceNo => $choiceText) {
                $count[] = $this->poll->countVotes($pollId, $choiceNo);
            }
            $out = array ('votes' => $count);
            $data = json_encode($out);
            $this->output
                ->set_content_type('application/json')
                ->set_output($data);
        } catch (Exception $e) {
            $this->output->set_status_header(404, "Not Found");
        }
    }

    // Record a poll vote
    public function recordPollVote($pollId, $choiceNo) {
        $this->load->model('poll');
        try {
            $this->poll->pollExists($pollId);
            $this->poll->pollChoiceExists($pollId, $choiceNo);
            $this->poll->saveVote($pollId, $choiceNo, $this->input->ip_address());
        } catch (Exception $e) {
            $this->output->set_status_header(404, "Not Found");
        }
    }

    // Delete all of the votes for a given poll
    public function resetPoll($pollId) {
        $this->load->model('poll');
        try {
            $this->poll->pollExists($pollId);
            $this->poll->reset($pollId);
        } catch (Exception $e) {
            $this->output->set_status_header(404, "Not Found");
        }
    }

}
