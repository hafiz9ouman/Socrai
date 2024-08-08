<html><body>
                <img style="background:black;" src="{{env('APP_URL')}}/frontend/assets/images/logo.png" alt="Password Change Request" />
                <table rules="all" style="border-color: #666;" cellpadding="10">
                <tr style='background: #eee;'><td><strong>Name:</strong> </td><td>{{strip_tags($name)}}</td></tr>
                <tr><td><strong>Email:</strong> </td><td>{{strip_tags($email)}}</td></tr>


                    <tr><td><strong></strong> </td><td>New Password : {{strip_tags( $password)}}  </td></tr>

                
                </table>
                </body></html>