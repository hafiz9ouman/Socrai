
<html><body>
                <img style="background:black;" src="{{env('APP_URL')}}/frontend/assets/images/logo.png" alt="Contact Inquiry" />
                <table rules="all" style="border-color: #666;" cellpadding="10">
                
<tr><td colspan="2"><strong><h3>Request to join the tribe has been declined</h3></strong> </td></tr>
<tr><td colspan="2">&nbsp; </td></tr>
                <tr style='background: #eee;'><td><strong>Name:</strong> </td><td><?php echo $name; ?></td></tr>
                <tr><td><strong>Email:</strong> </td><td><?php echo $email; ?></td></tr>


                    <tr><td><strong>Message :</strong> </td><td>Sorry to inform you that your request to join <?php echo $title; ?> is declined by admin </td></tr>

                </table>
                </body></html>
	
