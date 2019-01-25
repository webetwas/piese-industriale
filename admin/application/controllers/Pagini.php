<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pagini extends CI_Controller {
  /**
	 * [private Controller]
	 * @var [type]
	 */
	private $controller;
  private $controller_ajax;

	/**
	 * [private URI - Segment]
	 * @var [type]
	 */
	private $uriseg;

  public function __construct() {
    parent::__construct();
    // Your own constructor code

    $this->controller = $this->router->fetch_class();//Controller
    $this->controller_ajax = $this->controller;
		$this->uriseg = json_decode(json_encode($this->uri->uri_to_assoc(2)));

    if(!$this->user->id) redirect("login");

    $this->load->model('Pagini_model', '_Pagini');// model/_Pagini
    $this->load->model("Item_model", "_Item");// model/_Item
	$this->load->model("Upload_model", "_Upload");// model/_Upload
	$this->load->model("Banner_model", "_Banner"); // model/_Banner
	$this->load->model("Slug_model", "_Slug");
		
		// $this->load->helper("urlu_helper");
  }

	/**
	 * [index description]
	 * @return [type] [description]
	 */
  public function index()
  {
    echo "pagini";die();
  }

  public function Item()
  {
    $this->controller = $this->controller. "/" .$this->router->fetch_method();
		/**
		  * [$viewdata CORE]
		  * @var array
		  */ $viewdata = array("controller" => $this->controller, "controller_ajax" => $this->controller_ajax. "/ajax", "page" => null, "uri" => null, "form" => (object) []);
		$viewdata["uri"] = $this->uriseg;
		
		$viewdata["imgpathbanner"] = SITE_URL.PATH_IMG_BANNERS;
		$viewdata["imgpathpage"] = SITE_URL.PATH_IMG_PAGINA."m/";
    // var_dump($this->uriseg);

    switch($this->uriseg->item)
    {
			
			case DELETE:
			
				if(isset($this->uriseg->id) && !is_null($this->uriseg->id)) {
					
					$delete = $this->_Pagini->RemovePage(intval($this->uriseg->id));
					if($delete) {
						
						$this->_Session->setFB_Pozitive(array("ref" => "Pagini", "text" => "Pagina a fost stearsa!"));
					}
				}
				redirect('/');
					
			break;
			
			case INSERT:
        // FORM - NEW Item - Page
        $viewdata["form"]->item = (object) ["name" => "item", "prefix" => "it", "segments" => $this->controller. "/" .$this->uriseg->item];
        $form_submititem = $viewdata["form"]->item->prefix. "submit";//submit<button>
				
				/* form @item */
        if(isset($_REQUEST["{$form_submititem}"])) {
				
					$slug = $this->_Slug->slug_it('fe_pages', $this->input->post("{$viewdata["form"]->item->prefix}title"));
					
					// var_dump($idhttp_url);die();
					
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => "fe_pages",
						"database" => INSERT,
						"type" => PUT,
						"design" => array(
							"id_page" => $slug,
							"slug" => $slug,
							"title" => true,
							"title_ro" => trim($this->input->post("{$viewdata["form"]->item->prefix}title")),
							"title_browser_ro" => trim($this->input->post("{$viewdata["form"]->item->prefix}title"))
						)
					]; $insert = $this->_Item->INSItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern);// insert@Page
					if($insert) $this->_Session->setFB_Pozitive(array("ref" => "Pagini", "text" => "Ai creat pagina noua!"));
					if($insert) {
						
						//create structure
						$this->_Pagini->insertStructure($insert);
					}
					redirect($this->controller. "/u/id/" .$insert. '/' .$slug);
				/* form @meta */
        }				
				
			break;
			
      case UPDATE:
				
				$page = $this->_Pagini->GetPagina(trim($this->uriseg->id));
				
				// echo "<pre>";
				// var_dump($page);
				// echo "</pre>";
				// die();
				
        // FORM - NEW Item - Page
        $viewdata["form"]->item = (object) ["name" => "item", "prefix" => "it", "segments" => $this->controller. "/" .$this->uriseg->item. "/id/" .$this->uriseg->id];
        $form_submititem = $viewdata["form"]->item->prefix. "submit";//submit<button>
				
        // FORM - NEW Item - Page Meta
        $viewdata["form"]->meta = (object) ["name" => "meta", "prefix" => "mt", "segments" => $this->controller. "/" .$this->uriseg->item. "/id/" .$this->uriseg->id];
        $form_submitmeta = $viewdata["form"]->meta->prefix. "submit";//submit<button>
				
        // FORM - NEW Structura - Page Structure
        $viewdata["form"]->structura = (object) ["name" => "structura", "prefix" => "st", "segments" => $this->controller. "/" .$this->uriseg->item. "/id/" .$this->uriseg->id];
        $form_submitstructura = $viewdata["form"]->structura->prefix. "submit";//submit<button>
				
				/* form @item */
        if(isset($_REQUEST["{$form_submititem}"])) {

					$newDBPattern = (object) [ // Design Database Pattern
						"table" => "fe_pages",
						"database" => UPDATE,
						"type" => PUT,
						"design" => array(
							"content_ro" => true,
							"content_en" => true,
							"title_content_ro" => true,
							"title_content_en" => true,
							"subtitle_content_ro" => true
						)
					]; $update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->item->prefix, $newDBPattern, $this->uriseg->id);// update@Page
					if($update) $this->_Session->setFB_Pozitive(array("ref" => "Continutul Paginii", "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->item->segments);
				/* form @meta */
        } elseif(isset($_REQUEST["{$form_submitmeta}"])) {
					
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => "fe_pages",
						"database" => UPDATE,
						"type" => PUT,
						"design" => array(
							"admin_message" => true,
							"title" => true,
							"title_ro" => true,
							"title_en" => true,
							"title_browser_ro" => true,
							"meta_description" => true,
							"keywords" => true
						)
					]; $update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->meta->prefix, $newDBPattern, $this->uriseg->id);// update@PageStructure
					if($update) $this->_Session->setFB_Pozitive(array("ref" => "Metadata Pagina", "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->meta->segments);
				/* form @structura */
				} elseif(isset($_REQUEST["{$form_submitstructura}"])) {
					
					$newDBPattern = (object) [ // Design Database Pattern
						"table" => "fe_pages_structure",
						"database" => UPDATE,
						"type" => GET,
						"design" => array()
					]; $update = $this->_Item->UPItem($newDBPattern->table, $viewdata["form"]->structura->prefix, $newDBPattern, array('c' => "idpage", 'v' => $this->uriseg->id));// update@PageStructure
					if($update) $this->_Session->setFB_Pozitive(array("ref" => "Structura Pagina", "text" => "Modificarile tale au fost salvate!"));
					redirect($viewdata["form"]->structura->segments);
				}

        if($page) {
					$banners = $this->_Banner->fetchAssocByRef(TBL_PAGES_BANNERS, array("idpage" => $page["p"]->id));
					if($banners) $page["b"] = $banners;//assign@b
					
					$viewdata["page"] = json_decode(json_encode($page));//load page to Viewdata
        } else show_404();
      break;
   }
		//breacrumb
		$breadcrumb = array("bb_titlu" => "Pagini site", "bb_button" => null, "bb_buttondel" => null, "breadcrumb" => array());
		if(isset($page) && $page && $page["s"]->filehtml == "pagina") {
			

			$breadcrumb["bb_buttondel"] = array("text" => '<i class="fa fa-trash"></i> Sterge pagina', "linkhref" => $this->controller ."/d/id/" .$page["p"]->id);
		}
		
		$breadcrumb["breadcrumb"][0] = array("text" => "Pagini", "url" => '');
		$breadcrumb["breadcrumb"][1] = array("text" => $this->uriseg->item == "i" ? 'Pagina noua' : $page["p"]->title, "url" => null);
    $view = (object) [ 'html' => array(
			0 => (object) ["viewhtml" => "layout/breadcrumb", "viewdata" => $breadcrumb],
      1 => (object) ["viewhtml" => $this->uriseg->item == "i" ? 'pagini/creazapagina' : "pagini/pagina", "viewdata" => $viewdata]
      ), 'javascript' => array(
      1 => (object) ["viewhtml" => "pagini/js_pagina", "viewdata" => null],
      )
    ];
    $this->frontend->render($view);
  }


	/**
	 * [Ajax description]
	 */
  public function Ajax() {
		if(!empty($this->uriseg->ajax) && isset($this->uriseg->id) && !is_null($this->uriseg->id))
	    switch($this->uriseg->ajax)
			{
				case UPLOADIMG:
					$res = array("status" => 0, "id" => null);
					$inputfile = "inpfile";
					$filetarget = trim($this->input->post("filetarget"));//@banner@poza
					$fileref = trim($this->input->post("fileref"));//@banner1@banner2
					
					$pagestruct = $this->_Pagini->getStructure("array", trim(intval($this->uriseg->id)));//getpagestructure
					$locations = (object) ["table" => null, "path" => null];
					$imaginaryfolder = null;//usetrueformultiplefiles[s,m,l]
					$filesdata = null;
					$insertdata = null;
					switch($this->input->post("filetarget"))
					{
						case UPIMGBANNER:
							$locations->table = TBL_PAGES_BANNERS;
							$locations->path = '../web/' .PATH_IMG_BANNERS;
							
							$width = !is_null($pagestruct[$fileref. '_w']) ? $pagestruct[$fileref. '_w'] : json_decode(constant("IMG_SIZE_" .strtoupper($fileref)))->width;
							$height = !is_null($pagestruct[$fileref. '_h']) ? $pagestruct[$fileref. '_h'] : json_decode(constant("IMG_SIZE_" .strtoupper($fileref)))->height;
							$proportion = $pagestruct[$fileref. '_p'] == "1" ? true : json_decode(constant("IMG_SIZE_" .strtoupper($fileref)))->proportion;
							
							$filesdata = array($fileref => array("w" => $width, "h" => $height, "p" => $proportion));
						break;
						case UPIMGPOZA:
							$locations->table = TBL_PAGES_IMAGES;
							$locations->path = '../web/' .PATH_IMG_PAGINA;
							$imaginaryfolder = array("s" => true, "m" => true, "l" => true);
							
							$filesdata = array(
								"s" => array("w" => null, "h" => null, "p" => null),
								"m" => array("w" => null, "h" => null, "p" => null),
								"l" => array("w" => null, "h" => null, "p" => null)
							);
							foreach($filesdata as $kd => $d) {
								foreach($d as $kdd => $dd) {
									$db_format = "image_" .$kd.$kdd;//databasecolumn
									$filesdata[$kd][$kdd] = !is_null($pagestruct[$db_format]) ? $pagestruct[$db_format] : json_decode(constant("IMG_SIZE_" .strtoupper($kd)), true)[$kdd];
									
									if($kdd == "p")
										$filesdata[$kd][$kdd] = $pagestruct[$db_format] == "1" ? true : json_decode(constant("IMG_SIZE_" .strtoupper($kd)), true)[$kdd];
								}
							}
						break;
					}
					if(!is_null($filesdata)) {
						$upimgs = $this->_Upload->uploadImage($locations->path, $filesdata, $imaginaryfolder);//uploadimages
						if($upimgs["img"]) {
							$res["status"] = 1;
							$res["img"] = $upimgs["img"];
							
							$insertdata = array("idpage" => trim(intval($this->uriseg->id)), "img" => $upimgs["img"], "img_ref" => $fileref);
							if(!is_null($imaginaryfolder))
								foreach($imaginaryfolder as $kifolder => $ifolder) $insertdata[$kifolder] = $ifolder;//pushimaginaryfoldertoinsertdata
							
							$insertitem = $this->_Item->msqlInsert($locations->table, $insertdata);
							if($insertitem) $res["id"] = $insertitem;
						}
					}
					echo json_encode($res);
				break;
				case DELETE:
					$res = array("status" => 0);

					$fileid = trim($this->input->post("fileid"));
					$fileref = trim($this->input->post("fileref"));// reference could be "banner1" for "banner"
					
					$locations = (object) ["table" => null, "path" => null];
					$imaginaryfolder = null;//usetrueformultiplefiles[s,m,l]

					//remove Banner
					if(strstr($fileref, "banner")) {
						$locations->path = '../web/' .PATH_IMG_BANNERS;
						$locations->table = TBL_PAGES_BANNERS;
					}
					//remove Poza
					if(strstr($fileref, "poza")) {
						$locations->path = '../web/' .PATH_IMG_PAGINA;
						$locations->table = TBL_PAGES_IMAGES;
						$imaginaryfolder = array("s" => true, "m" => true, "l" => true);
					}
					
					$deleteitem = $this->_Item->RetrieveAndRemove($locations->table, array("id" => intval(trim($fileid)), "idpage" => intval(trim($this->uriseg->id))));
					if($deleteitem) {
						deletefile('../web/' .$locations->path, $deleteitem->img, $imaginaryfolder);

						$res["status"] = 1;
					}					
					echo json_encode($res);
				break;
				
				case BANNERFDATA:
					$res = array("status" => 0);
					
					if(isset($this->uriseg->ajax) && !is_null($this->uriseg->ajax)) {
						
						$ref = !empty($this->input->post("ref")) ? trim($this->input->post("ref")) : null;
						
						$ti = !empty($this->input->post("ti")) ? trim($this->input->post("ti")) : null;
						$sti = !empty($this->input->post("sti")) ? trim($this->input->post("sti")) : null;
						$href1 = !empty($this->input->post("href1")) ? trim($this->input->post("href1")) : null;
						$thref1 = !empty($this->input->post("thref1")) ? trim($this->input->post("thref1")) : null;
						
						if(!is_null($ref)) {
							$data = array("titlu" => $ti, "subtitlu" => $sti, "href1" => $href1, "thref1" => $thref1);
							$conditions = array("idpage" => intval(trim($this->uriseg->id)), "img_ref" => $ref);
							
							
							$updateBanner = $this->_Banner->updateBannerFDATA($data, $conditions);
							if($updateBanner) $res["status"] = 1;
						}
					}
					echo json_encode($res);
				break;
			}
		else show_404();
  }
}
