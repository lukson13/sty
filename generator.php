<?php
$html =
'<!DOCTYPE html>
<html lang="pl-PL">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Document</title>
</head>
<body>
    <div class="wrapper">
        <div class="title box">
            <h1>{{title}}</h1>
        </div>
        <div class="questions box">
            {{questions}}
        </div>
    </div>
</body>
</html>';

$questemplate =
'<div class="question">
    <h4>{{question-content}}</h4>
    <div class="answers">
        {{answers}}
    </div>
</div>';

$answertemplate =
'<div class="answer">
    <p>{{answer-content}}</p>
</div>';

require './phpL/Quiz.php';

$pytanie = $_POST['pytanie'];

$quiz = new Quiz();

foreach ($pytanie as $value) {
    $q = new Question($value['pytanie']);
    if(isset($value['odp'])){
        foreach ($value['odp'] as $odp){
        $a = new Answer($odp['con']);
        if(isset($odp['check'])){
            $a->setCorrect();
        }
        $q->addAnswer($a);
    }
    }
    $quiz->addQuestion($q);
}
$questions = '';
foreach ($quiz->getQuestions() as $value) {
    $answers = '';
    $tempq = $questemplate;
    $tempq =str_replace('{{question-content}}', $value->getNr() . ". " . rNl($value->getQuestion()), $tempq);

    foreach ($value->getAnswer() as $val) {
        $tempa = $answertemplate;
        $tempa = str_replace('{{answer-content}}', cNtA($val->getNr()) . ") " . rNl($val->getAnswer()), $tempa);
        $answers = $answers . "$tempa\n";
    }
    $tempq = str_replace('{{answers}}', $answers, $tempq);
    $questions = $questions . "$tempq\n";
}
$temphtml = $html;
$temphtml = str_replace('{{questions}}', $questions, $temphtml);
$catalog = "./gentest/";
$uid = uniqid("test_");
$uid = "$uid.html";
echo $uid;
file_put_contents("$catalog/$uid", "$temphtml <!--Generated file>");

exit;
