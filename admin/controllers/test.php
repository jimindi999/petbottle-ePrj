<?php
    //use to test various code
    $xtpas = new XTemplate("views/test.html");
    $do_save = 1;
    // $cat_name = $db->fetchAll('tblcategories','1=1');
    // foreach($cat_name as $c){
    //     $xtpas->insert_loop("ADD_SONG.LIST_CAT",array("LS"=>$c));
    // }
    if($_POST){
        $song_name = $_POST['txtNameSong'];
        $name_singer = $_POST['txtSinger'];
        $name_genre  = $_POST['lsGenre'];
        $song_des    = $_POST['txtDes'];
        $mp3_name     = $_FILES['txtMp3']['name'];
        $mp3_ext      = pathinfo($mp3_name, PATHINFO_EXTENSION);
        $mp3_new_name = substr($mp3_name, 0, - strlen($mp3_ext) - 1)."_".time().".".$mp3_ext;
        $mp3_tmp      = $_FILES['txtMp3']['tmp_name'];
        $mp3_size     = $_FILES['txtMp3']['size'];
        $mp3_size_litmit = 300000000;
        $ext_arr      = array('mp3');
        if( move_uploaded_file($mp3_tmp,"upload/song/".$mp3_new_name)){
            $url = $baseUrl."upload/song/".$mp3_new_name;
            $do_save = 1;
        }else{
            $do_save = -5;
            echo "NO GET LINK!";
        }
        
        // if($db->checkExitst('tblartists'," fullname = '{$name_singer}'") == 'NO'){
        //    $ar['fullname'] = "'{$name_singer}'";
        //     if($valid->isName($name_singer) == 'YES'){
        //         $db->insert('tblartists',$ar);
        //     }
        // }
        // $sql1 = "SELECT id FROM tblartists WHERE fullname = '{$name_singer}'";
        // $id_singer = $db->fetch($sql1);
        // $id_singer = $id_singer[0]['id'];
        
        // $sql2 = "SELECT id FROM tblcategories WHERE cat_name = '{$name_genre}'";
        // $id_genre = $db->fetch($sql2);
        // $id_genre = $id_genre[0]['id'];
        // if(strlen($song_name) <= 0){
        //     $do_save = -2;
        //     $mess_name_song = 'Name Song is Invalid!';
        //     $xtpas->assign('mess_name_song',$mess_name_song);
        // }
        // $xtpas->assign('nameSong',$song_name);

        // $arr['song_name'] = "'{$song_name}'";
        // $arr['id_singer'] = "'{$id_singer}'";
        // $arr['id_cat']    = "'{$id_genre}'";
        // $arr['song_url']  = "'{$url}'";
        // $arr['song_des']  = "'{$song_des}'";   
        // if($do_save == 1){
        //     $db->insert('tblSongs',$arr);
        //     echo "sucessfull!<br>";
        //     echo $name_genre;
        // }
    }
    $xtpas->parse('ADD_SONG');
    $content = $xtpas->text('ADD_SONG');