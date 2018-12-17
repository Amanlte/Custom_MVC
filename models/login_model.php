<?php

class Login_Model extends Model {

    public function __construct() {
        parent::__construct();
        Session::init();
    }

    public function _run() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sth = $this->db->prepare("SELECT * FROM users WHERE user_login_name = :username AND user_password = :password");
        $sth->execute(array(
            ':username' => $username,
            ':password' => Hash::create('sha256', $password, HASH_PASSWORD_KEY)


        ));

        $data = $sth->fetch();

        $count = $sth->rowCount();
        if ($count > 0) {
            Session::set('logedIn', true);
            $pagesArray = array();
            $pagesTemp = array();
            $pagesId = array();
            $funcsId = array();

            $smPageIds = array();
            $subMenuTemp = array();
            $subMenuIds = array();
            $subMenuIdInsm = array();
            $disSubMenu = array();
            $disMainMenuName = array();
            // to set session for each columuns
            for ($info = 0; $info < $sth->columnCount(); $info++) {
                $col = $sth->getColumnMeta($info);
                $columns[] = $col['name'];
                Session::set($columns[$info], $data[$info]);
            }
            $roleId = $this->db->prepare("SELECT fun_id FROM role_functionality WHERE role_id = :rid");
            $roleId->execute(array(
                ':rid' => Session::get('user_role')
            ));
            $allFuncId = $roleId->fetch(PDO::FETCH_ASSOC);
            Session::set('func', $allFuncId['fun_id']);
            $funcId = $allFuncId['fun_id'];
            $funcId = explode(',', $funcId);
            foreach ($funcId as $eachFuncId) {
                $funcName = $this->db->prepare("SELECT func_name FROM functionality WHERE func_id = :fid");
                $funcName->execute(array(
                    ':fid' => $eachFuncId
                ));
                $funcNames = $funcName->fetch(PDO::FETCH_ASSOC);
                Session::set($funcNames['func_name'], true);

                //Getting all pages for each sub menu
                $page = $this->db->prepare("SELECT page_id, fun_id, page FROM page WHERE fun_id = :fid");
                $page->execute(array(
                    ':fid' => $eachFuncId
                ));
                $pages = $page->fetch(PDO::FETCH_ASSOC);
                $pageName = $pages['page'];
                $pageName = explode(',', $pageName);
                foreach ($pageName as $eachPageName) {
                    array_push($pagesArray, $eachPageName);
                }

                // it is to get the fun id for sub menu relationship
                $funcId = $pages['fun_id'];
                array_push($funcsId, $funcId);

                // it is to get the page id for sub menu relationship
                $pageId = $pages['page_id'];
                array_push($pagesId, $pageId);
            }

            //Getting the main menu from sub menu
            $smenu = $this->db->prepare("SELECT sub_menu_id, sub_menu_name, functionalities_id FROM sub_menu");
            $smenu->execute();
            while ($sm = $smenu->fetch(PDO::FETCH_ASSOC)) {
                $smenuName = $sm['sub_menu_name'];
                $smId = $sm['sub_menu_id'];
                $smPageId = $sm['functionalities_id'];
                $smPageId = explode(",", $smPageId);
                foreach ($smPageId as $eachsmPageId) {
                    foreach ($funcsId as $eachSubMenu) {
                        if ($eachsmPageId == $eachSubMenu) {
                            $page = $this->db->prepare("SELECT page FROM page WHERE fun_id = :fid");
                            $page->execute(array(
                                ':fid' => $eachSubMenu
                            ));
                            $pages = $page->fetch(PDO::FETCH_ASSOC);
                            $pageName = $pages['page'];
                            $pageName = explode(',', $pageName);
                            foreach ($pageName as $key => $eachPageName) {
                                // to fetch and push pages to array for each sub menus
                                array_push($pagesTemp, $eachPageName);
                            }
                        }
                        if ($eachsmPageId == $eachSubMenu) {
                            array_push($disSubMenu, $smenuName);
                            array_push($subMenuIdInsm, $smId);
                            array_push($smPageIds, $eachsmPageId);
                        }
                    }
                }
                $pagesTemp = array_unique($pagesTemp); // to distnict the array values
                Session::set($smenuName, $pagesTemp);
                $pagesTemp = array();
            }

            //Getting the displayed main menu name
            $mmenu = $this->db->prepare("SELECT main_menu_name, sub_menu_id FROM menu");
            $mmenu->execute();
            while ($mm = $mmenu->fetch(PDO::FETCH_ASSOC)) {
                $mmenuName = $mm['main_menu_name'];
                $subMenuId = $mm['sub_menu_id'];
                $subMenuIde = explode(",", $subMenuId);
                if ($subMenuId != "") {
                    foreach ($subMenuIdInsm as $eachsubMenuIdInsm) {
                        foreach ($subMenuIde as $eachsubMenuId) {
                            if ($eachsubMenuIdInsm == $eachsubMenuId) {
                                $smenu = $this->db->prepare("SELECT sub_menu_name FROM sub_menu WHERE sub_menu_id = :smId");
                                $smenu->execute(array(
                                    ':smId' => $eachsubMenuIdInsm));
                                $sm = $smenu->fetch(PDO::FETCH_ASSOC);
                                $smenuName = $sm['sub_menu_name'];
                                array_push($subMenuTemp, $smenuName);
                                array_push($disMainMenuName, $mmenuName);
                            }
                        }
                    }
                    $subMenuTemp = array_unique($subMenuTemp); // to distnict the array values
                    Session::set($mmenuName, $subMenuTemp);
                    $subMenuTemp = array();
                }
            }

            $disMainMenuName = array_unique($disMainMenuName); // to distnict the array values
            /*
             * Assign the arrays to a session for later use
             */
            Session::set('allPages', $pagesArray);
            Session::set('allmm', $disMainMenuName);
//            if ($data[9] == 0) {
//                 echo "<script>window.open('".URL."flogin','resizable=no,menubar=no,toolbar=no,location=no,status=no');</script>";
//            } else {
                header('location: ../dashboard');
//            }
        } else {
            Session::set('loginError', true);
            header('location: ../login');
        }
    }

}
