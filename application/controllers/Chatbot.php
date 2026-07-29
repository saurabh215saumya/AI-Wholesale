<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chatbot extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('email');
        $this->load->helper('url');
        $this->load->model('Product_model');
    }

    // ── Contact form submission ───────────────────────────────────────────
    public function submit() {
        $response = array('status' => 0, 'message' => '');
        $name    = trim($this->input->post('name'));
        $email   = trim($this->input->post('email'));
        $phone   = trim($this->input->post('phone'));
        $message = trim($this->input->post('message'));
        $errors  = array();
        if (empty($name))    $errors[] = 'Name is required.';
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Valid email is required.';
        if (empty($message)) $errors[] = 'Message is required.';
        if (!empty($errors)) { $response['message'] = implode(' ', $errors); echo json_encode($response); return; }
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

    // ── AI Chatbot AJAX endpoint ──────────────────────────────────────────
    public function ask() {
        header('Content-Type: application/json');
        $msg  = trim($this->input->post('message'));
        $low  = strtolower($msg);
        $reply = $this->_getReply($low, $msg);
        echo json_encode(array('reply' => $reply));
    }

    private function _getReply($low, $original) {
        // Greetings
        if (preg_match('/^(hi|hello|hey|good\s*(morning|afternoon|evening)|howdy)/', $low)) {
            return "👋 Hello! Welcome to " . SITE_NAME . ". I can help you find products, check prices, browse categories, or answer questions about ordering. What are you looking for?";
        }

        // Goodbye
        if (preg_match('/\b(bye|goodbye|see you|thanks|thank you)\b/', $low)) {
            return "😊 Thanks for visiting " . SITE_NAME . "! Feel free to chat anytime. Have a great day!";
        }

        // Cart / checkout
        if (preg_match('/\b(cart|basket|checkout|order|buy|purchase)\b/', $low)) {
            return "🛒 You can view your cart <a href='" . base_url('cart-list') . "' target='_blank'>here</a> and proceed to <a href='" . base_url('checkout') . "' target='_blank'>checkout</a>. Need help with a specific product?";
        }

        // Shipping / delivery
        if (preg_match('/\b(ship|deliver|delivery|dispatch|postage|freight)\b/', $low)) {
            return "🚚 We deliver across the UK. For delivery times and charges, please <a href='" . base_url('contact-us') . "' target='_blank'>contact us</a> or call <strong>07414 560342</strong>.";
        }

        // Returns / refunds
        if (preg_match('/\b(return|refund|exchange|cancel)\b/', $low)) {
            return "↩️ For returns and refunds, please review our <a href='" . base_url('terms-conditions') . "' target='_blank'>Terms &amp; Conditions</a> or <a href='" . base_url('contact-us') . "' target='_blank'>contact us</a> directly.";
        }

        // Wholesale
        if (preg_match('/\b(wholesale|bulk|trade|business|account)\b/', $low)) {
            return "🏭 We offer wholesale pricing for registered business accounts. <a href='" . base_url('wholesale') . "' target='_blank'>Apply for a wholesale account</a> to unlock trade prices!";
        }

        // Contact / phone
        if (preg_match('/\b(contact|phone|call|email|reach|support|help)\b/', $low)) {
            return "📞 You can reach us at <strong>07414 560342</strong> (Mon–Sat, 9AM–8PM) or email <strong>" . ADMIN_EMAIL . "</strong>. <a href='" . base_url('contact-us') . "' target='_blank'>Contact page</a>";
        }

        // Categories listing
        if (preg_match('/\b(categor|department|section|range|type)\b/', $low)) {
            $cats = getAllCategory();
            if (empty($cats)) return "Browse all our products <a href='" . base_url('all-products') . "' target='_blank'>here</a>.";
            $links = array();
            foreach ($cats as $c) {
                $links[] = "<a href='" . base_url('categories/' . $c->category_slug) . "' target='_blank'>" . htmlspecialchars($c->category_name) . "</a>";
            }
            return "📂 Here are our categories:<br>" . implode(' &bull; ', $links);
        }

        // Price enquiry without product name
        if (preg_match('/\b(price|cost|how much|pricing|cheap|afford)\b/', $low) && strlen($low) < 20) {
            return "💰 Prices vary by product. Tell me what you're looking for and I'll find it for you! Or <a href='" . base_url('all-products') . "' target='_blank'>browse all products</a>.";
        }

        // Product search — extract meaningful keywords
        $stopWords = array('what','is','the','price','of','do','you','have','any','show','me','find','looking','for','want','need','buy','get','a','an','tell','about','can','i','are','there','products','product','item','items','stock','sell','selling','available');
        $words = preg_split('/\s+/', $low);
        $keywords = array_filter($words, function($w) use ($stopWords) {
            return strlen($w) > 2 && !in_array($w, $stopWords);
        });

        if (!empty($keywords)) {
            $results = $this->_searchProducts(array_values($keywords));
            if (!empty($results)) {
                $html = "🔍 I found these products for <em>" . htmlspecialchars($original) . "</em>:<br><br>";
                foreach (array_slice($results, 0, 5) as $p) {
                    $price = $p['price'] > 0 ? CURRENCY_SYMBOL . number_format($p['price'], 2) : '';
                    $img   = getProductImage($p['image']);
                    $url   = base_url('product-details/' . $p['product_slug']);
                    $html .= "<div class='cb-product-card'>";
                    $html .= "<img src='" . $img . "' alt='" . htmlspecialchars($p['product_name']) . "'>";
                    $html .= "<div class='cb-product-info'>";
                    $html .= "<a href='" . $url . "' target='_blank'>" . htmlspecialchars($p['product_name']) . "</a>";
                    if ($price) $html .= "<span class='cb-price'>" . $price . "</span>";
                    $html .= "</div></div>";
                }
                if (count($results) > 5) {
                    $html .= "<br><a href='" . base_url('all-products') . "' target='_blank'>View all results &rarr;</a>";
                }
                return $html;
            }
            // Try category match
            $catMatch = $this->_searchCategory(array_values($keywords));
            if ($catMatch) {
                return "📂 I found a category matching your search: <a href='" . base_url('categories/' . $catMatch->category_slug) . "' target='_blank'>" . htmlspecialchars($catMatch->category_name) . "</a>. Would you like to browse it?";
            }
        }

        // Fallback
        return "🤔 I'm not sure about that. You can <a href='" . base_url('all-products') . "' target='_blank'>browse all products</a>, or <a href='" . base_url('contact-us') . "' target='_blank'>contact us</a> for help. Try asking me something like: <em>\"Do you have rolling papers?\"</em>";
    }

    private function _searchProducts($keywords) {
        $this->db->where('is_deleted', '0')->where('status', '1');
        $this->db->group_start();
        foreach ($keywords as $kw) {
            $this->db->or_like('product_name', $kw);
            $this->db->or_like('description', $kw);
        }
        $this->db->group_end();
        return $this->db->order_by('id', 'DESC')->limit(10)->get('tbl_products')->result_array();
    }

    private function _searchCategory($keywords) {
        $this->db->where('is_deleted', '0')->where('status', '1');
        $this->db->group_start();
        foreach ($keywords as $kw) {
            $this->db->or_like('category_name', $kw);
        }
        $this->db->group_end();
        return $this->db->limit(1)->get('tbl_category')->row();
    }
}
