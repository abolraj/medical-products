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
                window.location.reload()
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
        const offer = $(this).data('product-offer')
        const price = $(this).data('product-price')
        document.getElementById('pay-product-modal').showModal();
        $('#pay-product-modal .btn-pay').data('product_id', product_id)
        $('#pay-product-modal .btn-pay').data('user_id', user_id)
        $('#pay-product-modal .btn-pay').data('price', price)
        $('#pay-product-modal .range').attr('max', quantity)
        if(offer){
            $('#pay-product-modal .btn-pay').data('offer', offer)
            $('#pay-product-modal .badge-offer').show()
            $('#pay-product-modal .badge-offer .offer-value').text(offer)
        }else{
            $('#pay-product-modal .badge-offer').hide()
        }
        $('#pay-product-modal .badge-price .price-value').val(offer)
        $('#pay-product-modal .range-modifiers').empty()
        for(let i=0; i<quantity; i++){
            $('<span>').text('|').appendTo('#pay-product-modal .range-modifiers')
        }
        
    })

    $('#pay-product-modal .range').on('input', function(){
        const quantity = $(this).val()
        let price = $("#pay-product-modal .btn-pay").data('price')
        const offer = $("#pay-product-modal .btn-pay").data('offer')
        if(!!offer){
            price = Math.ceil(price * (100 - offer) / 100)
        }
        price *= quantity
        $('#pay-product-modal .quantity-count').text(quantity)
        $('#pay-product-modal .badge-price .price-value').text(price)

    })

    // Pay modal
    $('#pay-product-modal .btn-pay').on('click', function(){
        const product_id = $(this).data('product_id')
        const user_id = $(this).data('user_id')
        const quantity = $('#pay-product-modal .range').val()
        pay_product(product_id, user_id, quantity)
    })





})