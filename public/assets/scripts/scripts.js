const root_url = '/'
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
                $('#product-' + product_id).text(t=>t-=quantity)
                $('.user-orders-count').text(t=>t+=1)
            },
            error(err, message){

            }
        })
    }
    $('#list-products .pay-btn').on('click', ()=>{
        const product_id = $(this).data('product-id')
        const user_id = $(this).data('user-id')
        
    })






})