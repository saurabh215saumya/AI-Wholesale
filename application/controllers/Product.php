<?php
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->table = 'tbl_products';
        $this->load->model('Product_model');
        $this->load->model('Category_model');
        $this->load->model('Home_model');
        $this->load->library('Csvimport');
        $this->controller = $this->router->fetch_class();
    }

    public function index() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['allproducts'] = $this->Product_model->allproducts();
        $data['controller']  = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('product/index', $data);
        $this->load->view('template/admin_footer');
    }

    public function addproduct() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['categoryDataArr']    = getAllRootCategories();
        $data['subCategoryDataArr'] = array();
        $data['controller']         = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('product/add_product', $data);
        $this->load->view('template/admin_footer');
    }

    public function add_newproduct() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|integer');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|max_length[100]');
        // $this->form_validation->set_rules('price', 'Price', 'trim|required|decimal|greater_than_equal_to[0]');
        // $this->form_validation->set_rules('wholesale_price', 'Wholesale Price', 'trim|decimal|greater_than_equal_to[0]');
        // $this->form_validation->set_rules('retailer_price', 'Retailer Price', 'trim|decimal|greater_than_equal_to[0]');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->addproduct();
        } else {
            $name = $this->input->post('product_name');
            $grandSubCatId = (int)$this->input->post('grand_sub_category_id');
            $subCatId      = (int)$this->input->post('sub_category_id');
            $insert = array(
                'category_id'      => $this->input->post('category_id'),
                'sub_cat_id'       => $subCatId,
                'grand_sub_cat_id' => $grandSubCatId,
                'product_name'    => $name,
                'product_code'    => $this->input->post('product_code'),
                'product_slug'    => url_title(strtolower($name), '-'),
                'price'           => $this->input->post('price'),
                // 'wholesale_price' => $this->input->post('wholesale_price'),
                // 'retailer_price'  => $this->input->post('retailer_price'),
                'quantity'        => $this->input->post('quantity'),
                'variant_type'    => $this->input->post('variant_type') ?: 'per_quantity',
                'description'     => $this->input->post('description'),
                'long_description'=> $this->input->post('long_description'),
                'status'          => $this->input->post('status'),
                'addedOn'         => date('Y-m-d H:i:s'),
                'updatedOn'       => date('Y-m-d H:i:s'),
            );
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/products';
            foreach (array('image_file' => 'image', 'image_file_1' => 'image_1', 'image_file_2' => 'image_2', 'image_file_3' => 'image_3', 'image_file_4' => 'image_4') as $key => $field) {
                $img = upload_image($key, $uploads_dir, 800, 800);
                if ($img) $insert[$field] = $img;
            }
            $this->db->insert($this->table, $insert);
            $newId = $this->db->insert_id();
            // Save variants
            $vLabels = $this->input->post('variant_label');
            $vPrices = $this->input->post('variant_price');
            if (!empty($vLabels)) {
                $variants = array();
                foreach ($vLabels as $i => $lbl) {
                    if (empty($lbl)) continue;
                    $variants[] = array('label' => $lbl, 'price' => $vPrices[$i] ?? 0, 'sort_order' => $i);
                }
                $this->Product_model->saveVariants($newId, $variants);
            }
            $this->session->set_flashdata('response', '<div class="alert alert-success">Product added successfully.</div>');
            redirect($this->controller);
        }
    }

    public function edit($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['details']               = $this->Product_model->productDetails($id);
        $data['variants']              = $this->Product_model->getAllVariantsByProduct($id);
        $data['categoryDataArr']       = getAllRootCategories();
        $data['subCategoryDataArr']    = !empty($data['details']['category_id']) ? getCategoryChildren($data['details']['category_id']) : array();
        $data['grandSubCategoryDataArr'] = !empty($data['details']['sub_cat_id']) ? getCategoryChildren($data['details']['sub_cat_id']) : array();
        $data['controller']            = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('product/edit', $data);
        $this->load->view('template/admin_footer');
    }

    public function update_product() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id = $this->input->post('product_id');
        $this->form_validation->set_error_delimiters('<p class="help-block text-danger">', '</p>');
        $this->form_validation->set_rules('category_id', 'Category', 'trim|required|integer');
        $this->form_validation->set_rules('product_name', 'Product Name', 'trim|required|max_length[255]');
        $this->form_validation->set_rules('product_code', 'Product Code', 'trim|required|max_length[100]');
        // $this->form_validation->set_rules('price', 'Price', 'trim|required|decimal|greater_than_equal_to[0]');
        // $this->form_validation->set_rules('wholesale_price', 'Wholesale Price', 'trim|decimal|greater_than_equal_to[0]');
        // $this->form_validation->set_rules('retailer_price', 'Retailer Price', 'trim|decimal|greater_than_equal_to[0]');
        $this->form_validation->set_rules('quantity', 'Quantity', 'trim|integer|greater_than_equal_to[0]');
        $this->form_validation->set_rules('status', 'Status', 'trim|required|in_list[0,1]');
        if ($this->form_validation->run() == FALSE) {
            $this->edit($id);
        } else {
            $name = $this->input->post('product_name');
            $grandSubCatId = (int)$this->input->post('grand_sub_category_id');
            $subCatId      = (int)$this->input->post('sub_category_id');
            $update = array(
                'category_id'      => $this->input->post('category_id'),
                'sub_cat_id'       => $subCatId,
                'grand_sub_cat_id' => $grandSubCatId,
                'product_name'    => $name,
                'product_code'    => $this->input->post('product_code'),
                'product_slug'    => url_title(strtolower($name), '-'),
                'price'           => $this->input->post('price'),
                // 'wholesale_price' => $this->input->post('wholesale_price'),
                // 'retailer_price'  => $this->input->post('retailer_price'),
                'quantity'        => $this->input->post('quantity'),
                'variant_type'    => $this->input->post('variant_type') ?: 'per_quantity',
                'description'     => $this->input->post('description'),
                'long_description'=> $this->input->post('long_description'),
                'status'             => $this->input->post('status'),
                'updatedOn'          => date('Y-m-d H:i:s'),
                'meta_title'         => $this->input->post('meta_title'),
                'meta_description'   => $this->input->post('meta_description'),
                'meta_keywords'      => $this->input->post('meta_keywords'),
                'h1_tag'             => $this->input->post('h1_tag'),
                'h2_tag'             => $this->input->post('h2_tag'),
                'h3_tag'             => $this->input->post('h3_tag'),
                'img_alt_1'          => $this->input->post('img_alt_1'),
                'img_alt_2'          => $this->input->post('img_alt_2'),
                'img_alt_3'          => $this->input->post('img_alt_3'),
                'img_alt_4'          => $this->input->post('img_alt_4'),
                'img_alt_5'          => $this->input->post('img_alt_5'),
                'robots'             => $this->input->post('robots'),
                'revisit_after'      => $this->input->post('revisit_after'),
                'og_locale'          => $this->input->post('og_locale'),
                'og_type'            => $this->input->post('og_type'),
                'og_image'           => $this->input->post('og_image'),
                'og_tag'             => $this->input->post('og_tag'),
                'og_title'           => $this->input->post('og_title'),
                'og_url'             => $this->input->post('og_url'),
                'og_description'     => $this->input->post('og_description'),
                'og_site_name'       => $this->input->post('og_site_name'),
                'author'             => $this->input->post('author'),
                'canonical'          => $this->input->post('canonical'),
                'geo_region'         => $this->input->post('geo_region'),
                'geo_place_name'     => $this->input->post('geo_place_name'),
                'geo_position'       => $this->input->post('geo_position'),
                'icbm'               => $this->input->post('icbm'),
                'subject'            => $this->input->post('subject'),
                'owner'              => $this->input->post('owner'),
                'coverage'           => $this->input->post('coverage'),
                'language'           => $this->input->post('language'),
                'distribution'       => $this->input->post('distribution'),
                'country'            => $this->input->post('country'),
                'geography'          => $this->input->post('geography'),
                'cache_control'      => $this->input->post('cache_control'),
                'instagram'          => $this->input->post('instagram'),
                'twitter_description'=> $this->input->post('twitter_description'),
                'facebook'           => $this->input->post('facebook'),
                'twitter_site'       => $this->input->post('twitter_site'),
                'youtube'            => $this->input->post('youtube'),
            );
            $uploads_dir = dirname($_SERVER['SCRIPT_FILENAME']) . '/uploads/products';
            $imgFields = array(
                'image_file'   => array('field' => 'image',   'old' => 'image_file_name'),
                'image_file_1' => array('field' => 'image_1', 'old' => 'image_file_name_1'),
                'image_file_2' => array('field' => 'image_2', 'old' => 'image_file_name_2'),
                'image_file_3' => array('field' => 'image_3', 'old' => 'image_file_name_3'),
                'image_file_4' => array('field' => 'image_4', 'old' => 'image_file_name_4'),
            );
            foreach ($imgFields as $key => $cfg) {
                $img = upload_image($key, $uploads_dir, 800, 800);
                if ($img) {
                    $update[$cfg['field']] = $img;
                    delete_file($uploads_dir . '/' . $this->input->post($cfg['old']));
                }
            }
            $this->db->where('id', $id)->update($this->table, $update);
            // Save variants
            $vLabels = $this->input->post('variant_label');
            $vPrices = $this->input->post('variant_price');
            $variants = array();
            if (!empty($vLabels)) {
                foreach ($vLabels as $i => $lbl) {
                    if (empty($lbl)) continue;
                    $variants[] = array('label' => $lbl, 'price' => $vPrices[$i] ?? 0, 'sort_order' => $i);
                }
            }
            $this->Product_model->saveVariants($id, $variants);
            $this->session->set_flashdata('response', '<div class="alert alert-success">Product updated successfully.</div>');
            redirect($this->controller);
        }
    }

    public function changestatus() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $id  = $this->input->post('statusid');
        $val = $this->input->post('statusvalue') ? 0 : 1;
        $cn  = $this->input->post('controllername');
        $this->Product_model->changeStatus($id, $val);
        $color = $val ? '#00a65a' : '#ff0000';
        $title = $val ? 'Active' : 'In Active';
        $icon  = $val ? 'fa-check' : 'fa-ban';
        echo "<span statusid=$id statusvalue=$val controllername=$cn style='color:$color;cursor:pointer;' title='$title'><i class='fa fa-2x $icon'></i></span>";
    }

    public function delete($id) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->Product_model->deleteRecord($id);
        redirect($this->controller);
    }

    public function updateflag($id, $type) {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $this->Product_model->updateProductFlag($id, $type);
        redirect($this->controller);
    }

    public function export_packing_list() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['products'] = $this->Product_model->allproducts();
        $data['date']     = date('Y-m-d');
        $this->load->view('product/export_packing_list', $data);
    }

    public function sample_csv() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $file = FCPATH . 'assets/sample_products.csv';
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="sample_products.csv"');
        header('Content-Length: ' . filesize($file));
        readfile($file);
        exit;
    }

    public function upload_bulk_product() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        $data['controller'] = $this->controller;
        $this->load->view('template/admin_header');
        $this->load->view('template/admin_left');
        $this->load->view('product/upload_bulk_product', $data);
        $this->load->view('template/admin_footer');
    }

    public function import_csv() {
        if (!$this->session->userdata('logged_in')) redirect('user/login');
        if (!is_uploaded_file($_FILES['csv_file']['tmp_name'])) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Please select a CSV file.</div>');
            redirect($this->controller . '/upload_bulk_product');
        }
        $ext = strtolower(pathinfo($_FILES['csv_file']['name'], PATHINFO_EXTENSION));
        if ($ext !== 'csv') {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">Only CSV files allowed.</div>');
            redirect($this->controller . '/upload_bulk_product');
        }
        $csvData = $this->csvimport->get_array($_FILES['csv_file']['tmp_name']);
        if (empty($csvData)) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">CSV file is empty.</div>');
            redirect($this->controller . '/upload_bulk_product');
        }
        // Normalise BOM on first header key
        $firstKey = array_keys($csvData[0])[0];
        if (substr($firstKey, 0, 3) === "\xEF\xBB\xBF") {
            foreach ($csvData as &$r) {
                $r['Product'] = $r[$firstKey];
                unset($r[$firstKey]);
            }
            unset($r);
        }
        // Only Product column is required
        if (!array_key_exists('Product', $csvData[0])) {
            $this->session->set_flashdata('response', '<div class="alert alert-danger">CSV must have at least a <strong>Product</strong> column.</div>');
            redirect($this->controller . '/upload_bulk_product');
        }
        $inserted = 0; $updated = 0; $skipped = 0;
        foreach ($csvData as $row) {
            $productName = trim($row['Product'] ?? '');
            if ($productName === '') { $skipped++; continue; }
            // Resolve sub-category from CSV 'Category' column and auto-get category_id
            $subCatName = trim($row['Category'] ?? $row['SubCategory'] ?? '');
            $subCat     = $subCatName !== '' ? getSubCategoryIdByName($subCatName) : null;
            $categoryId = $subCat ? $subCat->category_id : 0;
            $subCatId   = $subCat ? $subCat->id : 0;
            $price          = isset($row['Price'])         ? trim($row['Price'])         : 0;
            // $wholesalePrice = isset($row['WholesalePrice'])? trim($row['WholesalePrice']): $price;
            // $retailerPrice  = isset($row['RetailerPrice']) ? trim($row['RetailerPrice']) : $price;
            $data = array(
                'product_name'    => $productName,
                'product_slug'    => url_title(strtolower($productName), '-'),
                'product_code'    => isset($row['Barcode'])      ? trim($row['Barcode'])      : '',
                'category_id'     => $categoryId,
                'sub_cat_id'      => $subCatId,
                'price'           => $price,
                // 'wholesale_price' => $wholesalePrice,
                // 'retailer_price'  => $retailerPrice,
                'quantity'        => isset($row['Quantity'])     ? trim($row['Quantity'])     : 0,
                'description'     => isset($row['Description'])  ? trim($row['Description'])  : '',
                'status'          => 1,
                'meta_title'          => trim($row['MetaTitle'] ?? ''),
                'meta_description'    => trim($row['MetaDescription'] ?? ''),
                'meta_keywords'       => trim($row['MetaKeywords'] ?? ''),
                'h1_tag'              => trim($row['H1Tag'] ?? ''),
                'h2_tag'              => trim($row['H2Tag'] ?? ''),
                'h3_tag'              => trim($row['H3Tag'] ?? ''),
                'robots'              => trim($row['Robots'] ?? ''),
                'canonical'           => trim($row['Canonical'] ?? ''),
                'og_title'            => trim($row['OgTitle'] ?? ''),
                'og_description'      => trim($row['OgDescription'] ?? ''),
                'og_image'            => trim($row['OgImage'] ?? ''),
                'og_url'              => trim($row['OgUrl'] ?? ''),
                'og_site_name'        => trim($row['OgSiteName'] ?? ''),
                'og_locale'           => trim($row['OgLocale'] ?? ''),
                'og_type'             => trim($row['OgType'] ?? ''),
                'og_tag'              => trim($row['OgTag'] ?? ''),
                'author'              => trim($row['Author'] ?? ''),
                'twitter_site'        => trim($row['TwitterSite'] ?? ''),
                'twitter_description' => trim($row['TwitterDescription'] ?? ''),
                'facebook'            => trim($row['Facebook'] ?? ''),
                'instagram'           => trim($row['Instagram'] ?? ''),
                'youtube'             => trim($row['Youtube'] ?? ''),
            );
            $existing = $this->db->where('product_name', $productName)->get($this->table)->row();
            if ($existing) {
                $this->db->where('id', $existing->id)->update($this->table, $data);
                $updated++;
            } else {
                $data['addedOn']   = date('Y-m-d H:i:s');
                $data['updatedOn'] = date('Y-m-d H:i:s');
                $this->db->insert($this->table, $data);
                $inserted++;
            }
        }
        $msg = 'Import complete. Inserted: ' . $inserted . ', Updated: ' . $updated;
        if ($skipped) $msg .= ', Skipped (empty name): ' . $skipped;
        $this->session->set_flashdata('response', '<div class="alert alert-success">' . $msg . '</div>');
        redirect($this->controller);
    }

    /* ---- FRONT-END ---- */

    public function all_products() {
        $limit  = PER_PAGE_DATA;
        $search = $this->input->get('search');
        $pageNo = (int)($this->input->get('page') ?: 0);
        $offset = $limit * $pageNo;

        $allProducts = $this->Product_model->getAllProducts($limit, $offset, $search);
        foreach ($allProducts as &$r) { $r['_source'] = 'ai'; }
        unset($r);
        $totalCount = $this->Product_model->countAllProducts($search);

        $data['allProducts']        = $allProducts;
        $data['totalCount']         = $totalCount;
        $data['pageCount']          = ceil($totalCount / $limit);
        $data['currentPage']        = $pageNo;
        $data['baseUrl']            = base_url('all-products');
        $data['isActiveCategories'] = getAllRootCategories();
        $data['pageTitle']          = 'All Products';
        $this->load->view('template/front/header', $data);
        $this->load->view('category/category_list', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function product_detail($slug) {
        $data['productDetails']    = $this->Product_model->getProductBySlug($slug);
        $data['productVariants']   = !empty($data['productDetails']) ? $this->Product_model->getVariantsByProduct($data['productDetails']['id']) : array();
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('product/product_detail', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function cart_list() {
        $front = $this->session->userdata('front_logged_in');
        if ($front) {
            $data['allCartProducts'] = $this->Product_model->getUserCartProduct($front['id']);
            $data['isGuest']         = false;
        } else {
            $guest_id = get_cookie('guest_cart_id');
            $data['allCartProducts'] = $guest_id ? $this->Product_model->getGuestCartProducts($guest_id) : array();
            $data['isGuest']         = true;
        }
        $data['isActiveCategories'] = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('product/cart_list', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function cart_checkout() {
        if (!$this->session->userdata('front_logged_in')) {
            redirect('sign-in?redirect=checkout');
        }
        $user_id = $this->session->userdata('front_logged_in')['id'];
        $front   = $this->session->userdata('front_logged_in');
        $data['billingArr']         = getUserBillingDetails($user_id);
        $rawSubTotal                = $this->Product_model->getUserCartSubTotal($user_id);
        $data['subTotal']           = $rawSubTotal * 1.20;
        $data['isActiveCategories'] = getAllRootCategories();
        $data['userInfo']           = $front;
        $this->load->view('template/front/header', $data);
        $this->load->view('product/cart_checkout', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function addItemIntoCart() {
        $front         = $this->session->userdata('front_logged_in');
        $product_id    = (int)$this->input->post('product_id');
        $quantity      = max(1, (int)$this->input->post('quantity'));
        $variant_label = trim($this->input->post('variant_label'));
        $variant_price = floatval($this->input->post('variant_price'));
        $replace       = (bool)$this->input->post('replace'); // set to 1 to overwrite qty instead of increment
        $product       = $this->Product_model->getProductById($product_id);
        if (!$product) { echo json_encode(array('status' => 'error')); return; }

        $variant_label = $variant_label !== '' ? $variant_label : NULL;
        $price         = $variant_price > 0 ? $variant_price : floatval($product['price']);

        if ($front) {
            $user_id  = $front['id'];
            $userType = $front['user_type'] ?? 'person';
            if ($variant_price <= 0) {
                if ($userType === 'business' && $product['wholesale_price'] > 0)
                    $price = floatval($product['wholesale_price']);
                elseif ($product['retailer_price'] > 0)
                    $price = floatval($product['retailer_price']);
            }
            $existing = $this->Product_model->checkCartProduct($product_id, $user_id, $variant_label);
            if ($existing) {
                $newQty = $replace ? $quantity : $existing['quantity'] + $quantity;
                $this->db->where('id', $existing['id'])->update('tbl_cart', array(
                    'quantity'      => $newQty,
                    'amount'        => $newQty * $price,
                    'variant_price' => $variant_price > 0 ? $variant_price : NULL,
                ));
            } else {
                $this->db->insert('tbl_cart', array(
                    'product_id'    => $product_id,
                    'user_id'       => $user_id,
                    'guest_id'      => NULL,
                    'quantity'      => $quantity,
                    'amount'        => $quantity * $price,
                    'variant_label' => $variant_label,
                    'variant_price' => $variant_price > 0 ? $variant_price : NULL,
                    'addedOn'       => date('Y-m-d H:i:s'),
                ));
            }
        } else {
            $guest_id = get_cookie('guest_cart_id');
            if (!$guest_id) {
                $guest_id = md5(uniqid(mt_rand(), true));
                set_cookie('guest_cart_id', $guest_id, 60 * 60 * 24 * 30);
            }
            $existing = $this->Product_model->checkGuestCartProduct($product_id, $guest_id, $variant_label);
            if ($existing) {
                $newQty = $replace ? $quantity : $existing['quantity'] + $quantity;
                $this->db->where('id', $existing['id'])->update('tbl_cart', array(
                    'quantity'      => $newQty,
                    'amount'        => $newQty * $price,
                    'variant_price' => $variant_price > 0 ? $variant_price : NULL,
                ));
            } else {
                $this->db->insert('tbl_cart', array(
                    'product_id'    => $product_id,
                    'user_id'       => 0,
                    'guest_id'      => $guest_id,
                    'quantity'      => $quantity,
                    'amount'        => $quantity * $price,
                    'variant_label' => $variant_label,
                    'variant_price' => $variant_price > 0 ? $variant_price : NULL,
                    'addedOn'       => date('Y-m-d H:i:s'),
                ));
            }
        }
        echo json_encode(array('status' => 'added'));
    }

    public function ajax_merge_guest_cart() {
        $front = $this->session->userdata('front_logged_in');
        if (!$front) { echo 'error'; return; }
        $guest_id = get_cookie('guest_cart_id');
        if ($guest_id) {
            $this->Product_model->mergeGuestCartToUser($guest_id, $front['id'], $front['user_type'] ?? 'person');
            delete_cookie('guest_cart_id');
        }
        echo 'ok';
    }

    public function delete_cart_product($id) {
        $front = $this->session->userdata('front_logged_in');
        if ($front) {
            $this->Product_model->deleteCartProduct($id);
        } else {
            $guest_id = get_cookie('guest_cart_id');
            if ($guest_id) $this->Product_model->deleteGuestCartProduct($id, $guest_id);
        }
        redirect('cart-list');
    }

    public function wish_list() {
        $front   = $this->session->userdata('front_logged_in');
        $perPage = 8;
        $pageNo  = (int)($this->input->get('page') ?: 0);
        $offset  = $perPage * $pageNo;
        $total   = $front ? $this->Product_model->countUserWishlist($front['id']) : 0;
        $data['allWishlistProducts'] = $front ? $this->Product_model->getWishlistPaginated($front['id'], $perPage, $offset) : array();
        $data['wlTotalCount']        = $total;
        $data['wlPageCount']         = ceil($total / $perPage);
        $data['wlCurrentPage']       = $pageNo;
        $data['isActiveCategories']  = getAllRootCategories();
        $this->load->view('template/front/header', $data);
        $this->load->view('product/wish_list', $data);
        $this->load->view('template/front/footer', $data);
    }

    public function addWishlistProduct() {
        $front = $this->session->userdata('front_logged_in');
        if (!$front) { echo 'login'; return; }
        $product_id = $this->input->post('product_id');
        $user_id    = $front['id'];
        $exists = $this->Product_model->checkWishlistProduct($product_id, $user_id);
        if ($exists) {
            $this->db->where('product_id', $product_id)->where('user_id', $user_id)->delete('tbl_wishlist_product');
            echo 'deleted';
        } else {
            $this->db->insert('tbl_wishlist_product', array('product_id' => $product_id, 'user_id' => $user_id, 'addedOn' => date('Y-m-d H:i:s')));
            echo 'added';
        }
    }

    public function place_user_order_item() {
        if (!$this->session->userdata('front_logged_in')) { echo 'login'; return; }
        $user_id           = $this->session->userdata('front_logged_in')['id'];
        $payment_method    = $this->input->post('payment_method');
        $billing_address_id = $this->input->post('billing_address_id');
        $orderId = $this->Product_model->placeOrder($user_id, $payment_method, $billing_address_id);
        if ($orderId) {
            $this->Product_model->deleteAllUserCart($user_id);
            echo $orderId;
        } else {
            echo 'error';
        }
    }

    public function stripe_payment() {
        if (!$this->session->userdata('front_logged_in')) { echo json_encode(['status'=>'login']); return; }
        $user_id            = $this->session->userdata('front_logged_in')['id'];
        $stripe_token       = $this->input->post('stripe_token');
        $billing_address_id = $this->input->post('billing_address_id');
        $special_instructions = $this->input->post('special_instructions');
        $delivery_option    = $this->input->post('delivery_option');
        $subTotal           = $this->Product_model->getUserCartSubTotal($user_id) * 1.20;
        $amount_pence       = (int)round($subTotal * 100);

        require_once APPPATH . 'libraries/Stripe/init.php';
        \Stripe\Stripe::setApiKey(STRIPE_SECRET_KEY);
        try {
            $charge = \Stripe\Charge::create([
                'amount'      => $amount_pence,
                'currency'    => 'gbp',
                'source'      => $stripe_token,
                'description' => 'AI Wholesale Order',
            ]);
            if ($charge->status === 'succeeded') {
                $orderId = $this->Product_model->placeOrder($user_id, 'stripe', $billing_address_id, $special_instructions, $delivery_option, $charge->id);
                if ($orderId) {
                    $this->Product_model->deleteAllUserCart($user_id);
                    echo json_encode(['status'=>'success','order_id'=>$orderId]);
                } else {
                    echo json_encode(['status'=>'error','msg'=>'Order creation failed']);
                }
            } else {
                echo json_encode(['status'=>'error','msg'=>'Payment not completed']);
            }
        } catch (Exception $e) {
            echo json_encode(['status'=>'error','msg'=>$e->getMessage()]);
        }
    }
}
