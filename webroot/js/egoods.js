define(function(require){
    // Dependencies
     var $            = require('jquery');
     var jqueryvalidate = require('jqueryvalidate');
    setInterval(function(){
        $('#egood_download_count').load($('#egood_download_count').data('url'));
    }, 10000);
    $(document).ready(function() {
        $('.gtw-egoods .radio input[type="radio"]').on('change',function (){
            priceTypeSelection($(this).val());
        });
        priceTypeSelection($('input[name="data[Egood][type]"]:checked').val());
        $('#EGoodAddEditForm').validate({
            errorClass: "text-danger",
            rules:{
                    "data[Egood][title]":{
                        required: true
                    },
                    "data[Egood][description]":{
                        required: true
                    },
                    "data[Egood][price]":{
                        min: true,
                        required: true
                    }
            },
            messages:{
                    "data[Egood][title]":{
                            required: "Please enter Title"
                    },
                    "data[Egood][description]":{
                            required: "Please enter description"
                    },
                    "data[Egood][price]":{
                        min: 'Please enter positive price',
                        required: 'Please enter price'
                    }
            }
        });        
        function priceTypeSelection(val){
            $('.gtw-egoods .radio label').removeClass('btn-primary');
            $('#EgoodType'+val).parent('label').addClass('btn-primary');
            if(val==1){
                $('.egood-price').slideDown();
            }else{
                $('.egood-price').slideUp();
            }            
        }
    });
});
