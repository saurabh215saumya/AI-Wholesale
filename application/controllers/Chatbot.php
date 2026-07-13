<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper('url');
    }

    /**
     * Handle chat contact form submission (AJAX)
     */
    public function submit() {
        $response = ['status' => 0, 'message' => ''];

        $name    = trim($this->input->post('name'));
        $email   = trim($this->input->post('email'));
        $phone   = trim($this->input->post('phone'));
        $message = trim($this->input->post('message'));

        $errors = [];
        if (empty($name))    $errors[] = 'Name is required.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
        if (empty($message)) $errors[] = 'Message is required.';

        if (!empty($errors)) {
            $response['message'] = implode(' ', $errors);
            echo json_encode($response);
            return;
        }

        // Send email notification
        $this->email->from($email, $name);
        $this->email->to(ADMIN_EMAIL);
        $this->email->subject('New Chat Enquiry from ' . $name);
        $body  = "<p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>";
        $body .= "<p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>";
        $body .= "<p><strong>Phone:</strong> " . htmlspecialchars($phone) . "</p>";
        $body .= "<p><strong>Message:</strong> " . nl2br(htmlspecialchars($message)) . "</p>";
        $this->email->message($body);
        $this->email->send();

        $response['status']  = 1;
        $response['message'] = 'Thank you! We will get back to you soon.';
        echo json_encode($response);
    }
}
