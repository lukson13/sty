<?php
function cNtA($num){
    $alphas = range('a', 'z');
    return $alphas[$num-1];
}
function rNl($str){
    return trim(preg_replace('/\s\s+/', ' ', $str));
}

class Answer {
    
    private $answer;
    private $correct = "N";
    private $nr;

    function __construct($content, $correct = "N", $nr = 1) {
        $this->answer = $content;
        $this->correct = $correct;
        $this->nr = $nr;
    }

    function getNr() {
        return $this->nr;
    }

    function setNr($nr) {
        $this->nr = $nr;
    }
    
    public function setCorrect($correct = "P"){
        $this->correct = $correct;
    }

    public function getAnswer(){
        return $this->answer;
    }
    public function getCorrect(){
        return $this->correct;
    }

}

class Question{
    protected $question;
    protected $answer = [];
    protected $nr;
    function __construct($content, $answer=[], $nr = 1) {
        $this->question = $content;
        $this->answer = $answer;
        $this->nr = $nr;
    }
    
    public function getNr() {
        return $this->nr;
    }

    public function setNr($nr) {
        $this->nr = $nr;
    }

    public function getQuestion(){
        return $this->question;
    }
    public function getAnswer(){
        return $this->answer;
    }
    public function addAnswer($an){
        $an->setNr((count($this->answer) + 1));
        array_push($this->answer, $an);
    }
}

class Quiz {
    
    protected $title;
    protected $questions = [];
            
    function __construct($title="untitled", $questions=[]) {
        $this->title = $title;
        $this->questions = $questions;
    }
    
    public function addQuestion($question){
        $question->setNr((count($this->questions)+1));
        array_push($this->questions, $question);
    }
    
    public function setTitle($title){
        $this->title = $title;
    }
    public function getTitle(){
        return $this->title;
    }
    public function getQuestions(){
        return $this->questions;
    }
    
}