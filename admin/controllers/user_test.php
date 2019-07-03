<?php
    if ($_SESSION['admin'] != 'Admin' && $_SESSION['admin'] != 'Moderator'){
        $f->redir('index.php');
    }else{
        $xtpa = new XTemplate("views/user_test.html");
        $condition = "1 = 1";
        if(isset($_POST['btnDel'])){
            //If 'Delete All' button is clicked
            if(isset($_POST['ck'])){
                $ls = implode(', ',$_POST['ck']);
                $sql = "DELETE FROM users WHERE id IN ({$ls})";
                $db->execSQL($sql);
            }
        }else if(isset($_GET['s'])){
            //If 'Search Button' is clicked
            $str = $_GET['s'];
            $search_val = str_replace('+','',$str);
            if ($str == 'Male' || $str == 'Female') $condition .= " AND gender = '{$search_val}' ";
            else{
                $str = str_replace('+','%',$str);
                $str = '%'.$str.'%';
                $condition .= " AND username LIKE '{$str}' OR email LIKE '{$str}' OR firstName LIKE '{$str}' OR CONCAT(firstName, ' ', lastName) LIKE '{$str}' OR lastName LIKE '{$str}' OR position LIKE '{$str}' OR admin_level LIKE '{$str}'";
            }
            $xtpa->assign('search',$search_val);
        }
        //Fetch all entries from DB with condition created above
        $user = $db->fetch("SELECT * FROM users WHERE {$condition}");
        $t = count($user);
        $l = 10;
        $page = (isset($_GET['page']))?$_GET['page']:1;
        $offset = ($page - 1) * $l;
        $condition .= " ORDER BY id ASC LIMIT {$offset}, {$l} ";
        $url = 'a=user_test';
        //Fetch only 10 entries from DB with condition and limit as above
        $user = $db->fetch("SELECT * FROM users WHERE {$condition}");
        $pager = $f->paging($url,$t,$l,'pager', (isset($_GET['s']))?$_GET['s']:'');
        if (count($user) > 0){
            $i = $offset + 1;
            foreach($user as $r){
                $r['no'] = $i;
                $r['dob'] = implode('/',array_reverse(explode('-',$r['dob'])));
                $slAdmin = ($r['admin_level'] === 'Admin')?'selected':'';
                $slModerator = ($r['admin_level'] === 'Moderator')?'selected':'';
                $slNormal = ($r['admin_level'] === 'Normal')?'selected':'';  
                //Restrict the action user can take depend on their level
                //Moderator can not change admin's level              
                if ($_SESSION['admin'] == 'Moderator' && $r['admin_level'] === 'Admin'){
                    $r['update'] = "";
                    $r['select'] = $r['admin_level'];
                }
                //Admin can change all users's level and can set other to admin
                else if ($_SESSION['admin'] === 'Admin'){
                    $r['update'] = "<a href='javascript:void()' onclick='setLevel("."{$r['id']}, {$r['no']}".")'>Update</a>";
                    $r['select'] = "<select id='admin_level' class='form-control' name='slAdminLevel' required>
                                    <option value='' hidden>Level</option>
                                    <option value='Admin' {$slAdmin}>Admin</option>
                                    <option value='Moderator' {$slModerator}>Moderator</option>
                                    <option value='Normal' {$slNormal}>Normal</option>
                                </select>";
                }
                //Moderator can only set other to moderator at max, can not set to admin
                else{
                    $r['update'] = "<a href='javascript:void()' onclick='setLevel("."{$r['id']}, {$r['no']}".")'>Update</a>";
                    $r['select'] = "<select id='admin_level' class='form-control' name='slAdminLevel' required>
                                    <option value='' hidden>Level</option>
                                    <option value='Moderator' {$slModerator}>Moderator</option>
                                    <option value='Normal' {$slNormal}>Normal</option>
                                </select>";
                }
                $xtpa->insert_loop("ADMIN.LS", array('LS' => $r));
                $i++;
            }
        }
        $xtpl->assign("title", "User test");
        $xtpa->assign('page',$pager);
        $xtpa->parse("ADMIN");
        $content = $xtpa-> text("ADMIN");
    }