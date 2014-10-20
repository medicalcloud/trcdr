<?php
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');  
}

function ph($string) {
    echo(h($string));
}

function p($string) {
    echo($string);
}
function tag($string) {
    echo('<'.h($string).'>');
}

function tagEnd($string) {
    echo('</'.h($string).'>');
}

class Links{
    public function __construct(){
        $this->counter = 0;
    }
    public function p($label, $target){}
}

class LinksToUrl extends Links{
    public function p($label, $target){ #target = URL
        echo('<a href="'.$targer.'" id="link'.$this->counter.'">'.h($label).'</a>');
        $this->counter++;
    }
}

class LinksToShowOne extends Links{
    public function p($label, $target){
        echo('<a href="index.php?id='.$target.'" id="linkToShow'.$this->counter.'">'.h($label).'</a>');
        $this->counter++;
    }
}
        
class LinksToEdit extends Links{
    public function p($label, $target){
        echo('<a href="edit.php?id='.$target.'" id="linkToEdit'.$this->counter.'">'.h($label).'</a>');
        $this->counter++;
    }
}

class ButtonsToRemove extends Links{
    public function p($label, $target){
        echo('<form action="index.php?id='.h($target).'" method="post">');
        echo('<input type="hidden" name="_method" value="delete">');
        echo('<input type="submit" id="buttonToRemove'.$this->counter.'" value="'.$label.'">');
        echo('</form>');
        $this->counter++;
    }
}

class Buttons extends Links{
    public function p($label, $target){
        echo('<form action="'.$target.'" method="post">');
        echo('<input type="submit" id="button'.$this->counter.'" value="'.$label.'">');
        echo('</form>');
        $this->counter++;
    }
}

class LinksToNew extends Links{
    public function p($label, $target = ""){
        echo('<a href="new.php" id="linkToNew'.$this->counter.'">'.h($label).'</a>');
        $this->counter++;
    }
}

class LinksToShowMany extends Links{
    public function p($label, $target = "") {
        echo('<a href="index.php" id="linkToShowMany'.$this->counter.'">'.h($label).'</a>');
        $this->counter++;
    }
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

    public function slider($name, $value, $min, $max, $step) {
        echo '<input type="range" id="'.$name.'" name="'.$name.'" value="'.$value.'" min="'.$min.'" max="'.$max.'" step="'.$step.'">';
    }

    public function submitButton($buttonLabel) {
        echo '<input type="submit" id="submitButton" value="'.$buttonLabel.'">';
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

function backPage($value){
    global $page;
    if($page > 1){
        echo '<a href="index.php?page='.((int)$page - 1).'">'.$value.'</a>';
    }
}

function nextPage($value){
    global $page;
    echo '<a href="index.php?page='.((int)$page + 1).'">'.$value.'</a>';
}
