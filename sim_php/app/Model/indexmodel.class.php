<?php
class IndexModel extends Model{
    function getArt($aid = 1, $mid = 1) {
        if ($mid == 0) {
            $wh = "menu_id = $mid and enable = 1";
        } else {
            $wh = "enable = 1";
        }
        return M('article')->field('id,menu_id,title,sub_title,content,modify_time,read,love')->where("id = $aid and $wh")->find();
    }
}
