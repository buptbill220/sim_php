<?php
class CONF {
    //项目定义
    const NAME      = "nstfp";

    //字体定义
    const F_CLOSE   = "\033[0m";
    const F_OPEN    = "\033[1m";
    const F_LINE    = "\033[4m";
    const F_GLINT   = "\033[5m";
    const F_BACK    = "\033[";
    const F_FORE    = "";
    const F_B_BLK   = "40;";
    const F_B_WHT   = "47;";
    const F_B_BLUE  = "44;";
    const F_B_GREN  = "42;";
    const F_F_BLK   = "30m";
    const F_F_WHT   = "37m";
    const F_F_RED   = "31m";
    const F_F_GREN  = "36m";
    const F_F_YELL  = "33m";
    const F_F_BLUE  = "34m";

    //路径定义
    const P_H_BIN   = "/usr/local/bin/";
    const P_H_LIB   = "/usr/local/lib64/";
    const P_L_BIN   = "./bin/";
    const P_L_CORE  = "./core/";
    const P_L_DATA  = "./testdatas/";
    const P_L_CASE  = "./testcases/";
    const P_L_CONF  = "./conf/";
    const P_L_LOGS  = "./logs/";
    const P_L_REST  = "./results/";

    //时间格式定义
    const T_FUL     = "Ymd_His";
    const T_FUL1    = "Y/m/d H:i:s";
    const T_YMD     = "Ymd";
    const T_YMD1    = "Y-m-d";
    const T_YMD2    = "Y/m/d";
    const T_DAY        = "H:i:s";

    //tdbm定义
    const P_TDBM    = "/home/a/bin64/";
    const P_TDBM_I  = "/home/a/bin64/tdbm_import";
    const P_TDBM_E  = "/home/a/bin64/tdbm_export";
    const p_TDBM_R  = "/home/a/bin64/tdbm_replace";
    const P_TDBM_T  = "/home/a/bin64/tdbm_txt2db";
}
