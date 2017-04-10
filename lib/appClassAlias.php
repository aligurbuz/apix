<?php
class_alias("\\src\\store\\config\\app","app");
class_alias("\\src\\store\\services\\branches","branch");
class_alias("\\lib\\appContainer","container");
class_alias("\\src\\store\\services\\date","foo");
$extras=src\store\config\app::getAliasClasses();
if(count($extras)){
    foreach($extras as $key=>$value){
        class_alias($value,$key);
    }
}