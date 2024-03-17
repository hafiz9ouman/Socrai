<html><body>
                <img style="background:black;" src="{{env('APP_URL')}}/sucrai/assets/images/logo.png" alt="New User Signup" />
                <table rules="all" style="border-color: #666;" cellpadding="10">
                <tr style='background: #eee;'><td><strong>Name:</strong> </td><td>{{strip_tags($name)}}</td></tr>
                <tr><td><strong>Email:</strong> </td><td>{{strip_tags($email)}}</td></tr>


                    <tr><td><strong>Message :</strong> </td><td>Varification code is {{strip_tags( $new_pas)}}</td></tr>

                </table>
                </body></html>