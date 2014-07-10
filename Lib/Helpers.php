<?php
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');  
}

function ph($string) {
    echo(h($string));
}

function tag($string) {
    echo('<'.h($string).'>');
}

function tag_end($string) {
    echo('</'.h($string).'>');
}

function link_to_url($string, $url) {
    echo('<a href="'.$url.'">'.h($string).'</a>');
}

function link_to_show_one($string, $id) {
    echo('<a href="index.php?id='.$id.'">'.h($string).'</a>');
}

function link_to_edit($string, $id) {
    echo('<a href="edit.php?id='.$id.'">'.h($string).'</a>');
}

function button_to_remove($string, $id) {
    echo('<form action="index.php?id='.h($id).'" method="post">');
    echo('<input type="hidden" name="_method" value="delete">');
    echo('<input type="submit" value="'.$string.'">');
    echo('</form>');
}


function link_to_new($string) {
    print('<a href="new.php">'.h($string).'</a>');
}

function link_to_show_many($string) {
    print('<a href="index.php">'.h($string).'</a>');
}

class Table {
    public function __construct() {
        print('<table>');
    }

    public function tr() {
        print('<tr>');
    }

    public function tr_end() {
        print('</tr>');
    }

    public function td() {
        print('<td>');
    }

    public function td_end() {
        print('</td>');
    }

    public function table_end() {
        print('</table>');
    }
}

class Form {
    public function __construct() {
        print('<form>');
    }

    public function form_end() {
        print('</form>');
    }
}

