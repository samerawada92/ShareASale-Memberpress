<h2>API CALL References</h2>
<ul>
  <li>action = reference</li>
  <li>date = format mm/dd/yyyy date of reference trans</li>
  <li>ordernumber = order number for reference trans</li>
  <li>transtype = sale or lead</li>
  <li>amount = order total</li>
  <li>tracking = order number</li>
  <li>persale = optional override commission percentage</li>
  <li>perlead = optional override commission amount</li>
</ul>
<strong>Example: https://api.shareasale.com/w.cfm?merchantId=80230&token=XWk5nd6t8YCdrh7s&version=2.8&action=reference&date=06/09/2018&ordernumber=xxxx&transtype=sale&amount=xx.xx&tracking=xxxxxx</strong>

<h2>Note:</h2>
<p>Make sure that you are passing the initial transaction number on that thank you page to ShareASale. You can do this using JS. I simply dropped the script in the footer_script.php file on the footer of the theme. All you have to do is swap the ID
in the first line with your thank you page ID.</p>

<p>Also I pass in the value of the transaction from the checkout form to the header. This way the correct amount can be passed to ShareASale. You can do so in your membepress file located at: /plugins/memberpress/app/views/checkout/form.php </p>
