$(document).ready(function(){
    var Form = $('punish');
    var Input = $('input.player_name',Form)

    Input.change(function(event){
        Value = Input.val();
        if(Value.length > 5)
        {
            $.getJSON('check_name.php',{player_name:Value},function(response){
                if(response.valid == true)
                {
                    Form.find('input[type*=submit]').attr('disabled','false');
                }else
                {
                     Form.find('input[type*=submit]').attr('disabled','true');
                }
            });
        }
    });
});