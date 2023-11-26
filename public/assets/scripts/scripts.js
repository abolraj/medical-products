const root_url = 'http://localhost:8080'
$(document).ready($ => {
    // Handle the pay product action
    function pay_product(product_id, user_id, quantity){
        $.ajax({
            url: root_url + '/products/' + product_id + '/pay',
            method: 'POST',
            dataType: 'json',
            data: {
                user_id,
                quantity,
            },
            success(response){
                $('#product-' + product_id + ' .quantity').text((i,t)=>t-quantity)
                $('.user-orders-count').text((i,t)=>+t+1)
                $('#pay-product-modal').prop('open', false)
                console.log('success',response)
            },
            error(err, message){
                console.log('error', message, err)
            }
        })
    }
    $('#list-products .pay-btn').on('click', function(){
        const product_id = $(this).data('product-id')
        const user_id = $(this).data('user-id')
        const quantity = $(this).data('quantity')
        document.getElementById('pay-product-modal').showModal();
        $('#pay-product-modal .btn-pay').data('product_id', product_id)
        $('#pay-product-modal .btn-pay').data('user_id', user_id)
        $('#pay-product-modal .range').attr('max', quantity)
        $('#pay-product-modal .range-modifiers').empty()
        for(let i=0; i<quantity; i++){
            $('<span>').text('|').appendTo('#pay-product-modal .range-modifiers')
        }
        
    })

    $('#pay-product-modal .range').on('input', function(){
        $('#pay-product-modal .quantity-count').text($(this).val())
    })

    // Pay modal
    $('#pay-product-modal .btn-pay').on('click', function(){
        const product_id = $(this).data('product_id')
        const user_id = $(this).data('user_id')
        const quantity = $('#pay-product-modal .range').val()
        pay_product(product_id, user_id, quantity)
    })





})