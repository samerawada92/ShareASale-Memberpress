<!-- Swap THE ID With Your Thank You Page ID -->
<?php if (is_page('XXXX')): ?>
    <script>
        $(document).ready(function(){
            // Get Value
            var query = window.location.href;
            var index_hash = query.indexOf("#");
            query = query.substring(index_hash);
            var value_query_hash = query.indexOf("=");
            var value = query.substring(value_query_hash + 1); // amount=value

            // Get Tracking
            var query_2 = window.location.href
            var trans_num_index_one = query_2.indexOf("trans_num=");
            var trans_num_index_two = query_2.indexOf("&membership_id");
            var trans_num = query_2.substring(trans_num_index_one + 10, trans_num_index_two); // transnum

            // Send To ShareASale
            if (trans_num_index_one > 0 && index_hash > 0) {
              // Build Tracking String
                var tracking_string = jQuery('#track_share_a_sale');
                tracking_string.attr('src' , 'https://shareasale.com/sale.cfm?amount='+value+'&tracking='+trans_num+'&transtype=sale&merchantID=80230');
            }else{
              console.log("Not a ShareASale Transaction");
            }
        })
    </script>
<?php endif; ?>
