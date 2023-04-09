<table 
    align="center" 
    border="0"
    cellpadding="0"
    cellspacing="0"
    width="100%"
>
    <tr>
        <td align="center" bgcolor="#70bbd9" style="padding: 10px 0 30px 0;">
            <img src="https://i.imgur.com/dZW6ydi.png" alt="Creating Email Magic" width="300" height="auto" style="display: block;" />
        </td>
    </tr>

    <tr>
        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td>
                        <h2> {{ trans('language.mail.register.title',[
                            'fullName' => isset($user->full_name) ? $user->full_name : ''
                            ]) }}
                    </td>
                </tr>
                <tr>
                    <td style="padding: 20px 0 30px 0;">
                        {{ trans('language.mail.register.content.content_1') }}
                        <p>{{ trans('language.mail.register.content.mail_adress') }} <b>{{ $customer->email ?? 'example@gmail.com' }}</b></p>
                        <p>{{ trans('language.code') }} <b>{{ $code }}</b></p>
                        <p>
                            {{ trans('language.mail.register.content.content_2') }}
                        </p>

                    </td>
                </tr>
            </table>
        </td>
    </tr>
                
    <tr>
        <td bgcolor="#323422" style="padding: 30px 30px 30px 30px;">
            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="50%">
                    </td>
                       <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;">
                        &reg; 2023 Nguyễn Đức Thắng<br/>
                        {{ trans('language.author') }} 
                        <a href="" style="color: #ffffff;">
                            <font color="#ffffff"> {{ trans('language.website') }} </font>
                        </a>
                       </td>
                </tr>
               </table>
           </td>
    </tr>
</table>