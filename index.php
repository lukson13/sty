<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="main.css">
    <title>Document</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns"
        crossorigin="anonymous">
    <link rel="stylesheet" href="jquery-confirm.min.css">
    <script src="./JS/jquery-3.3.1.min.js"></script>
    <script src="./JS/popper.min.js"></script>
    <script src="./JS/jquery.form.min.js"></script>
    <script src="./JS/jquery-confirm.min.js"></script>
    <script src="./JS/handlebars-v4.0.12.js"></script>

    <script id="ques-temp" type="text/x-handlebars-template">
        <div id="q_{{id}}" class="qitem box-shadow">
            <div class="content box box-shadow">
                <p>Pytanie {{nr}}</p>
                <textarea class="textarea" name="pytanie[{{id}}][pytanie]"></textarea>
            </div>

            <div class="answer box box-shadow">
            <p>Odpowiedzi</p>
            </div>
            <div class="addanswer box box-shadow">
                <i class="fas fa-plus fa-3x"></i>
                <p>Add new answer</p>
            </div>
        </div>
    </script>
    
    <script id="ans-temp" type="text/x-handlebars-template">
        <div id="{{oid}}" class="aitem">
            <i class="fas fa-times fa-2x"></i>
            <textarea name="pytanie[{{id}}][odp][{{oid}}][con]" class="textarea"></textarea>
            <label>
                <input type="checkbox" name="pytanie[{{id}}][odp][{{oid}}][check]">
                <i class="fas fa-check fa-2x"></i>
            </label>
        </div>
    </script>


    <script>
        $(document).ready(function () {
            $("#addQuestion").click(function (e) {
                e.preventDefault();
                let ida;
                let id;
                if($("#questions").children().length < 1){
                    id = 0;
                }else{
                    ida = $("#questions").children().last().attr("id").split("_");
                    id = Number(ida[ida.length - 1]) +1;
                }
                let ques = null;
                ques =  $(Handlebars.compile($("#ques-temp").html())({ id: id , nr: id+1}));
                let as = ques.find(".addanswer").siblings(".answer");
                ques.find(".addanswer").bind('click', function (){
                    let ide;
                    let ie;
                    if($("#q_"+id).children(".answer").children().length > 1){
                        ide = $("#q_0").children(".answer").children().last().attr("id").split("_");
                        ie = Number(ide[ide.length - 1]) + 1;
                        console.log("i: " + ie );
                    }else{
                        ie = 0;
                        console.log("e")
                    }
                    let ans = $(Handlebars.compile($("#ans-temp").html())({ id: id, oid: ie }));
                    as.append(ans);
                    ans.find('.fa-times').bind('click', function (){
                        ans.remove();
                    });
                });
                $("#questions").append(ques);

            });
            $("#toPDF").click(function (e) { 
                e.preventDefault();
                $("#send").click();
            });
            $("#form").submit(function (e) { 
                e.preventDefault();
                $("#form").ajaxSubmit({
                    success: function(data){
                        $.alert({
                            title: 'Alert!',
                            boxWidth: '50%',
                            content: '<a href="./gentest/' + data + '">Test</a>',
                        });
                    }
                });
                return false;
            });
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <nav>
            <div id="toPDF" class="box- box box-shadow">
                <p>Generate PDF</p>
            </div>
            <div class="box- box box-shadow">
                <p>Generate HTML</p>
            </div>
            <div class="box- box box-shadow">
                <p>Save to JSON</p>
            </div>
            <div class="box- box box-shadow">
                <p>Load from JSON</p>
            </div>
        </nav>
        <form id="form" action="generator.php" method="post">
            <div id="questions" class="questions">

            </div>
            <button id="send" type="submit" style="display: none;"></button>
        </form>
        <div id="addQuestion" class="addquestion box box-shadow">
            <i class="fas fa-plus fa-3x"></i><p>Add new question</p>
        </div>
    </div>
</body>
</html>