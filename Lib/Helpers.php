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

function tagEnd($string) {
    echo('</'.h($string).'>');
}

function linkToUrl($string, $url) {
    echo('<a href="'.$url.'" id="link_to_'.$url.'">'.h($string).'</a>');
}

function linkToShowOne($string, $id) {
    echo('<a href="index.php?id='.$id.'" id="link_to_show_'.$id.'">'.h($string).'</a>');
}

function linkToEdit($string, $id) {
    echo('<a href="edit.php?id='.$id.'" id="link_to_edit_'.$id.'">'.h($string).'</a>');
}

function buttonToRemove($button_label, $id) {
    echo('<form action="index.php?id='.h($id).'" method="post">');
    echo('<input type="hidden" name="_method" value="delete">');
    echo('<input type="submit" id="button_to_remove_'.$id.'" value="'.$button_label.'">');
    echo('</form>');
}

function button($button_label, $url) {
    echo('<form action="'.$url.'" method="post">');
    echo('<input type="submit" id="button_to_'.$url.'" value="'.$button_label.'">');
    echo('</form>');
}



function linkToNew($string) {
    echo('<a href="new.php" id="link_to_new">'.h($string).'</a>');
}

function linkToShowMany($string) {
    echo('<a href="index.php" id="link_to_show_many">'.h($string).'</a>');
}

class Table {
    public function __construct() {
        echo('<table>');
    }

    public function tr() {
        echo('<tr>');
    }

    public function trEnd() {
        echo('</tr>');
    }

    public function td() {
        echo('<td>');
    }

    public function tdEnd() {
        echo('</td>');
    }

    public function tableEnd() {
        echo('</table>');
    }
}

class Form {
    public function __construct($id=null) {
        if($id === null){
            echo '<form action="index.php?" method="post">';
        }else{
            echo '<form action="index.php?id='.h($id).'" method="post">';
            echo '<input type="hidden" name="_method" value="put">';
        }
    }

    public function textbox($name, $value) {
        echo '<input type="text" id="'.$name.'" name="'.$name.'" value="'.$value.'">';
    }

    public function submitButton($buttonLabel) {
        echo '<input type="submit" id="submit_button" value="'.$buttonLabel.'">';
    }

    public function formEnd() {
        echo('</form>');
    }
}

function renderPart($partname) {
    Pathes::renderPart($partname);
}

function loginToggleLink($session, $userModelName, $login = 'login', $logout = 'logout'){
    $pDir = Pathes::getBaseUrl().'/'.$userModelName.'/';
    if($session->isLogedIn()){
        echo '<a href="'.$pDir.'logout.php">'.$logout.'</a>';
    }else{
        echo '<a href="'.$pDir.'login.php">'.$login.'</a>';
    }
}
