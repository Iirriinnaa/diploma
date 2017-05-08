
$(document).ready(function(){
    GetQuestion();
    $('#QuestionDIV').on('click', '#next', function(){
        GetQuestion();
    });
});


function GetQuestion () {
    // $val1=$('#id_test').val();
    var answer= new Array ();
    var flag=false;
    if ($('input.answer').length >0) {
        $('input.answer:checked').each(function (index, el) {
            answer.push(el.value);
            flag = true;
        });
        if (flag) {
            $.ajax(
                {
                    url: 'GetQuestion.php', // адрес вызываемой страницы
                    type: 'post', // тип отправки данных
                    dataType: 'html', // тип получения данных
                    data: {answer: answer}, // отправляемые данные
                    success: function (data) // если передача успешна
                    {
                        $("#QuestionDIV").empty();
                        $("#QuestionDIV").append(data); // вывести полученные данные
                    }
                });
        }
        else alert('Выберите варант ответа');
    } else
    {
        $.ajax(
            {
                url: 'GetQuestion.php', // адрес вызываемой страницы
                type: 'post', // тип отправки данных
                dataType: 'html', // тип получения данных
                success: function (data) // если передача успешна
                {
                    $("#QuestionDIV").empty();
                    $("#QuestionDIV").append(data); // вывести полученные данные
                }
            });
    }
}